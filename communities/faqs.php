<?php
$tab = 0;
$hl_sub = -3;
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$faq = $vars['id'];
$id = $vars['article'];

$components = $community->components;

$search = new Search();
$search->community = $community;

if($id){
    $data = new Component_Data();
    $data->getByID($id);
    $thisComp = new Component();
    $thisComp->component = $data->component;
} elseif($faq){
    $holder = new Component_Data();
    $thisComp = new Component();
    if($faq=='questions'){
        $results = $holder->getByComponent(104,$community->id,0,20);
        $theTitle = 'Questions';
        $thisComp->component = 104;
        $thisComp->icon1 = 'question';
    } elseif($faq=='tutorials'){
        $results = $holder->getByComponent(105,$community->id,0,20);
        $theTitle = 'Tutorials';
        $thisComp->component = 105;
        $thisComp->icon1 = 'tutorial';
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
    <title><?php echo $community->shortName?> | FAQs</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/css/community-search.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css"/>

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
<div class="wrapper" <?php if($vars['editmode']) echo 'style="margin-top:32px;"' ?>>
    <!--=== Header ===-->
    <?php

    if(count($components['header'])==1){
        $component = $components['header'][0];
        if($component->component==0)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-normal.php';
        elseif($component->component==1)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-boxed.php';
        elseif($component->component==2)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-float.php';
        elseif($component->component==3)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-flat.php';
    } else
        include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-normal.php';
    ?>
    <!--=== End Header ===-->

    <?php
    if (count($components['breadcrumbs']) > 0) {
        $component = $components['breadcrumbs'][0];
        include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/blocks/breadcrumbs.php';
    }

    if($id){
        include $_SERVER['DOCUMENT_ROOT'] . '/communities/faqs/single.php';
    } elseif($faq){
        include $_SERVER['DOCUMENT_ROOT'] . '/communities/faqs/list.php';
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/communities/faqs/home.php';
    }
    ?>

    <!--/container-->
    <!--=== End FAQ Content ===-->

    <?php if(count($components['footer'])==1){
        $component = $components['footer'][0];
        if($component->component==92)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-normal.php';
        elseif($component->component==91)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-light.php';
        elseif($component->component==90)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-dark.php';
    } else
        include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-normal.php'; ?>
    <!--=== End Copyright ===-->
    <div class="background"></div>
    <div class="component-add-load back-hide"></div>
    <div class="component-delete back-hide">
        <div class="close dark">X</div>
        <form method="post"
              id="component-delete-form" class="sky-form" enctype="multipart/form-data">
            <section>
                <p style="font-size: 18px;padding:40px">Are you sure you want to delete that component?</p>
            </section>
            <footer>
                <a href="javascript:void(0)" class="btn-u close-btn">No</a>
                <button type="submit" class="btn-u btn-u-default" style="">Yes</button>
            </footer>
        </form>
    </div>
</div>
<!--/End Wrapepr-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/summernote/summernote.js"></script>
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/profile.js"></script>
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
