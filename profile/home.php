<style>
    .profile-name {
        font-size: 38px;
        color: #fff;
    }

    .profile .date-formats.blue {
        background: #3498db;
    }
</style>
<?php

    echo Connection::createBreadCrumbs('My Account',array('Home'),array($profileBase),'My Account');
?>

<div class="profile container content">
<div class="row">
<!--Left Sidebar-->
<?php include 'left-column.php'; ?>
<!--End Left Sidebar-->

<div class="col-md-9">
<!--Profile Body-->
<div class="profile-body">

<?php $roles = array('User', 'Curator', 'Administrator') ?>

<!--Service Block v3-->
<div class="row margin-bottom-10">
    <div class="col-sm-6 sm-margin-bottom-20">
        <div class="service-block-v3 service-block-u">
            <i class="icon-users"></i>
            <span class="profile-name"><?php echo $_SESSION['user']->getFullName() ?></span>

            <a href="/account/edit" class="btn-u btn-u-purple pull-right">Edit</a>

            <div class="clearfix margin-bottom-10"></div>

            <div class="row margin-bottom-20">
                <div class="col-xs-6 service-in">
                    <small>Email</small>
                    <h4><?php echo $_SESSION['user']->email ?></h4>
                </div>
                <div class="col-xs-6 text-right service-in">
                    <small>Role</small>
                    <h4><?php echo $roles[$_SESSION['user']->role] ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="service-block-v3 service-block-blue">
            <i class="fa fa-bell-o"></i>
            <span class="service-heading">Total Actions</span>
            <span class="counter">
                <?php
                $holder = new Notification();
                echo $holder->getNotificationCount($_SESSION['user']->id, 0);
                ?>
            </span>

            <div class="clearfix margin-bottom-10"></div>

            <div class="row margin-bottom-20">
                <div class="col-xs-6 service-in">
                    <small>Last 7 Days</small>
                    <h4 class="counter">
                        <?php
                        echo $holder->getNotificationCount($_SESSION['user']->id, time() - 60 * 60 * 24 * 7);
                        ?>
                    </h4>
                </div>
                <div class="col-xs-6 text-right service-in">
                    <small>Last 30 Days</small>
                    <h4 class="counter">
                        <?php
                        echo $holder->getNotificationCount($_SESSION['user']->id, time() - 60 * 60 * 24 * 30);
                        ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/end row-->
<!--End Service Block v3-->

<hr>

<div class="row margin-bottom-20">
    <!--Profile Post-->
    <div class="col-sm-6 md-margin-bottom-20">
        <div class="panel panel-profile no-bg">
            <div class="panel-heading overflow-h">
                <h2 class="panel-title heading-sm pull-left"><i class="fa fa-briefcase"></i>News Feed</h2>
                <a href="#"><i class="fa fa-cog pull-right"></i></a>
            </div>
            <div id="scrollbar2" class="panel-body contentHolder">
                <?php
                foreach ($_SESSION['user']->levels as $cid => $level) {
                    if ($level > 0)
                        $cids[] = $cid;
                }
                $notes = $holder->getNotificationsByComms($cids);
                $users = array();
                $comms = array();
                foreach ($notes as $note) {
                    if (!isset($comms[$note->cid])) {
                        $thisComm = new Community();
                        $thisComm->getByID($note->cid);
                        $comms[$note->cid] = $thisComm;
                    } else {
                        $thisComm = $comms[$note->cid];
                    }
                    if (!isset($users[$note->receiver])) {
                        $thisUser = new User();
                        $thisUser->getByID($note->receiver);
                        $users[$note->receiver] = $thisUser;
                    } else {
                        $thisUser = $users[$note->receiver];
                    }
                    echo '<div class="profile-event" style="min-height: 80px">';
                    echo '<div class="date-formats">';
                    echo '<span>' . date('d', $note->time) . '</span>';
                    echo '<small>' . date('m, Y', $note->time) . '</small>';
                    echo '</div>';
                    echo '<div class="overflow-h">';
                    echo '<h3 class="heading-xs"><a href="/' . $thisComm->portalName . '">' . $thisComm->name . '</a></h3>';
                    echo '<p>' . $thisUser->getFullName() . ' ' . $note->content . '</p>';
                    echo '</div></div>';
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
                <h2 class="panel-title heading-sm pull-left"><i class="fa fa-briefcase"></i>Recent Articles</h2>
                <a href="#"><i class="fa fa-cog pull-right"></i></a>
            </div>
            <div id="scrollbar2" class="panel-body contentHolder">
                <?php
                $cids[] = 0;
                $holder = new Component_Data();
                $comps = array();
                $datas = $holder->getDataByComms($cids);
                $scic = new Community();
                $scic->id = 0;
                $comms[0] = $scic;
                foreach ($datas as $data) {
                    if (!isset($comms[$data->cid])) {
                        $thisComm = new Community();
                        $thisComm->getByID($note->cid);
                        $comms[$note->cid] = $thisComm;
                    } else {
                        $thisComm = $comms[$note->cid];
                    }
                    if (!isset($comps[$data->component])) {
                        $compo = new Component();
                        if ($data->component > 199) {
                            $compo->getByType($data->cid, $data->component);
                            $comps[$data->component] = $compo;
                        } else {
                            $compo->component = $data->component;
                            $compo->type = 'body';
                            $comps[$data->component] = $compo;
                        }
                    } else {
                        $compo = $comps[$data->component];
                    }
                    if ($compo->type == 'body')
                        $url = $data->link;
                    else {
                        if($thisComm->id==0){
                            $url = '/page/'.$compo->text2.'/'.$data->id;
                        } else
                            $url = '/' . $thisComm->portalName . '/about/' . $compo->text2 . '/' . $data->id;
                    }
                    echo '<div class="profile-event" style="min-height: 80px">';
                    echo '<div class="date-formats blue">';
                    echo '<span>' . date('d', $data->time) . '</span>';
                    echo '<small>' . date('m, Y', $data->time) . '</small>';
                    echo '</div>';
                    echo '<div class="overflow-h">';
                    echo '<h3 class="heading-xs"><a href="' . $url . '">' . $data->title . '</a></h3>';
                    echo '<p>' . $data->description . '</p>';
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!--End Profile Event-->
</div>
<!--/end row-->

<hr>

<!--Profile Blog-->
<div class="panel panel-profile no-bg">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm pull-left"><i class="fa fa-tasks"></i>Member Features</h2>
    </div>
    <div id="scrollbar" class="panel-body contentHolder ps-container">
        <div class="profile-post color-one">
            <span class="profile-post-numb">01</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Create Community</a></h3>

                <p>
                    As a User of SciCrunch you can create as many communities as you see fit and have full control over
                    the contents of that community.
                </p>
            </div>
        </div>
        <div class="profile-post color-two">
            <span class="profile-post-numb">02</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Register Resources</a></h3>

                <p>
                    Registering a Resource in the SciCrunch Registry is only available to SciCrunch members and gives
                    your resource exposure across every community and SciCrunch User.
                </p>
            </div>
        </div>
        <div class="profile-post color-three">
            <span class="profile-post-numb">03</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Contribute to the Existing SciCrunch Registry</a></h3>

                <p>
                    Any SciCrunch User can make edits to existing resources to improve the record. Edits are monitored
                    by our Curation staff to make sure the best presentation of these records are presented.
                </p>
            </div>
        </div>
        <div class="profile-post color-four">
            <span class="profile-post-numb">04</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Create and Use Collections</a></h3>

                <p>
                    SciCrunch allows you to store data records from any source into collections for downloading and
                    analyzing in any way you see fit.
                </p>
            </div>
        </div>
        <div class="profile-post color-five">
            <span class="profile-post-numb">05</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Save Searches</a></h3>

                <p>
                    You can save your complex searches for easy access to when you come back later. These searches
                    will be ran automatically by us to check for new updates to your searches.
                </p>
            </div>
        </div>
        <div class="profile-post color-six">
            <span class="profile-post-numb">06</span>

            <div class="profile-post-in">
                <h3 class="heading-xs"><a href="#">Receive Updates</a></h3>

                <p>
                    By being a member you can get updates on any communities you have joined or about data that you
                    are interested in.
                </p>
            </div>
        </div>

    </div>
</div>
<!--/end row-->
<!--End Profile Blog-->

<!--End Table Search v2-->
</div>
<!--End Profile Body-->
</div>
</div>
<!--/end row-->
</div>
<!--/container-->
<!--=== End Profile ===-->