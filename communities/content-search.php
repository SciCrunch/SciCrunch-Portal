<?php
$tab = 0;
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$page = $vars['page'];
$query = $vars['query'];
if (!$page)
    $page = 1;

if (!$query) {
    $query = '';
}
$components = $community->components;

$filter = $vars['content'];

if ($filter) {
    switch ($filter) {
        case 'questions':
            $title = 'Browse Questions';
            $searchText = 'Search for previously asked questions';
            break;
        case 'tutorials':
            $title = 'Browse Tutorials';
            $searchText = 'Search for tutorials to help you navigate ' . $community->shortName;
            break;
        default:
            $holds = new Component();
            $holds->getPageByType($community->id, $filter);
            $title = 'Browse ' . $holds->text1;
            $searchText = 'Search against all ' . $holds->text1;
            break;
    }
} else {
    $title = 'Browse ' . $community->shortName . ' Content';
    $searchText = 'Search across all ' . $community->shortName . ' articles';
}

$hl_sub = -5;

$search = new Search();
$search->community = $community;

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
    <link rel="shortcut icon" href="favicon.ico">

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
    <link rel="stylesheet" href="/css/community-search.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>

<div class="wrapper" <?php if ($vars['editmode']) echo 'style="margin-top:32px;"' ?>>
    <!-- Brand and toggle get grouped for better mobile display -->
    <?php
    if (!isset($vars['stripped']) || $vars['stripped'] != 'true') {
        if (count($components['header']) == 1) {
            $component = $components['header'][0];
            if ($component->component == 0)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-normal.php';
            elseif ($component->component == 1)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-boxed.php';
            elseif ($component->component == 2)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-float.php';
            elseif ($component->component == 3)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-flat.php';
        } else
            include $_SERVER['DOCUMENT_ROOT'] . '/components/header/header-normal.php';
    }
    //Body

    if (count($components['breadcrumbs']) > 0) {
        $component = $components['breadcrumbs'][0];
        if (!$component->disabled)
            include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/blocks/breadcrumbs.php';
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/content-searching.php';

    if (!isset($vars['stripped']) || $vars['stripped'] != 'true') {
        if (count($components['footer']) == 1) {
            $component = $components['footer'][0];
            if ($component->component == 92)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-normal.php';
            elseif ($component->component == 91)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-light.php';
            elseif ($component->component == 90)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-dark.php';
        } else
            include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer-normal.php';
    } else echo '<div style="background:#fff;height:20px"></div>';
    ?>
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
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin, <?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
    $('.inner-results p').truncate({max_length: 500});
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html> 
