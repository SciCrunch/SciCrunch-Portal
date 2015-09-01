<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 0) {
    header('location:/' . $community->portalName);
    exit();
}

$search = new Search();
$search->community = $community;

$components = $community->components;
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>SciCrunch | Welcome...</title>

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
    <link rel="stylesheet" href="/assets/plugins/flexslider/flexslider.css">
    <link rel="stylesheet" href="/assets/plugins/parallax-slider/css/parallax-slider.css">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v1.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>
<div class="wrapper" <?php if ($vars['editmode']) echo 'style="margin-top:32px;"' ?>>
    <!--=== Header ===-->

    <?php
    //Header
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
    }?>

    <div class="container content">
        <div class="row">
            <div class="col-md-6">
                <form method="post" class="reg-page reg-page-style sky-form" action="/forms/login.php?join=true&cid=<?php echo $community->id ?>">
                    <div class="reg-header">
                        <h2>Login and Join</h2>
                    </div>


                    <label class="label">Email <span class="color-red">*</span></label>
                    <input type="email" name="email" class="form-control margin-bottom-20" required="">

                    <label class="label">Password <span class="color-red">*</span></label>
                    <input type="password" name="password" class="form-control margin-bottom-20" required="">
                    <hr>

                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <button class="btn-u" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form class="reg-page sky-form" method="post" action="/forms/register.php?join=true&cid=<?php echo $community->id ?>">
                    <div class="reg-header">
                        <h2>Register a new account and Join</h2>
                    </div>

                    <section>
                        <label class="label">First Name <span class="color-red">*</span></label>
                        <label class="input">
                            <input type="text" required="required" name="firstname">
                        </label>
                    </section>

                    <section>
                        <label class="label">Last Name <span class="color-red">*</span></label>
                        <label class="input">
                            <input type="text" required="required" name="lastname">
                        </label>
                    </section>

                    <section>
                        <label class="label">Email <span class="color-red">*</span></label>
                        <label class="input">
                            <input type="text" class="sign-up" required="required" name="email">
                        </label>
                    </section>

                    <section>
                        <label class="label">Organization</label>
                        <label class="input">
                            <i class="icon-append fa fa-question-circle"></i>
                            <input type="text" name="organization">
                            <b class="tooltip tooltip-top-right">The organization you are affiliated with (ie UCSD, Scripps, etc)</b>
                        </label>
                    </section>

                    <div class="row">
                        <div class="col-sm-12">
                            <label>Password <span class="color-red">*</span></label>
                            <input type="password" name="password" class="sign-up-password form-control margin-bottom-20" required>
                        </div>
                        <div class="col-sm-12">
                            <label>Confirm Password <span class="color-red">*</span></label>
                            <input type="password" name="password2" class="sign-up-password form-control margin-bottom-20" required>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="checkbox">
                                <input class="sign-up-checkbox" type="checkbox" name="terms" required style="top: 3px; left: 30px;">
                                I have read the <a href="/page/terms" class="color-green" target="_blank">Terms and Conditions</a>
                            </label>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn-u" type="submit">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/container-->

    <?php
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

<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<script src="/assets/plugins/scrollbar/src/jquery.mousewheel.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script src="/assets/plugins/summernote/summernote.js"></script>
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/profile.js"></script>
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
</script>
</body>
</html>
