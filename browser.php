<?php
$tab = 1;
include 'classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$vars['article'] = filter_var($_GET['article'],FILTER_SANITIZE_NUMBER_INT);
$vars['use'] = filter_var($_GET['use'],FILTER_SANITIZE_STRING);
$page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
$mode = filter_var($_GET['mode'], FILTER_SANITIZE_STRING);
$statusVar = filter_var($_GET['status'],FILTER_SANITIZE_STRING);

$facets = filter_var_array($_GET['column']);

if (!$page)
    $page = 1;

$query = filter_var(rawurldecode($_GET['query']), FILTER_SANITIZE_STRING);
if (!$query) {
    $query = '';
}
$holder = new Component();
$components = $holder->getByCommunity(0);

$vars['editmode'] = filter_var($_GET['editmode'],FILTER_SANITIZE_STRING);
if($vars['editmode']){
    if(!isset($_SESSION['user']) || $_SESSION['user']->role<1)
        $vars['editmode'] = false;
}

$vars['errorID'] = filter_var($_GET['errorID'],FILTER_SANITIZE_NUMBER_INT);
if($vars['errorID']){
    $errorID = new Error();
    $errorID->getByID($vars['errorID']);
    if(!$errorID->id){
        $errorID = false;
    }
}

switch ($type) {
    case 'communities':
        $title = 'Browse Communities';
        $searchText = 'Search for communities related to your interests';
        $hl_sub = 0;
        break;
    case 'resources':
        $title = 'Browse Resources';
        $searchText = 'Search for resources that meet your needs';
        $hl_sub = 1;
        $holder = new Resource_Fields();
        $fields = $holder->getPage1();
        break;
    case 'content':
        if ($filter) {
            switch ($filter) {
                case 'questions':
                    $title = 'Browse Questions';
                    $searchText = 'Search for previously asked questions';
                    break;
                case 'tutorials':
                    $title = 'Browse Tutorials';
                    $searchText = 'Search for tutorials to help you navigate SciCrunch';
                    break;
                default:
                    $holds = new Component();
                    $holds->getPageByType(0, $filter);
                    $title = 'Browse ' . $holds->text1;
                    $searchText = 'Search against all ' . $holds->text1;
                    break;
            }
        } else {
            $title = 'Browse SciCrunch Content';
            $locationPage = '/browse/content';
            $searchText = 'Search across all SciCrunch articles';
        }
        $hl_sub = 2;
        break;
}

// make sure user has rights to edit a resource
if($type == "resources"){
    $resource = new Resource();
    $resource->getByRID($id);
    $can_edit_resource = isset($_SESSION['user']) && ($_SESSION['user']->role > 0 || ($_SESSION['user']->id == $resource->uid));
    if($mode == "edit" && !$can_edit_resource){
        $previous_page = $_SERVER['HTTP_REFERER'];
        header("location:" . $previous_page); 
        exit;
    }
}


?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>SciCrunch | <?php echo $title ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/page_search_inner.css">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="/assets/css/shop/shop.blocks.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>

<div class="wrapper">
    <!-- Brand and toggle get grouped for better mobile display -->
    <?php include 'ssi/header.php' ?>
    <!--=== Breadcrumbs v3 ===-->
    <div class="breadcrumbs-v3">
        <div class="container">
            <h1 class="pull-left"><?php echo $title ?></h1>
            <ul class="pull-right breadcrumb">
                <li><a href="/">Home</a></li>
                <?php if ($id) { ?>
                    <li><a href="/browse/<?php echo $type ?>"><?php echo $title ?></a></li>
                    <li class="active">View Resource</li>
                <?php } else { ?>
                    <li class="active"><?php echo $title ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!--=== End Breadcrumbs v3 ===-->

    <!--=== Search Block Version 2 ===-->
    <?php if (!$id && (!$mode || $mode != 'edit')) { ?>
        <div class="search-block-v2" style="padding:30px 0 38px">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Search again</h2>

                    <form method="get" action="/browse/<?php echo $type ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query"
                                   placeholder="<?php echo $searchText ?>" value="<?php echo $query ?>">
                            <input type="hidden" name="filter" value="<?php echo $filter ?>"/>
                    <span class="input-group-btn">
                        <button class="btn-u" type="search"><i class="fa fa-search"></i></button>
                    </span>
                        </div>
                    </form>
                    <?php if($type=='resources'){?>
                    <p style="text-align: center;padding-top:10px;margin-bottom: 0">We support boolean queries, use +,-,<,>,~,* to alter the weighting of terms</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <!--/container-->
    <!--=== End Search Block Version 2 ===-->

    <!--=== Search Results ===-->
    <div class="container s-results margin-bottom-50">
        <div class="row">

            <?php if (!$id && (!$mode || $mode != 'edit')){ ?>
            <div class="col-md-2 hidden-xs related-search">
                <div class="row">
                    <div class="col-md-12 col-sm-4">
                        <?php if($type=='resources' && isset($_SESSION['user']) && $_SESSION['user']->role>0){
                            echo '<h3>Column Weighting</h3>';
                            echo '<form method="post" action="/forms/resource-forms/updateWeighting.php">';
                            foreach($fields as $field){
                                echo '<div class="row" style="padding:3px 0">';
                                echo '<div class="col-md-8">'.$field->name.'</div>';
                                echo '<div class="col-md-4"><input maxlength="2" size="2" style="width:30px;font-size:11px" name="'.$field->id.'" value="'.$field->weight.'"/></div>';
                                echo '</div>';
                            }
                            echo '<button type="submit" class="btn-u">Update</button>';
                            echo '</form>';
                            echo '<hr/>';
                        }?>
                        <h3>All Types</h3>
                        <ul class="list-unstyled">
                            <li <?php if ($type == 'communities') echo 'class="active"' ?>><a
                                    href="/browse/communities?query=<?php echo $query ?>">Communities</a></li>
                            <li <?php if ($type == 'resources') echo 'class="active"' ?>><a
                                    href="/browse/resources?query=<?php echo $query ?>">Resources</a></li>
                            <li <?php if ($type == 'content' && !$filter) echo 'class="active"' ?>><a
                                    href="/browse/content?query=<?php echo $query ?>">All Content</a></li>
                            <?php
                            foreach ($components['page'] as $compon) {
                                if ($type == 'content' && $filter == $compon->text2)
                                    echo '<li class="active"><a href="/browse/content?query=' . $query . '&filter=' . $compon->text2 . '">' . $compon->text1 . '</a></li>';
                                else
                                    echo '<li><a href="/browse/content?query=' . $query . '&filter=' . $compon->text2 . '">' . $compon->text1 . '</a></li>';
                            }
                            ?>
                        </ul>
                        <hr>
                    </div>
                    <?php if($type == 'content'){?>
                    <div class="col-md-12 col-sm-4">
                        <h3>Most Used Tags</h3>
                        <ul class="list-unstyled">
                            <?php
                            $holder = new Tag();
                            $tags = $holder->getPopularTags(false, 0, 0, 5);
                            foreach ($tags as $tag) {
                                echo '<li><a href="/browse/content?query=tag:' . $tag->tag . '"><i class="fa fa-tags"></i> ' . $tag->tag . '</a></li>';
                            }
                            ?>
                        </ul>
                        <hr>
                    </div>
                    <?php } elseif($type=='resources'){?>
                    <div class="col-md-12 col-sm-4">
                        <h3>Curation Status</h3>
                        <ul class="list-unstyled">
                            <?php
                            $holder = new Connection();
                            $holder->connect();
                            $curate = $holder->select('resources',array('status','count(status)'),null,array(),'where status is not null group by status order by status asc');
                            $holder->close();
                            foreach ($curate as $row) {
                                if($statusVar && $statusVar==$row['status'])
                                    echo '<li class="active"><a href="/browse/resources?status=' . $row['status'] . '">' . $row['status'].' ('.$row['count(status)'] . ')</a></li>';
                                else
                                    echo '<li><a href="/browse/resources?status=' . $row['status'] . '">' . $row['status'].' ('.$row['count(status)'] . ')</a></li>';
                            }
                            ?>
                        </ul>
                        <hr>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!--/col-md-2-->

            <div class="col-md-10">
                <?php
                } else {

                    echo '<div class="col-md-12" style="margin-top:30px">';
                }?>
                <?php
                switch ($type) {
                    case 'communities':
                        include 'browsing/communities.php';
                        break;
                    case 'content':
                        include 'browsing/content.php';
                        break;
                    case 'resources':
                        if($mode && $mode=='edit')
                            include 'browsing/registry-edit.php';
                        elseif ($id)
                            include 'browsing/resource-view.php';
                        else
                            include 'browsing/resources.php';
                        break;
                }
                ?>
            </div>
            <!--/col-md-10-->
        </div>
    </div>
    <!--/container-->
    <!--=== End Search Results ===-->

    <?php include 'ssi/footer.php' ?>
    <!--=== End Copyright ===-->
</div>
<!--/End Wrapepr-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

<script type="text/javascript" src="/assets/plugins/gmap/gmap.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin, <?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
    $('.inner-results p').truncate({max_length: 500});
</script>
<script>
    $('.truncate-desc').truncate({max_length: 500});
    $('.map').each(function(){
        var _this = $(this);
        var map,marker,infoWindow;
        map = new GMaps({
            div: '#'+$(_this).attr('id'),
            scrollwheel: false,
            lat: $(_this).attr('lat'),
            lng: $(_this).attr('lng')
        });
        infoWindow = new google.maps.InfoWindow({
            content: '<div style="height:40px">'+$(_this).attr('point')+'</div>'
        });
        marker = map.addMarker({
            lat: $(_this).attr('lat'),
            lng: $(_this).attr('lng'),
            title: $(_this).attr('point'),
            infoWindow: infoWindow
        });
        infoWindow.open(map, marker);
    });
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html> 
