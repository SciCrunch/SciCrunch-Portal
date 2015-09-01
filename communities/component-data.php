<?php


//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$tab = 0;

$thisComp = new Component();
$thisComp->getPageByType($community->id, $vars['title']);

if ($vars['id'] && $vars['id'] == 'rss')
    include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/rss.php';
else {

    $hl_sub = $thisComp->position + 2;

    $components = $community->components;

    if (!isset($vars['query']))
        $vars['query'] = '';

    $data = new Component_Data();
    if ($vars['id']) {
        $data->getByID($vars['id']);
        $data->addView();
    } 
    	// if challenge, need the image name for edit form. It doesn't exist in the community_components table
   	elseif ($thisComp->icon1 == "challenge1") {
    	$ar = $data->getByLink($community->id, $thisComp->text2);
    	$thisComp->image = $ar[0]->image;
		$thisComp->color = $ar[0]->color;
    }	

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
        <title><?php echo $community->shortName ?> | <?php echo $thisComp->text1 ?></title>

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

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
        <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/plugins/flexslider/flexslider.css">
        <link rel="stylesheet" href="/assets/plugins/parallax-slider/css/parallax-slider.css">
        <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
        <link rel="stylesheet" href="/assets/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.css">

        <!-- CSS Theme -->
        <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
        <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
        <link rel="stylesheet" href="/assets/css/pages/page_search.css">
        <link rel="stylesheet" href="/css/community-search.css">
        <link rel="stylesheet" href="/assets/css/pages/page_contact.css">

        <!-- CSS Customization -->

        <!-- CSS Page Style -->
        <link rel="stylesheet" href="/assets/css/pages/feature_timeline1.css">
        <link rel="stylesheet" href="/assets/css/pages/feature_timeline2.css">

        <!-- CSS Theme -->
        <link rel="stylesheet" href="/assets/css/pages/blog.css">
        <link rel="stylesheet" href="/assets/css/custom.css">
        <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css"/>
    </head>

    <body>
    <?php echo \helper\noscriptHTML(); ?>

    <div class="wrapper" <?php if ($vars['editmode']) echo 'style="margin-top:32px;"' ?>>
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

        if (count($components['breadcrumbs']) > 0) {
            $component = $components['breadcrumbs'][0];
            include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/blocks/breadcrumbs.php';
        }

        if ($vars['id'])
            include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/article.php';
        else
            include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/timeline.php';

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
    <!--/wrapper-->

    <!-- JS Global Compulsory -->
    <script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/summernote/summernote.js"></script>
    <script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="/assets/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
    <script type="text/javascript" src="/js/profile.js"></script>
    <script type="text/javascript" src="/js/jquery.truncate.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

    <script type="text/javascript" src="/assets/plugins/gmap/gmap.js"></script>
    <!-- JS Implementing Plugins -->
    <script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
    <script type="text/javascript" src="/assets/plugins/flexslider/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="/assets/plugins/parallax-slider/js/modernizr.js"></script>
    <script type="text/javascript" src="/assets/plugins/parallax-slider/js/jquery.cslider.js"></script>
    <script type="text/javascript" src="/assets/plugins/counter/waypoints.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/counter/jquery.counterup.min.js"></script>
    <script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.maskedinput.min.js"></script>
    <!-- JS Page Level -->
    <script type="text/javascript" src="/assets/js/app.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/cube-portfolio.js"></script>
    <script type="text/javascript" src="/assets/js/pages/index.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            App.init();
            App.initSliders();
            Index.initParallaxSlider();
            App.initCounter();
            <?php if(isset($_SESSION['user'])){?>
            setTimeout(updateLogin, <?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
            <?php } ?>
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.inner-results p').truncate({max_length: 500});
            $('td').truncate({max_length: 200});
            $('.content-load-btn').click(function () {
                var cid = $(this).attr('cid');
                var type = $(this).attr('type');
                var num = $(this).attr('num');
                var comp = $(this).attr('comp');
                $('.' + type + ' .clearfix').remove();
                $('.content-load-div').load('/php/content-loader.php?cid=' + cid + '&num=' + num + '&comp=' + comp, function () {
                    $('.' + type).append($('.content-load-div').html());
                    if (type == 'timeline-v1')
                        $('.' + type).append('<li class="clearfix" style="float: none;"></li>');
                });
                $('.content-load-btn').attr('num', parseInt(num) + 10);

            });
            $('.date').mask('99:99 99/99/9999', {placeholder: 'X'})

	// Assign 'active' class to dropdown menus
	$('.navbar-nav li').each(function(){
		if(window.location.href.indexOf($(this).find('a:first').attr('href'))>-1) {
			$(this).addClass('active').siblings().removeClass('active');
			$(this).parent().closest('li').addClass('active').siblings().removeClass('active');
		}
	});

	$('form[data-async]').live('submit', function(event) {
		var $form = $(this);
		var $target = $($form.attr('data-target'));
 
		$.ajax({
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: $form.serialize(),
 
			success: function(data, status) {
				$target.html(data);
				$form.closest(".modal").modal("hide");
				alert("You have joined this challenge.");
				$("#joinchallenge").html("You have joined this challenge.<br /> (If you want to de-register, please send email to drugdesigndata@gmail.com.)");
			}
		});
 
		event.preventDefault();
	});

            var map;
            map = new GMaps({
                div: '#map',
                scrollwheel: false,
                lat: $('.map').attr('lat'),
                lng: $('.map').attr('lng')
            });

            var marker = map.addMarker({
                lat: $('.map').attr('lat'),
                lng: $('.map').attr('lng'),
                title: $('.map').attr('addr')
            });
		});
    </script>
    <!--[if lt IE 9]>
    <script src="/assets/plugins/respond.js"></script>
    <script src="/assets/plugins/html5shiv.js"></script>
    <![endif]-->

    </body>
    </html>
<?php } ?>
