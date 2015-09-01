<div class="col-md-3 md-margin-bottom-40">
    <img class="img-responsive profile-img margin-bottom-20" src="<?php echo $_SESSION['user']->get_gravatar() ?>"
         alt="">

    <ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">
        <li class="list-group-item <?php if ($hl_sub == 0) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account"><i class="fa fa-bar-chart-o"></i> Overall</a>
        </li>
        <li class="list-group-item <?php if ($hl_sub == 1) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account/communities"><i class="fa fa-group"></i> Communities</a>
        </li>
        <li class="list-group-item <?php if ($hl_sub == 2) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account/resources"><i class="fa fa-cubes"></i> Resources</a>
        </li>
        <li class="list-group-item <?php if ($hl_sub == 3) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account/saved"><i class="fa fa-floppy-o"></i> Saved Searches</a>
        </li>
        <li class="list-group-item <?php if ($hl_sub == 5) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account/collections"><i class="fa fa-folder-open"></i> My Collections</a>
        </li>
        <?php if($_SESSION['user']->role>0){?>
        <li class="list-group-item <?php if ($hl_sub == 4) echo 'active' ?>">
            <a href="<?php echo $profileBase?>account/scicrunch"><i class="fa fa-cogs"></i> Edit SciCrunch</a>
        </li>
        <?php } ?>
    </ul>

    <hr>


    <!--Notification-->
    <?php
    $holder = new Notification();
    $notifications = $holder->getRecentNotificationsByUser($_SESSION['user']->id);
    ?>
    <div class="panel-heading-v2 overflow-h">
        <h2 class="heading-xs pull-left"><i class="fa fa-bell-o"></i> Notifications</h2>
<!--        <a href="#"><i class="fa fa-cog pull-right"></i></a>-->
    </div>
    <ul id="scrollbar5" class="list-unstyled contentHolder margin-bottom-20">
        <?php
        if (count($notifications) > 0) {
            foreach ($notifications as $notification) {
                echo '<li class="notification">
                    <i class="icon-custom icon-sm rounded-x icon-line '.$notification->icons[$notification->type].'"></i>
                    <div class="overflow-h">
                        <span>'.$notification->content.'</span>
                        <small>'.Connection::timeDifference($notification->time).' ago</small>
                    </div>
                </li>';
            }
        } else {
            echo '<li class="notification">
            <i class="icon-custom icon-sm rounded-x icon-bg-green icon-line fa fa-bell"></i>
            <div class="overflow-h">
                <span>No Notifications</span>
                <small>Now</small>
            </div>
        </li>';
        }
        ?>

    </ul>
<!--    <button type="button" class="btn-u btn-u-default btn-u-sm btn-block">Load More</button>-->
    <!--End Notification-->

    <div class="margin-bottom-50"></div>

    <!--Datepicker-->
    <form action="" id="sky-form2" class="sky-form">
        <div id="inline-start"></div>
    </form>
    <!--End Datepicker-->
</div>