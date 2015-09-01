<?php
$tab = 0;
$hl_sub = -3;
include 'classes/classes.php';
session_start();
include 'vars/overview.php';
$holder = new Component();
$components = $holder->getByCommunity(0);
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

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

if($id){
    $data = new Component_Data();
    $data->getByID($id);
    $component = new Component();
    $component->component = $data->component;
} elseif($type){
    $holder = new Component_Data();
    $component = new Component();
    if($type=='questions'){
        $results = $holder->getByComponent(104,0,0,20);
        $theTitle = 'Questions';
        $component->component = 104;
    } elseif($type=='tutorials'){
        $results = $holder->getByComponent(105,0,0,20);
        $theTitle = 'Tutorials';
        $component->component = 105;
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
    <title>SciCrunch | FAQs</title>

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

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/page_faq1.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
    <link href="/assets/css/pages/blog_masonry_3col.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>
<div class="wrapper">
<!--=== Header ===-->
<?php include 'ssi/header.php'; ?>
<!--=== End Header ===-->

    <?php

    if($id){
        include 'faqs/single.php';
    } elseif($type){
        include 'faqs/list.php';
    } else {
        include 'faqs/home.php';
    }
    ?>

<!--/container-->
<!--=== End FAQ Content ===-->

<?php include 'ssi/footer.php'; ?>
<!--=== End Copyright ===-->
</div>
<!--/End Wrapepr-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery.parallax.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/plugins/masonry/jquery.masonry.min.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript" src="/assets/js/pages/blog-masonry.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        App.initParallaxBg();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin,<?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html> 
