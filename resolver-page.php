<?php
$tab = 0;
$hl_sub = -4;
include 'classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);


if (!$page)
    $page = 1;

$query = filter_var(rawurldecode($_GET['query']), FILTER_SANITIZE_STRING);
if (!$query) {
    $query = '*';
}
$holder = new Component();
$components = $holder->getByCommunity(0);

$vars['editmode'] = filter_var($_GET['editmode'], FILTER_SANITIZE_STRING);
if ($vars['editmode']) {
    if (!isset($_SESSION['user']) || $_SESSION['user']->role < 1)
        $vars['editmode'] = false;
}

$vars['errorID'] = filter_var($_GET['errorID'], FILTER_SANITIZE_NUMBER_INT);
if ($vars['errorID']) {
    $errorID = new Error();
    $errorID->getByID($vars['errorID']);
    if (!$errorID->id) {
        $errorID = false;
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
    <title>SciCrunch | RRID Resolver</title>

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
            <h1 class="pull-left">Search for RRIDs</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="/">Home</a></li>
                <?php if ($id) { ?>
                    <li><a href="/resolver/<?php echo $type ?>">Search for RRIDs</a></li>
                    <li class="active">View Resource</li>
                <?php } else { ?>
                    <li class="active">Search for RRIDs</li>
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

                    <form method="get" action="/resolver">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query"
                                   placeholder="<?php echo $searchText ?>" value="<?php echo $query ?>">
                            <input type="hidden" name="filter" value="<?php echo $filter ?>"/>
                    <span class="input-group-btn">
                        <button class="btn-u" type="search"><i class="fa fa-search"></i></button>
                    </span>
                        </div>
                    </form>
                    <?php if ($type == 'resources') { ?>
                        <p style="text-align: center;padding-top:10px;margin-bottom: 0">We support boolean queries, use
                            +,-,<,>,~,* to alter the weighting of terms</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <!--/container-->
    <!--=== End Search Block Version 2 ===-->
    <?php
    if($id)
        include 'ssi/pages/rrid-item.php';
    else
        include 'ssi/pages/rrid-search.php';
    ?>
</div>
<!--/End Wrapepr-->

<?php include 'ssi/footer.php'; ?>

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
    $('.map').each(function () {
        var _this = $(this);
        var map, marker, infoWindow;
        map = new GMaps({
            div: '#' + $(_this).attr('id'),
            scrollwheel: false,
            lat: $(_this).attr('lat'),
            lng: $(_this).attr('lng')
        });
        infoWindow = new google.maps.InfoWindow({
            content: '<div style="height:40px">' + $(_this).attr('point') + '</div>'
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
