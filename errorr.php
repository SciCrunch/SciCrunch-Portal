<?php
$tab = 2;
include 'classes/classes.php';
session_start();

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);

$portalName = filter_var($_GET['name'], FILTER_SANITIZE_STRING);

if ($type != '404') {
    $community = new Community();
    $community->getByPortalName($portalName);

    if ($community->private != 1 || (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 0)) {
        header('location:/' . $portalName);
        exit();
    }
}

switch ($type) {
    case 'private':
        $title = 'Private Community';
        break;
    case '404':
        $title = 'Community Not Found';
        break;
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

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/page_error3_404.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/sky-forms-ie8.css">
    -->
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>

<!--=== Error V3 ===-->
<div class="container content">
    <!-- Error Block -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php if ($type == 'private') { ?>
                <div class="error-v3">
                    <h2>Private</h2>

                    <p>Sorry, the community you were trying to access is set to private. Only current members may enter
                        at this time. If you are a current member log in and you will be directed there.</p>
                </div>
            <?php } elseif ($type == '404') { ?>
                <div class="error-v3">
                    <h2>404</h2>

                    <p>
                        Sorry, there does not exist a community with the url <b>/<?php echo $portalName ?></b>.
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- End Error Block -->

    <!-- Begin Service Block V2 -->
    <div class="row service-block-v2">
        <div class="col-md-4">
            <div class="service-block-in service-or">
                <div class="service-bg"></div>
                <i class="icon-bulb"></i>
                <h4>Find New Communities</h4>

                <p>
                    Browse around and visit other communities since this one is private. We have communities covering
                    all scientific areas.
                </p>
                <a class="btn-u btn-brd btn-u-light" href="/browse/communities"> Discover More</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-block-in service-or">
                <div class="service-bg"></div>
                <i class="icon-directions"></i>
                <h4>Come Back Later</h4>

                <p>
                    The community might be private now, but can be made available at any time by the owners. Check back
                    again later to see if it is public.
                </p>
                <a class="btn-u btn-brd btn-u-light" href="/"> Go back to Home Page</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-block-in service-or">
                <?php if (!isset($_SESSION['user'])) { ?>
                    <h4>Log In</h4>
                    <form method="post" class="sky-form" style="border:0" action="/forms/login.php">
                        <fieldset style="background:transparent;padding:0">
                            <section>
                                <div class="input">
                                    <i class="fa fa-envelope icon-prepend"
                                       style="top: 1px;height: 32px;font-size: 14px;line-height: 33px;background: inherit;color:#b3b3b3;background:#fff;left:1px;padding-left:6px;"></i>
                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                </div>
                            </section>
                            <div class="input">
                                <i class="fa fa-lock icon-prepend"
                                   style="top: 1px;height: 32px;font-size: 14px;line-height: 33px;background: inherit;color:#b3b3b3;background:#fff;left:1px;padding-left:6px;"></i>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            <hr style="margin:18px 0">

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <button type="submit" class="btn-u btn-block">Log In</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                <?php } else { ?>
                    <div class="service-bg"></div>
                    <i class="icon-users"></i>
                    <h4>Contact us</h4>
                    <p>If you have a problem with the website, please contact us, our support team will help you to
                        solve the problem.</p>
                    <a class="btn-u btn-brd btn-u-light" href="#"> Contact Us</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- End Service Block V2 -->
</div>
<!--=== End Error-V3 ===-->

<!--=== Sticky Footer ===-->
<!--=== End Sticky-Footer ===-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
<script type="text/javascript">
    $.backstretch([
        "/assets/img/blur/img1.jpg"
    ])
</script>
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
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<![endif]-->

</body>
</html> 
