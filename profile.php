<?php
$tab = 3;
include 'classes/classes.php';
session_start();
include 'vars/overview.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$update = filter_var($_GET['update'], FILTER_SANITIZE_STRING);
$currPage = filter_var($_GET['currPage'], FILTER_SANITIZE_NUMBER_INT);
$query = filter_var($_GET['query'], FILTER_SANITIZE_STRING);
$page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
$arg1 = filter_var($_GET['arg1'], FILTER_SANITIZE_STRING);
$arg2 = filter_var($_GET['arg2'], FILTER_SANITIZE_STRING);
$arg3 = filter_var($_GET['arg3'], FILTER_SANITIZE_STRING);
$arg4 = filter_var($_GET['arg4'], FILTER_SANITIZE_STRING);
$section = filter_var($_GET['tab'], FILTER_SANITIZE_STRING);
$tutorial = filter_var($_GET['tutorial'], FILTER_SANITIZE_STRING);

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

if ($page) {
    switch ($page) {
        case "edit":
            $hl_sub = 0;
            $pageTitle = 'Edit Information';
            break;
        case "communities":
            $hl_sub = 1;
            $pageTitle = 'My Communities';
            if($arg1){
                $community = new Community();
                $community->getByPortalName($arg1);
                $user_access = $community->getUser($_SESSION['user']->id);
                if(count($user_access) == 0 || $user_access[0]['level'] < 2){
                    header('Location:/account');
                    exit;
                }
            }
            break;
        case "scicrunch":
            if($_SESSION['user']->role<1){
                header('location:/account');
                exit();
            }
            $hl_sub = 4;
            $pageTitle = 'Edit SciCrunch';
            break;
        case "resources":
            $hl_sub = 2;
            $pageTitle = 'My Resources';
            break;
        case "saved":
            $hl_sub = 3;
            $pageTitle = 'My Saved Searches';
            break;
        case "collections":
            $hl_sub = 5;
            $pageTitle = 'My Collections';
            break;
    }
} else {
    $pageTitle = 'My Account';
    $hl_sub = 0;
}
$holder = new Component();
$components = $holder->getByCommunity(0);

?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>SciCrunch | <?php echo $pageTitle?></title>

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
    <link rel="stylesheet" href="/assets/plugins/flexslider/flexslider.css">
    <link rel="stylesheet" href="/assets/plugins/parallax-slider/css/parallax-slider.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="/assets/plugins/scrollbar/src/perfect-scrollbar.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="assets/plugins/sky-forms/version-2.0.1/css/sky-forms-ie8.css">-->

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/profile.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/joyride-2.0.3.css">
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css"/>
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>
<div class="wrapper">
    <!--=== Header ===-->
    <?php include 'ssi/header.php'; ?>

    <?php
    $profileBase = '/';
    if ($page) {
        switch ($page) {
            case 'edit':
                include 'profile/edit.php';
                break;
            case 'communities':
                if ($arg1) {
                    switch ($arg2) {
                        case 'resource':
                            $arg2=$arg3;
                            include 'profile/resources/resource-edit.php';
                            break;
                        case 'insert':
                            include 'profile/shared-pages/component-pages/dynamic-data-add.php';
                            break;
                        case 'update':
                            include 'profile/shared-pages/component-pages/dynamic-data-update.php';
                            break;
                        case 'dynamic':
                            include 'profile/shared-pages/component-pages/dynamic-data.php';
                            break;
                        case 'type':
                            switch ($arg3) {
                                case 'add':
                                    $type = new Resource_Type();
                                    $type->getByID($arg4);
                                    include 'profile/shared-pages/resource-pages/type-add.php';
                                    break;
                                case 'edit':
                                    $type = new Resource_Type();
                                    $type->getByID($arg4);
                                    include 'profile/shared-pages/resource-pages/type-edit.php';
                            }
                            break;
                        case 'component':
                            if ($arg3 == 'insert') {
                                $arg3 = $arg4;
                                include 'profile/shared-pages/component-pages/component-insert.php';
                            } elseif ($arg3 == 'update') {
                                $arg3 = $arg4;
                                include 'profile/shared-pages/component-pages/component-update.php';
                            } elseif ($arg3 == 'files') {
                                $arg3 = $arg4;
                                include 'profile/shared-pages/component-pages/component-files.php';
                            }
                            break;
                        case 'form':
                            $type = new Resource_Type();
                            $type->getByID($arg4);
                            include 'profile/shared-pages/resource-pages/form-edit.php';
                            break;
                        case 'components':
                            if ($arg3)
                                include 'profile/shared-pages/component-pages/components-' . $arg3 . '.php';
                            else
                                include 'profile/shared-pages/component-pages/components-page.php';
                            break;
                        case 'edit':
                            include 'profile/communities/community-update.php';
                            break;
                        case 'sources':
                            include 'profile/communities/community-sources.php';
                            break;
                        case 'view':
                            include 'profile/shared-pages/component-pages/data-view.php';
                            break;
                        default:
                            include 'profile/communities/community-single-page.php';
                    }
                } else
                    include 'profile/communities/community-page.php';
                break;
            case 'resources':
                if ($arg1) {
                    if ($arg1 == 'edit')
                        include 'profile/resources/resource-edit.php';
                } else
                    include 'profile/resources/resources.php';
                break;
            case 'scicrunch':
                $community = new Community();
                $community->id = 0;
                $community->name = 'SciCrunch';
                $community->portalName = 'scicrunch';
                if ($arg1) {
                    switch ($arg1) {
                        case 'users':
                            include 'profile/scicrunch/users.php';
                            break;
                        case 'sources':
                            include 'profile/scicrunch/updateSources.php';
                            break;
                        case 'component':
                            if ($arg2 == 'insert') {
                                include 'profile/shared-pages/component-pages/component-insert.php';
                            } elseif ($arg2 == 'update') {
                                include 'profile/shared-pages/component-pages/component-update.php';
                            } elseif ($arg2 == 'files') {
                                include 'profile/shared-pages/component-pages/component-files.php';
                            }
                            break;
                        case 'type':
                            $type = new Resource_Type();
                            $type->getByID($arg3);
                            if ($arg2 == 'edit')
                                include 'profile/shared-pages/resource-pages/type-edit.php';
                            elseif ($arg2 == 'add')
                                include 'profile/shared-pages/resource-pages/type-add.php';
                            break;
                        case 'form':
                            $type = new Resource_Type();
                            $type->getByID($arg3);
                            if ($arg2 == 'edit')
                                include 'profile/shared-pages/resource-pages/form-edit.php';
                            break;
                        case 'components':
                            if ($arg2)
                                include 'profile/shared-pages/component-pages/components-' . $arg2 . '.php';
                            else
                                include 'profile/shared-pages/component-pages/components-page.php';
                            break;
                        case 'dynamic':
                            $arg3 = $arg2;
                            include 'profile/shared-pages/component-pages/dynamic-data.php';
                            break;
                        case 'view':
                            $arg3 = $arg2;
                            include 'profile/shared-pages/component-pages/data-view.php';
                            break;
                    }
                } else
                    include 'profile/scicrunch/home.php';
                break;
            case "saved":
                include 'profile/other-pages/save-search-overview.php';
                break;
            case "collections":
                if(isset($arg1)&&$arg1!=''&&$arg1!=null)
                    include 'profile/other-pages/collection-view.php';
                else
                    include 'profile/other-pages/collections-overview.php';
                break;
        }
    } else
        include 'profile/home.php';

    ?>
    <?php include 'ssi/footer.php'; ?>

</div>
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/jquery.joyride-2.0.3.js"></script>
<!-- JS Implementing Plugins -->
<script src="/assets/plugins/summernote/summernote.js"></script>
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="/assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="/assets/plugins/parallax-slider/js/modernizr.js"></script>
<script type="text/javascript" src="/assets/plugins/parallax-slider/js/jquery.cslider.js"></script>
<script type="text/javascript" src="/assets/plugins/counter/waypoints.min.js"></script>
<script type="text/javascript" src="/assets/plugins/counter/jquery.counterup.min.js"></script>
<!-- Datepicker Form -->
<script type="text/javascript" src="/assets/plugins/sky-forms/version-2.0.1/js/jquery-ui.min.js"></script>
<!-- Scrollbar -->
<script src="/assets/plugins/scrollbar/src/jquery.mousewheel.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
<!-- JS Page Level -->
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript" src="/assets/js/pages/index.js"></script>
<script type="text/javascript" src="/js/profile.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        App.initSliders();
        Index.initParallaxSlider();
        App.initCounter();
        $('.collection-view-table td p').truncate({max_length: 300});
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin, <?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
</script>
<script>

    var inTut = false;
    $('#tutorial').click(function () {
        inTut = true;
        $('.joyride-next-tip').show();
        $('#joyRideTipContent').joyride({postStepCallback: function (index, tip) {

        }, 'startOffset': 0, 'tip_class': false});
    });
    <?php if ($tutorial == 'true') { ?>
    $('.joyride-next-tip').show();
    $('#joyRideTipContent').joyride({postStepCallback: function (index, tip) {

    }, 'startOffset': 0});
    <?php } ?>
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html>
