<?php

$tab = 0;
include 'classes/classes.php';
session_start();
include 'vars/overview.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);


$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

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

$component = new Component();
$component->getPageByType(0,$type);


$holder = new Component();
$components = $holder->getByCommunity(0);

$hl_sub = $component->position+1;

$search = new Search();
$search->community = new Community();
$search->community->id = 0;
$search->community->shortName='SciCrunch';

if($id){
    $data = new Component_Data();
    $data->getByID($id);
    $data->addView();
    $title = $data->title;
    $locationPage = '/page/'.$component->text2.'/'.$id;
} else {
    $title = $component->text1;
    $locationPage = '/page/'.$component->text2;
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
    <title>SciCrunch | <?php echo $title?></title>

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
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css"/>
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/feature_timeline1.css">
    <link rel="stylesheet" href="/assets/css/pages/feature_timeline2.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
    <link rel="stylesheet" href="/assets/css/pages/blog.css">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        .column-search {
            display:none;
            position: absolute;
            top:100%;
            left:-1px;
            width:300px;
            background: #fff;
            border: 1px solid #999;
            z-index: 21;
        }
        .column-search-form {
            padding:20px;
        }
        .column-search p {
            margin:10px 20px;
        }

        .search-header:hover {
            cursor: pointer;
            text-decoration: underline;
        }
        .panel>.table-bordered>thead>tr:last-child>th, .panel>.table-responsive>.table-bordered>thead>tr:last-child>th {
            border-bottom: 1px solid #999;
        }
    </style>
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>
<div class="wrapper" <?php if($vars['editmode']) echo 'style="margin-top:30px;"'?>>
    <!--=== Header ===-->
    <?php include 'ssi/header.php' ?>
    <!--=== Breadcrumbs ===-->

    <?php
    $community = new Community();
    $community->portalName = 'SciCrunch';
    $community->id = 0;
    if (!$id) {
        include 'components/scicrunch-html/list.php';

    } else {
        include 'components/scicrunch-html/single.php';
     }?>

    <!--=== Footer ===-->
    <?php include 'ssi/footer.php' ?>
    <!--=== End Footer ===-->

    <!--=== End Copyright ===-->
    <div class="background"></div>
</div>
<!--/wrapper-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/summernote/summernote.js"></script>
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/profile.js"></script>
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin,<?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('td').truncate({max_length: 200});
        $('.content-load-btn').click(function(){
            var cid = $(this).attr('cid');
            var type = $(this).attr('type');
            var num = $(this).attr('num');
            var comp = $(this).attr('comp');
            $('.'+type+' .clearfix').remove();
            $('.content-load-div').load('/php/content-loader.php?cid='+cid+'&num='+num+'&comp='+comp,function(){
                $('.'+type).append($('.content-load-div').html());
                if(type=='timeline-v1')
                    $('.'+type).append('<li class="clearfix" style="float: none;"></li>');
            });
            $('.content-load-btn').attr('num',parseInt(num)+10);
        });
    });
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html>	
