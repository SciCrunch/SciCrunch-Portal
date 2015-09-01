<?php
$tab = 0;
include 'tests/test.includes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$run = filter_var($_GET['run'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$db = new Connection();
$db->connect();
$prior = $db->select('test_xmls', array('*'), null, array(), 'order by id desc limit 10');
$db->close();

if ($run == 'true') {
    $test = new CommunityTest(true, false);
    $xml = $test->doAllTests(true);
    echo $xml;
    $db = new Connection();
    $db->connect();
    $insertId = $db->insert('test_xmls', 'is', array(null, $xml));
    $db->close();
    //echo $insertId;
} else {
    if ($id) {
        $db = new Connection();
        $db->connect();
        $return = $db->select('test_xmls', array('xml'), 'i', array($id), 'where id=?');
        $db->close();
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
        <title>SciCrunch | Code Tests</title>

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

    <div class="wrapper">
        <!-- Brand and toggle get grouped for better mobile display -->
        <?php include 'ssi/header.php' ?>
        <!--=== Breadcrumbs v3 ===-->
        <div class="breadcrumbs-v3">
            <div class="container">
                <h1 class="pull-left">SciCrunch Test Suite</h1>
                <ul class="pull-right breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <?php if ($id) { ?>
                        <li><a href="/testing">SciCrunch Test Suite</a></li>
                        <li class="active">Prior Test</li>
                    <?php } else { ?>
                        <li class="active">SciCrunch Test Suite</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--=== End Breadcrumbs v3 ===-->

        <!--=== Search Results ===-->
        <div class="container s-results margin-bottom-50">
            <div class="row">

                <?php
                $test = new CommunityTest(true, false);
                if ($id) {
                    echo $test->parseXML($return[0]['xml']);
                } else {
                    $colors = array('#ff0000','#dddd00','#00dd00');
                    echo '<h1 align="center" style="margin-top: 40px">SciCrunch Test Suite - v' . VERSION . '</h1>';
                    echo '<div class="pull-right">';
                    echo '<div class="btn-group" style="margin:0 10px">
                        <button type="button" class="btn-u dropdown-toggle" data-toggle="dropdown">
                            Prior Tests
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu" style="left:auto;right:0">';
                    foreach ($prior as $array) {
                        $prXML = simplexml_load_string($array['xml']);
                        if ($prXML) {
                            if(isset($prXML->status))
                                $status = (int)$prXML->status;
                            else
                                $status = 1;
                            echo '<li><a href="/testing/' . $array['id'] . '"><i class="fa fa-circle" style="color:'.$colors[$status].'"></i> v' . $prXML->version . ' - ' . $prXML->time . '</a></li>';
                        }
                    }

                    echo '</ul>
                    </div>';
                    echo '</div>';

                    echo '<p style="margin:20px 0">
                    This is the code testing suite for SciCrunch. This test is run live and shows the current integrity
                    of the current release compared to the expectations.
                </p>';
                    echo $test->doAllTests(false);
                }
                ?>
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
<?php } ?>