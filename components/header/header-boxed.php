<?php
$holder = new Component();
$components = $holder->getByCommunity($community->id);
$header_img_class = "community-logo";
$header_name_class = "community-name";
if(isset($components['header']) && $components['header'][0]->icon1 && $components['header'][0]->icon1 == "large"){
    $header_img_class = "community-logo-large";
    $header_name_class = "community-name-small";
}

$gacode = GACODE;
?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '<?php echo $gacode ?>', 'auto');
    ga('send', 'pageview');

</script>
<style>
    <?php if($component->color1){ ?>
    .header-v4.header .navbar-default .navbar-nav > li > a:hover,
    .header-v4.header .navbar-default .navbar-nav > .active > a {
        color: # <?php echo $component->color1?>;
        border-top: solid 2px # <?php echo $component->color1?>;
    }

    .header .dropdown-menu {
        border-top: solid 2px # <?php echo $component->color1?>;
    }

    .header .navbar .nav > li > .search:hover {
        color: # <?php echo $component->color1?>;
        background: #f7f7f7;
        border-bottom-color: # <?php echo $component->color1?>;
    }

    .topbar-v1 .top-v1-data li a:hover {
        color: # <?php echo $component->color1?>;
    }

    .header .btn-u {
        background: # <?php echo $component->color1?>;
    }

    .header .btn-u:hover {
        background: # <?php echo $component->color1?>;
    }

    <?php } ?>
</style>
<?php
if ($vars) {
    $params = '?q=' . $vars['q'] . '&l=' . $vars['l'];
} else {
    $params = '';
}
?>
<div
    class="header header-v4 <?php if ($vars['editmode']) echo 'editmode' ?>" <?php if ($vars['editmode']) echo 'style="z-index:101"' ?>>
<!-- Topbar -->
<div
    class="topbar-v1 sm-margin-bottom-20" <?php if ($vars['editmode']) echo 'style="position:fixed;top:0;left:0;z-index:110;width:100%"' ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            </div>

            <div class="col-md-6">
                <ul class="list-unstyled top-v1-data">

                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/header/topbar.php'; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Topbar -->

<!-- Navbar -->
<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/<?php echo $community->portalName ?>">
                <img class="<?php echo $header_img_class ?>" src="/upload/community-logo/<?php echo $community->logo ?>"/>
                <span class="<?php echo $header_name_class ?>"><?php echo $community->name ?></span>
            </a>
        </div>
    </div>
    <!-- End Search Block -->

    <div class="clearfix"></div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div>
        <div class="container">
            <ul class="nav navbar-nav">
                <!-- Home -->
                <li class="<?php if ($tab == 0) echo 'active' ?> dropdown about-tab">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">About</a>
                    <ul class="dropdown-menu">
                        <?php
                            if($community->about_home_view){
                                $class_active = ($tab == 0 && $hl_sub == 0) ? 'class="active"' : '';
                                echo '<li ' . $class_active . '><a href="/' . $community->portalName . '">Home</a></li>';
                            }
                            if($community->about_sources_view){
                                $class_active = ($tab == 0 && $hl_sub == 1) ? 'class="active"' : '';
                                echo '<li ' . $class_active . '><a href="/' . $community->portalName . '/about/sources">' . $community->shortName . ' Sources</a></li>';
                            }
                        ?>
                        <?php
                        $pages = $components['page'];
                        foreach ($pages as $pag) {
                            if ($pag->disabled == 1) {
                                if (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 1) {
                                    if ($tab == 0 && $hl_sub == $pag->position + 2)
                                        echo '<li class="active"><a href="/' . $community->portalName . '/about/' . $pag->text2 . '"><i class="fa fa-eye-slash"></i> ' . $pag->text1 . '</a></li>';
                                    else
                                        echo '<li style="background:#f8f8f8"><a href="/' . $community->portalName . '/about/' . $pag->text2 . '"><i class="fa fa-eye-slash"></i> ' . $pag->text1 . '</a></li>';
                                } else continue;
                            } else {
                                if ($tab == 0 && $hl_sub == $pag->position + 2)
                                    echo '<li class="active"><a href="/' . $community->portalName . '/about/' . $pag->text2 . '">' . $pag->text1 . '</a></li>';
                                else
                                    echo '<li><a href="/' . $community->portalName . '/about/' . $pag->text2 . '">' . $pag->text1 . '</a></li>';
                            }
                        }

                        ?>
                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 1) {?>
                        <li style="background:#e8e8e8" <?php if ($tab == 0 && $hl_sub == -5) echo 'class="active"' ?>><a
                                href="/<?php echo $community->portalName ?>/about/search"><i class="fa fa-eye-slash"></i> Search Articles</a></li>
                        <li style="background:#e8e8e8" <?php if ($tab == 0 && $hl_sub == -6) echo 'class="active"' ?>><a
                                href="/<?php echo $community->portalName ?>/about/registry"><i class="fa fa-eye-slash"></i> <?php echo $community->shortName ?>
                                Registry</a></li>
                        <?php } ?>
                        <li <?php if ($tab == 0 && $hl_sub == -4) echo 'class="active"' ?>><a
                                href="/<?php echo $community->portalName ?>/about/resource">Add a Resource</a></li>
                    </ul>
                </li>
                <?php if ($community->resourceView) { ?>
                    <li class="<?php if ($tab == 1) echo 'active' ?> dropdown resource-tab">
                        <?php
                        $newVars = $vars;
                        $newVars['category'] = 'Any';
                        $newVars['subcategory'] = null;
                        $newVars['nif'] = null;
                        $newVars['facet'] = null;
                        $newVars['filter'] = null;
                        $newVars['parent'] = null;
                        $newVars['child'] = null;
                        $newVars['page'] = 1;
                        ?>
                        <a href="<?php echo $search->generateURL($newVars) ?>">Community Resources</a>
                        <ul class="dropdown-menu">
                            <?php
                            $number = 0;
                            foreach ($community->urlTree as $category => $array) {
                                if ($tab == 1 && $number == $hl_sub) {
                                    $active = ' active';
                                } else {
                                    $active = '';
                                }
                                if ($array['subcategories'] && count($array['subcategories']) > 0)
                                    echo '<li class="dropdown-submenu' . $active . '">';
                                else
                                    echo '<li class="' . $active . '">';
                                $newVars = $vars;
                                $newVars['category'] = $category;
                                $newVars['subcategory'] = null;
                                $newVars['nif'] = null;
                                $newVars['facet'] = null;
                                $newVars['filter'] = null;
                                $newVars['parent'] = null;
                                $newVars['child'] = null;
                                $newVars['page'] = 1;
                                echo '<a href="' . $search->generateURL($newVars) . '">' . $category . '</a>';
                                if ($array['subcategories'] && count($array['subcategories']) > 0) {
                                    echo '<ul class="dropdown-menu">';
                                    $nextNum = 0;
                                    foreach ($array['subcategories'] as $subcategory => $urls) {
                                        $newVars = $vars;
                                        $newVars['category'] = $category;
                                        $newVars['subcategory'] = $subcategory;
                                        $newVars['nif'] = null;
                                        $newVars['facet'] = null;
                                        $newVars['filter'] = null;
                                        $newVars['parent'] = null;
                                        $newVars['child'] = null;
                                        $newVars['page'] = 1;
                                        if ($tab == 1 && $number == $hl_sub && $nextNum == $ol_sub)
                                            echo '<li class="active"><a href="' . $search->generateURL($newVars) . '">' . $subcategory . '</a></li>';
                                        else
                                            echo '<li><a href="' . $search->generateURL($newVars) . '">' . $subcategory . '</a></li>';
                                        $nextNum++;
                                    }
                                    echo '</ul>';
                                }
                                $number++;
                                echo '</li>';
                            }

                            ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- End Home -->

                <!-- Job Pages -->

                <!-- Job Pages -->
                <?php if ($community->dataView) { ?>
                    <li class="<?php if ($tab == 2) echo 'active' ?> data-tab">
                        <?php
                        $newVars = $vars;
                        $newVars['category'] = 'data';
                        $newVars['subcategory'] = null;
                        $newVars['nif'] = null;
                        $newVars['facet'] = null;
                        $newVars['filter'] = null;
                        $newVars['page'] = 1;
                        ?>
                        <a href="<?php echo $search->generateURL($newVars) ?>">More Resources</a>
                    </li>
                <?php } ?>
                <!-- End Job Pages -->


                <?php if ($community->literatureView) { ?>
                    <li class="<?php if ($tab == 3) echo 'active' ?> lit-tab">
                        <?php
                        $newVars = $vars;
                        $newVars['category'] = 'literature';
                        $newVars['subcategory'] = null;
                        $newVars['facet'] = null;
                        $newVars['filter'] = null;
                        $newVars['parent'] = null;
                        $newVars['child'] = null;
                        $newVars['nif'] = null;
                        $newVars['page'] = 1;
                        ?>
                        <a href="<?php echo $search->generateURL($newVars) ?>">Literature</a>
                    </li>
                <?php } ?>

                <?php if (isset($_SESSION['user'])) { ?>
                    <li class="<?php if ($tab == 4) echo 'active' ?> dropdown account-tab">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">My Account</a>
                        <ul class="dropdown-menu">
                            <li<?php if ($hl_sub == 0 && $tab == 4) echo ' class="active"' ?>><a
                                    href="/<?php echo $community->portalName ?>/account"><i
                                        class="fa fa-bar-chart-o"></i>Information</a></li>
                            <li<?php if ($hl_sub == 3 && $tab == 4) echo ' class="active"' ?>><a
                                    href="/<?php echo $community->portalName ?>/account/saved"><i
                                        class="fa fa-floppy-o"></i>Saved Searches</a></li>
                            <li<?php if ($hl_sub == 6 && $tab == 4) echo ' class="active"' ?>><a
                                    href="/<?php echo $community->portalName ?>/account/collections"><i
                                        class="fa fa-shopping-cart"></i>My Collections</a></li>
                            <li<?php if ($hl_sub == 1 && $tab == 4) echo ' class="active"' ?>><a
                                    href="/<?php echo $community->portalName ?>/account/communities/<?php echo $community->portalName ?>"><i
                                        class="fa fa-cogs"></i>Manage Community</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- End Contacts -->
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- Search Block -->
                <li class="no-border">
                    <i class="search fa fa-search search-btn"></i>

                    <div class="search-open">
                        <form class="page-search-form2 submit-class1">
                            <div class="input-group animated fadeInDown">
                                <input type="text" class="form-control small-search" id="small-search-auto"
                                       placeholder="Search" <?php if ($vars['l']) echo 'value="' . $vars['l'] . '"'; else echo 'value="' . $vars['q'] . '"' ?>>
                                <input type="hidden" id="autoValues1"/>
                                <input type="hidden" class="category-input" value="<?php echo $vars['category'] ?>"/>
                                <input type="hidden" class="subcategory-input"
                                       value="<?php echo $vars['subcategory'] ?>"/>
                                <input type="hidden" class="source-input" value="<?php echo $vars['nif'] ?>"/>
                                <input type="hidden" class="search-community"
                                       value="<?php echo $community->portalName ?>"/>

                                <div class="autocomplete_append1 auto" style="z-index:10"></div>
                                    <span class="input-group-btn">
                                        <button class="btn-u form-submit-button1" type="button">Go</button>
                                    </span>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- End Search Block -->
            </ul>
        </div>
    </div>
    <!--/navbar-collapse-->
</div>
<!-- End Navbar -->

<?php if ($vars['editmode']) {
    echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
    echo '<div class="pull-right">';
    echo '<button class="btn-u btn-u simple-toggle" modal=".cont-select-container" title="Add About Page"><i class="fa fa-plus"></i><span class="button-text"> Add</span></button><button class="btn-u btn-u-default edit-body-btn" componentType="other" componentID="' . $component->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button></div>';
    echo '</div>';
} ?>
</div>
<?php if ($vars['editmode']) { ?>
    <div class="cont-select-container large-modal back-hide">
        <div class="close dark">X</div>
        <div class="selection">
            <h2 align="center">Select a Container to Add</h2>

            <div class="components-select">
                <?php
                echo $component->getContainerSelectHTML($community->id);
                ?>
            </div>
        </div>
    </div>
    <div class="container-add-load back-hide"></div>
<?php } ?>
<div class="container login-backing"
     style="<?php if ($errorID && $errorID->type == 'login-fail') echo 'display:block;'; else echo 'display:none;'; ?>position: fixed;left:0;top:0;width:100%;height:100%;z-index: 20000;background: rgba(0,0,0,.8)">
    <!--Reg Block-->
    <form method="post" action="/forms/login.php">
        <div class="reg-block login-box">
            <div class="login-backing close dark">X</div>
            <div class="reg-block-header">
                <h2>Sign In</h2>
            </div>

            <?php if ($errorID && $errorID->type == 'login-fail') { ?>
                <div class="alert alert-danger">
                    <?php
                    echo $errorID->message;
                    $errorID->setSeen();
                    ?>
                </div>
            <?php } ?>

            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="input-group-addon simple-toggle login-backing" modal=".forgot-password"
                      style="cursor:pointer;color:#72c02c" title="Forgot Password"><i class="fa fa-question"></i></span>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <button type="submit" class="btn-u btn-block">Log In</button>
                </div>
            </div>
        </div>
    </form>
    <!--End Reg Block-->
</div><!--/container-->
<div class="back-hide forgot-password no-padding">
    <div class="close dark less-right">X</div>
    <div id="sky-form4" class="sky-form" novalidate="novalidate">
        <header>Forgot Password</header>

        <fieldset>
            <p>
                If you have forgotten your password you can enter your email here and get a temporary password
                sent to your email.

            <div class="forgot-pw-container">
                <form class="forgot-pw-form">
                    <div class="input-group">
                        <input type="text" class="form-control forgot-email" name="query" placeholder="Account Email"/>
                                    <span class="input-group-btn">
                                        <button class="btn-u" type="submit">Send</button>
                                    </span>
                    </div>
                </form>
            </div>
            </p>
        </fieldset>
    </div>
</div>

<div class="large-modal back-hide leave-comm">
    <div class="close dark less-right">X</div>
    <h2>Leaving Community</h2>
    <p style="margin:20px 0">
        Are you sure you want to leave this community? Leaving the community will revoke any permissions you have been
        granted in this community.
    </p>
    <div class="btn-u btn-u-default close-btn">No</div>
    <a class="btn-u btn-u-red" href="/forms/leave.php?cid=<?php echo $community->id?>">Yes</a>
</div>
