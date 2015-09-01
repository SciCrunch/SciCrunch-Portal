<?php

if ($vars['q'] == '*')
    $theTitle = 'Searching';
else
    $theTitle = 'Searching for ' . $vars['q'];

//print_r($vars);
if ($vars['category'] == 'data') {
    $tab = 2;
    $theTitle .= ' in More Resources';
} elseif ($vars['category'] == 'literature') {
    $tab = 3;
    $theTitle .= ' in Literature';
} else {
    $tab = 1;
    $num = 0;
    foreach ($community->urlTree as $cat => $array) {
        if ($cat == $vars['category']) {
            $hl_sub = $num;
            if ($vars['subcategory']) {
                $newNum = 0;
                foreach ($array['subcategories'] as $sub => $other) {
                    if ($sub == $vars['subcategory']) {
                        $ol_sub = $newNum;
                        break;
                    }
                    $newNum++;
                }
                $theTitle .= ' in ' . $vars['subcategory'];
            } else {
                $theTitle .= ' in ' . $vars['category'];
                $ol_sub = -1;
            }
            break;
        }
        $num++;
    }
    if ($vars['category'] == 'Any') {
        $theTitle .= ' through all Categories';
        $hl_sub = -1;
        $ol_sub = -1;
    }
}

scicrunchRegSort($vars, $community);	// for sorting scicrunch registry results

//error_reporting(E_ALL);
//ini_set("display_errors", 1);


//print_r($community);

$search = new Search();
$vars['community'] = $community;
$search->create($vars);
$holder = new Sources();
$allSources = $holder->getAllSources();
$search->allSources = $allSources;
$results = $search->doSearch();
//echo "\r\n";
//print_r($results);


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
    <title><?php echo $community->shortName ?> | <?php echo $theTitle ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/page_search_inner.css">
    <link rel="stylesheet" href="/assets/css/pages/page_search_inner_tables.css">
    <link rel="stylesheet" href="/assets/plugins/scrollbar/src/perfect-scrollbar.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="/assets/css/shop/shop.blocks.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/css/community-search.css">
    <link rel="stylesheet" href="/css/joyride-2.0.3.css">
</head>

<body>
<?php echo \helper\noscriptHTML(); ?>

<?php

if ($search->fullscreen) {
    include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/full.table.view.php';
} else {
    ?>
    <div class="wrapper" <?php if ($vars['editmode']) echo 'style="margin-top:32px;"' ?>>
        <!-- Brand and toggle get grouped for better mobile display -->
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
        }
        if (count($components['search']) > 0 && !isset($vars['view']) && !isset($vars['uuid']) && !isset($vars['pmid'])) {
            $component = $components['search'][0];
            if (!$component->disabled)
                include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/blocks/search-block.php';
        }


        if ($search->category == 'data') {
            if ($search->source) {
                include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/table.view.php';
            } else {
                include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/data.view.php';
            }
        } elseif ($search->category == 'literature') {
            if(isset($vars['pmid'])){
                include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/paper-view.php';
            } else
                include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/literature.view.php';
        } elseif ($search->source) {
            include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/table.view.php';
        } elseif (isset($vars['view']) && isset($vars['uuid']))
            include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/single-item.php';
        else
            include $_SERVER['DOCUMENT_ROOT'] . '/communities/ssi/resource.view.php';

        // Footer
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
        <!--=== Breadcrumbs v3 ===-->
        <!--=== End Copyright ===-->
        <div class="invis-background"></div>
        <div class="background"></div>
        <?php if (isset($_SESSION['user'])) { ?>
            <div class="saved-this-search back-hide no-padding">
                <div class="close dark less-right">X</div>
                <form method="post" action="/forms/other-forms/add-saved-search.php"
                      id="header-component-form" class="sky-form" enctype="multipart/form-data">
                    <header>Save This Search</header>
                    <fieldset>
                        <section>
                            <label class="label">Name</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="name" placeholder="Focus to view the tooltip">
                                <b class="tooltip tooltip-top-right">The name of your saved search.</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Community</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="hidden" name="cid" placeholder="Focus to view the tooltip"
                                       value="<?php echo $community->id ?>">

                                <input type="text" disabled="disabled" placeholder="Focus to view the tooltip"
                                       value="<?php echo $community->name ?>">
                                <b class="tooltip tooltip-top-right">The community you are in.</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Category</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="hidden" name="category" placeholder="Focus to view the tooltip"
                                       value="<?php echo $search->category ?>">
                                <input type="text" disabled="disabled" placeholder="Focus to view the tooltip"
                                       value="<?php if ($search->category == 'data') echo 'More Resources'; else echo $search->category ?>">
                                <b class="tooltip tooltip-top-right">The category you are on.</b>
                            </label>
                        </section>
                        <?php if ($search->subcategory) { ?>
                            <section>
                                <label class="label">Subcategory</label>
                                <label class="input">
                                    <i class="icon-append fa fa-question-circle"></i>
                                    <input type="hidden" name="subcategory" placeholder="Focus to view the tooltip"
                                           value="<?php echo $search->subcategory ?>">
                                    <input type="text" disabled="disabled" placeholder="Focus to view the tooltip"
                                           value="<?php echo $search->subcategory ?>">
                                    <b class="tooltip tooltip-top-right">The subcategory you are on.</b>
                                </label>
                            </section>
                        <?php } ?>
                        <?php if ($search->source) {
                            $source = new Sources();
                            //echo $search->source;
                            $source->getByView($search->source);
                            ?>

                            <section>
                                <label class="label">Source View</label>
                                <label class="input">
                                    <i class="icon-append fa fa-question-circle"></i>
                                    <input type="hidden" name="nif" placeholder="Focus to view the tooltip"
                                           value="<?php echo $search->source ?>">
                                    <input type="text" disabled="disabled" placeholder="Focus to view the tooltip"
                                           value="<?php echo $source->getTitle() ?>">
                                    <b class="tooltip tooltip-top-right">The subcategory you are on.</b>
                                </label>
                            </section>
                        <?php } ?>
                        <section>
                            <label class="label">Query</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="hidden" name="query" placeholder="Focus to view the tooltip"
                                       value="<?php echo $search->query ?>">
                                <input type="hidden" name="display" placeholder="Focus to view the tooltip"
                                       value="<?php echo $search->display ?>">
                                <input type="text" disabled="disabled" placeholder="Focus to view the tooltip"
                                       value="<?php if ($search->display && $search->display != '') echo $search->display; else echo $search->query ?>">
                                <b class="tooltip tooltip-top-right">The query you searched for</b>
                                <input type="hidden" name="params" value="<?php echo $search->getParams() ?>"/>
                            </label>
                        </section>
                    </fieldset>

                    <footer>
                        <button type="submit" class="btn-u btn-u-default" style="width:100%">Save Search</button>
                    </footer>
                </form>
            </div>
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
        <?php } ?>
    </div>
<?php } ?>
<!--/End Wrapepr-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.truncate.js"></script>
<script src="/assets/plugins/scrollbar/src/jquery.mousewheel.js"></script>
<script src="/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script src="/assets/plugins/summernote/summernote.js"></script>
<script type="text/javascript" src="/js/extended-circle-master.js"></script>
<script type="text/javascript" src="/js/circle-master.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

<script type="text/javascript" src="/assets/plugins/gmap/gmap.js"></script>
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script type='text/javascript' src='https://d1bxh8uas1mnw7.cloudfront.net/assets/embed.js'></script>

<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/assets/plugins/d3/d3.min.js"></script>
<script type="text/javascript" src="/js/graph.js"></script>
<!-- JS Implementing Plugins -->
<?php

if (!$search->fullscreen) {
    ?>
    <script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<?php } ?>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>

<script type="text/javascript" src="/js/jquery.joyride-2.0.3.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        App.init();
        CirclesMaster.initCirclesMaster1();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin, <?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
        $(".inner-hidden-results").hide();
    });
</script>
<script type="text/javascript">
    $('.tutorial-btn').click(function () {
        $('.joyride-next-tip').show();
        $('#joyRideTipContent').joyride({postStepCallback: function (index, tip) {

        }, 'startOffset': 0, 'tip_class': false});
    });
    $('.inner-results p').truncate({max_length: 500});
    $('td').truncate({max_length: 200});
    $(window).scroll(function (event) {
        $(".fixed-header").css("margin-left", -$(document).scrollLeft());
    });
    $('.full-side-close').click(function () {
        $('.full-screen-left').hide();
        $('.full-screen-closed').show();
        $('.fixed-header').css('left', '40px');
        $('.full-screen-right').css('margin-left', '40px');
    });
    $('.full-side-open').click(function () {
        $('.full-screen-closed').hide();
        $('.full-screen-left').show();
        $('.fixed-header').css('left', '260px');
        $('.full-screen-right').css('margin-left', '260px');
    });
</script>
<script type="text/javascript">
    $('#column-select').change(function () {
        var column = $('th[column="' + $(this).val() + '"');
        var position = column.position();

        window.scrollTo(position.left, window.y);

        $(column).css('background', '#ffd9d9');
        setTimeout(function () {
            $(column).css('background', '#d9d9f2');
        }, 2000)
    });
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

<?php

function scicrunchRegSort(&$vars, $community){
    // sets settings so that resource_name is automatically sorted only when scicrunch registry is the only resource and there was no search query
    if($vars['q'] != '*' || $vars['sort'] || $vars['nif'] != "") return;
    $scicrunch_nif = "nlx_144509-1";
    $resource = $community->urlTree[$vars['category']];
    $used_resource = $vars['subcategory'] ? $resource['subcategories'][$vars['subcategory']] : $resource;	// use subcategory if it was queried
    if(count($used_resource['nif']) > 1 || $used_resource['nif'][0] != $scicrunch_nif) return;

    $vars['sort'] = "asc";
    $vars['column'] = 'resource_name';
}

?>
