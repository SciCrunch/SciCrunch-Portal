<div class="tab-pane fade <?php if ($section == 'information') echo 'in active' ?>" id="information">

    <!--Profile Blog-->
    <div class="panel panel-profile">
        <div class="panel-heading overflow-h">
            <h2 class="panel-title heading-sm pull-left"><i
                    class="fa fa-info"></i>Information</h2>
            <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/edit"><i
                    class="fa fa-cog pull-right tut-cog"></i></a>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="profile-blog" style="padding:5px;">
                        <b>Description</b>

                        <p>
                            <?php echo $community->description ?>
                        </p>
                        <b>Website Location</b>

                        <p>
                            <?php echo $community->url ?>
                        </p>
                        <b>Visibility</b>

                        <p>
                            <?php
                            if ($community->private) {
                                echo 'Private';
                            } else {
                                echo 'Public';
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="profile-blog" style="padding:5px;">
                        <b>Logo</b>
                        <img class="img-responsive" style="float:none"
                             src="/upload/community-logo/<?php echo $community->logo ?>"/>
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
                    <a href="javascript:void(0)" class="user-add"><i class="fa fa-plus pull-right"></i></a>
                </div>
                <div id="scrollbar" class="panel-body contentHolder">
                    <?php
                    $users = $community->getUsers();
                    $colors = array('', 'color-two', 'color-four', 'color-one', 'color-three');
                    $levels = array('', 'User', 'Moderator', 'Administrator', 'Owner');
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            ?>
                            <div class="profile-post <?php echo $colors[$user['level']] ?>" style="position: relative">

                                <div class="profile-post-in" style="margin-left: 10px;;margin-right: 60px">
                                    <h3 class="heading-xs"><a href="#"><?php echo $user['name'] ?></a></h3>

                                    <p><?php echo $levels[$user['level']] ?></p>
                                </div>
                                <?php if ($_SESSION['user']->levels[$community->id] > $user['level']) { ?>
                                    <div class="btn-group" style="position:absolute;right:10px;top:20px ">
                                        <button type="button" class="btn-u btn-u-default btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="left:auto;right:0">
                                            <li><a href="javascript:void(0)" level="<?php echo $user['level']?>" class="user-edit" uid="<?php echo $user['uid'] ?>" user="<?php echo $user['name'];?>"><i class="fa fa-wrench"></i> Edit Permissions</a></li>
                                            <li>
                                                <a href="/forms/community-forms/user-remove.php?uid=<?php echo $user['uid']?>&cid=<?php echo $community->id ?>"><i
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
            </div>
        </div>
        <!--End Profile Post-->

        <!--Profile Event-->
        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Sources</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/sources"><i
                            class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    foreach ($community->views as $id => $bool) {
                        echo '<div class="profile-event">';
                        echo '<img src="' . $sources[$id]->image . '" style="width:60px;margin-right:20px;vertical-align:top"/>';
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $sources[$id]->getTitle() . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <!--End Profile Event-->
    </div>
    <!--/end row-->

</div>
<div class="back-hide user-add-container no-padding">
    <div class="close dark less-right">X</div>
    <form action="/forms/community-forms/user-add.php?cid=<?php echo $community->id ?>" method="post"
          class="sky-form create-form" enctype="multipart/form-data">

        <fieldset>
            <section>
                <label class="label">Find Existing User</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" placeholder="Focus to view the tooltip" class="user-find" name="name">
                    <input type="hidden" class="user-id" name="id"/>
                    <input type="hidden" class="cid" value="<?php echo $community->id ?>"/>
                    <div class="autocomplete_append auto" style="z-index:10"></div>
                    <b class="tooltip tooltip-top-right">Search for a user by name or email</b>
                </label>
            </section>
            <section>
                <label class="label">Or Invite New User</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="email" placeholder="Focus to view the tooltip" name="email">
                    <b class="tooltip tooltip-top-right">Email of person to invite</b>
                </label>
            </section>
            <section>
                <label class="label">User Level</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="level">
                        <?php
                        for($i=1;$i<4;$i++){
                            if($_SESSION['user']->levels[$community->id]>=$i)
                                echo '<option value="'.$i.'">'.$levels[$i].'</option>';
                        }
                        ?>
                    </select>
                </label>
            </section>
        </fieldset>
        <footer>
            <button class="btn-u btn-u-default" type="submit">Add User</button>
        </footer>
    </form>
</div>
<div class="back-hide user-edit-container no-padding">
    <div class="close dark less-right">X</div>
    <form action="/forms/community-forms/user-edit.php?cid=<?php echo $community->id ?>" method="post"
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
                        for($i=1;$i<4;$i++){
                            if($_SESSION['user']->levels[$community->id]>=$i)
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