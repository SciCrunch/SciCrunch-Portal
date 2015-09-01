<div class="tab-pane fade <?php if ($section == 'information') echo 'in active' ?>" id="information">
    <!--Service Block v3-->

    <!--Profile Blog-->
    <div class="panel panel-profile">
        <div class="panel-heading overflow-h">
            <h2 class="panel-title heading-sm pull-left"><i
                    class="fa fa-info"></i>Information</h2>
            <a href="#"><i class="fa fa-cog pull-right"></i></a>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="profile-blog" style="padding:5px;">
                        <a href="/forms/other-forms/clearSearches.php" class="btn-u">Clear Search Cache</a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="profile-blog" style="padding:5px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/end row-->
    <!--End Profile Blog-->

    <hr>

    <div class="row margin-bottom-20">
        <!--Profile Post-->
        <div class="col-sm-6">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-group"></i>Users</h2>
                    <a href="<?php echo $profileBase?>account/scicrunch/users"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar" class="panel-body contentHolder">
                    <?php
                    $holder = new User();
                    $users = $holder->getUsers(0, 20);
                    $colors = array('color-two', 'color-four', 'color-one', 'color-three');
                    $levels = array('User', 'Curator', 'Moderator', 'Administrator');
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            ?>
                            <div class="profile-post <?php echo $colors[$user->role] ?>" style="position: relative">

                                <div class="profile-post-in" style="margin-left: 10px;;margin-right: 60px">
                                    <h3 class="heading-xs"><a href="#"><?php echo $user->getFullName() ?></a></h3>

                                    <p><?php echo $levels[$user->role] ?></p>
                                </div>
                                <?php if($_SESSION['user']->role>$user->role){?>
                                <div class="btn-group" style="position:absolute;right:10px;top:20px ">
                                    <button type="button" class="btn-u btn-u-default btn-default dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-cog"></i>
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="left:auto;right:0">
                                        <li><a href="javascript:void(0)" level="<?php echo $user->role ?>"
                                               class="user-edit" uid="<?php echo $user->id ?>"
                                               user="<?php echo $user->getFullName(); ?>"><i class="fa fa-wrench"></i> Edit
                                                Permissions</a></li>
                                        <li>
                                            <a href="/forms/scicrunch-forms/user-delete.php?uid=<?php echo $user->id ?>"><i
                                                    class="fa fa-times"></i> Remove User</a></li>
                                    </ul>
                                </div>
                                <?php } ?>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <a href="<?php echo $profileBase?>account/scicrunch/users" class="btn-u btn-u-dark" style="width:100%;text-align: center;margin-top: 10px;">SEE ALL</a>
            </div>
        </div>
        <!--End Profile Post-->

        <!--Profile Event-->
        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Sources</h2>
                    <a href="<?php echo $profileBase?>account/scicrunch/sources"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    $holder = new Sources();
                    $recent = $holder->getRecentlyAdded(0,10);
                    foreach ($recent as $source) {
                        echo '<div class="profile-event">';
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $source->getTitle() . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
            <a href="<?php echo $profileBase?>account/scicrunch/sources" class="btn-u btn-u-dark" style="width:100%;text-align: center;margin-top: 10px;">SEE ALL</a>
        </div>
        <!--End Profile Event-->
    </div>
    <!--/end row-->

</div>

<div class="back-hide user-edit-container no-padding">
    <div class="close dark less-right">X</div>
    <form action="/forms/scicrunch-forms/user-edit.php" method="post"
          class="sky-form create-form" enctype="multipart/form-data">

        <fieldset>
            <section>
                <label class="label">User</label>
                <div class="theName"></div>
                <input name="uid" type="hidden" class="uid"/>
            </section>
            <section>
                <label class="label">User Level</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="level" class="edit-level">
                        <?php
                        for($i=0;$i<3;$i++){
                            if($_SESSION['user']->role>=$i)
                                echo '<option value="'.$i.'">'.$levels[$i].'</option>';
                        }
                        ?>
                    </select>
                </label>
            </section>
        </fieldset>
        <footer>
            <button class="btn-u btn-u-default" type="submit">Edit User</button>
        </footer>
    </form>
</div>