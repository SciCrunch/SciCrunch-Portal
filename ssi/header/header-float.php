
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-34153437-2', 'auto');
    ga('send', 'pageview');

</script>
<style>
    <?php if($component2->color1){?>
    .header-v1 .navbar-default .navbar-nav > li > a:hover, .header-v1 .navbar-default .navbar-nav > .active > a, .header-v1 .navbar-default .navbar-nav > li:hover > a {
        color: #fff;
        background: <?php echo '#'.$component2->color1?> !important;
    }

    .header .dropdown-menu {
        border-top: solid 2px <?php echo '#'.$component2->color1?>;
    }

    .topbar-link:hover {
        color: <?php echo '#'.$component2->color1?>;
    }

    .header .navbar-default .navbar-nav > li > a:hover, .header .navbar-default .navbar-nav > .active > a {
        border-bottom: solid 2px <?php echo '#'.$component2->color1?>;
    }

    .header-v1 .navbar .nav > li > .search:hover {
        background: <?php echo '#'.$component2->color1?>;
    }

    .header .navbar .nav > li > .search:hover {
        color: #fff;
        border-bottom-color: <?php echo '#'.$component2->color1?>;
    }

    <?php } ?>
    .top-v1-data .btn-group.open .dropdown-menu {
        display: block;
        text-align: left;
    }

    .top-v1-data .btn-group.open .dropdown-menu li {
        display: block;
        padding: 0px;
    }

    .header-v1 .navbar-default .navbar-nav > li > a {
        padding: 12px 30px 9px 20px;
    }

    .header-v1 .navbar .nav > li > .search {
        padding: 12px 10px;
    }

    .header .navbar-brand {
        top: 10px;
    }

    .header-v1 .dropdown > a:after {
        top: 13px;
    }
</style>
<div class="header header-v1 <?php if ($vars['editmode']) echo 'editmode' ?>" <?php echo 'style="z-index:101"' ?>>
    <!-- Topbar -->
    <div
        class="topbar-v1 margin-bottom-20" <?php if ($vars['editmode']) echo 'style="position:fixed;top:0;left:0;z-index:110;width:100%"' ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                </div>

                <div class="col-md-6">
                    <ul class="list-unstyled top-v1-data">
                        <?php if (!isset($_SESSION['user'])) { ?>
                            <li><a href="#" class="topbar-link btn-login">Login</a></li>
                            <li><a class="topbar-link" href="/register" class="">Register</a></li>
                        <?php
                        } else {
                            if ($_SESSION['user']->role > 0) {
                                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                $splits = explode('&', $actual_link);
                                if (count($splits) > 1) {
                                    $base = str_replace('&editmode=true', '', $actual_link);
                                    $url = str_replace('&editmode=true', '', $actual_link) . '&';
                                } else {
                                    $base = str_replace('?editmode=true', '', $actual_link);
                                    $url = '?';
                                }
                                if ($vars['editmode']) {
                                    if ($tab == 0 && $hl_sub == 0)
                                        echo '<li><a href="javascript:void(0)" class="component-add"><i class="fa fa-plus"></i> Add Component</a></li>';
                                    echo '<li><a href="' . $base . '"><i class="fa fa-times"></i> Exit Edit Mode</a></li>';
                                } else
                                    echo '<li><a href="' . $url . 'editmode=true">Edit Mode</a></li>';
                            }
                            if ($_SESSION['user']->role>0) {
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            style="padding:5px 12px;font-size: 12px">
                                        Online Users (<?php echo count($_SESSION['user']->onlineUsers) ?>) <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="text-align: left;left:auto;right:0">
                                        <?php

                                        foreach ($_SESSION['user']->onlineUsers as $use) {
                                            echo '<li style="margin-left:0"><a href="javascript:void(0)">'.$use->getFullName().'</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php }
                            if (count($_SESSION['user']->levels) > 0) {
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            style="padding:5px 12px;font-size: 12px">
                                        My Communities <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="text-align: left;left:auto;right:0">
                                        <?php

                                        foreach ($_SESSION['user']->levels as $cid => $level) {
                                            if ($level == 0)
                                                continue;
                                            $comm = new Community();
                                            $comm->getByID($cid);
                                            echo '<li style="margin-left:0"><a href="/' . $comm->portalName . '"><img style="height:15px;width:15px;vertical-align:middle" src="/upload/community-logo/' . $comm->logo . '" /> ' . $comm->name . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <li><a class="topbar-link" href="/forms/logout.php">Logout</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->

    <!-- Navbar -->
    <div class="navbar navbar-default" role="navigation" style="margin-bottom: 20px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <span style="font-size: 36px">SciCrunch</span>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <!-- Home -->
                    <li class="<?php if ($tab == 0) echo 'active' ?> dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Information</a>
                        <ul class="dropdown-menu">
                            <li class="<?php if ($tab == 0 && $hl_sub == 0) echo 'active' ?>"><a href="/">Home</a></li>
                            <?php
                            $pages = $components['page'];
                            foreach ($pages as $pag) {
                                if ($tab == 0 && $hl_sub == $pag->position + 1)
                                    echo '<li class="active"><a href="/page/' . $pag->text2 . '">' . $pag->text1 . '</a></li>';
                                else
                                    echo '<li><a href="/page/' . $pag->text2 . '">' . $pag->text1 . '</a></li>';
                            }

                            ?>
                            <li class="<?php if ($tab == 0 && $hl_sub == -4) echo 'active' ?>"><a href="/resolver">RRID Search</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Home -->

                    <!-- Job Pages -->
                    <li class="<?php if ($tab == 1) echo 'active' ?> dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
                        <ul class="dropdown-menu">
                            <li class="<?php if ($tab == 1 && $hl_sub == 0) echo 'active' ?>"><a
                                    href="/browse/communities">Communities</a></li>
                            <li class="<?php if ($tab == 1 && $hl_sub == 3) echo 'active' ?>"><a
                                    href="/browse/resources">Resources</a></li>
                            <li class="<?php if ($tab == 1 && $hl_sub == 2) echo 'active' ?>"><a href="/browse/content">Content</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Job Pages -->


                    <li class="<?php if ($tab == 2) echo 'active' ?> dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Create</a>
                        <ul class="dropdown-menu">
                            <li><a href="/create/community">New Community</a></li>
                            <li><a href="/create/resource">New Resource</a></li>
                        </ul>
                    </li>

                    <?php if (isset($_SESSION['user'])) {
                        ?>
                        <li class="<?php if ($tab == 3) echo 'active' ?> dropdown tut-myaccount">
                            <a href="javascript:void(0);">My Account</a>
                            <ul class="dropdown-menu">
                                <li class="<?php if ($tab == 3 && $hl_sub == 0) echo 'active' ?>"><a href="/account">Home</a>
                                </li>
                                <li class="<?php if ($tab == 3 && $hl_sub == 1) echo 'active' ?>"><a
                                        href="/account/communities">Communities</a></li>
                                <li class="<?php if ($tab == 3 && $hl_sub == 2) echo 'active' ?>"><a
                                        href="/account/resources">Resources</a></li>
                                <li class="<?php if ($tab == 3 && $hl_sub == 3) echo 'active' ?>"><a
                                        href="/account/saved">Saved Searches</a></li>
                                <li class="<?php if ($tab == 3 && $hl_sub == 5) echo 'active' ?>"><a
                                        href="/account/collections">My Collections</a></li>
                                <?php if($_SESSION['user']->role>0){?>
                                <li class="<?php if ($tab == 3 && $hl_sub == 4) echo 'active' ?>"><a
                                        href="/account/scicrunch">Edit SciCrunch</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <!-- Search Block -->
                    <li>
                        <i class="search fa fa-search search-btn"></i>

                        <div class="search-open">
                            <form method="get" action="/browse/content">
                                <div class="input-group animated fadeInDown">
                                    <input type="text" class="form-control" name="query" placeholder="Search">
                                    <span class="input-group-btn">
                                        <button class="btn-u" type="submit">Go</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- End Search Block -->
                </ul>
            </div>
            <!--/navbar-collapse-->
        </div>
    </div>
    <!-- End Navbar -->

    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $component2->component_ids[$component2->component] . '</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u simple-toggle" modal=".cont-select-container" title="Add About Page"><i class="fa fa-plus"></i><span class="button-text"> Add</span></button><button class="btn-u btn-u-default edit-body-btn" componentType="other" componentID="' . $component2->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button></div>';
        echo '</div>';
    } ?>
</div>
<?php if($vars['editmode']){?>
    <div class="cont-select-container large-modal back-hide">
        <div class="close dark">X</div>
        <div class="selection">
            <h2 align="center">Select a Container to Add</h2>

            <div class="components-select">
                <?php
                echo $component2->getContainerSelectHTML(0);
                ?>
            </div>
        </div>
    </div>
    <div class="container-add-load back-hide"></div>
<?php } ?>
<div class="container login-backing"
     style="<?php if($errorID && $errorID->type=='login-fail') echo 'display:block;'; else echo 'display:none;';?>position: fixed;left:0;top:0;width:100%;height:100%;z-index: 20000;background: rgba(0,0,0,.8)">
    <!--Reg Block-->
    <form method="post" action="/forms/login.php">
        <div class="reg-block login-box">
            <div class="login-backing close dark">X</div>
            <div class="reg-block-header">
                <h2>Sign In</h2>
            </div>

            <?php if($errorID && $errorID->type=='login-fail'){?>
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
