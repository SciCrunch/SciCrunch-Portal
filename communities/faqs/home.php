<?php

$holder = new Component_Data();

$popQuest = $holder->getByPopularity(104,$community->id,0,7,true);
$techSupp = $holder->tagSearch('tech_support',$community->id,104,0,7);
$sourceHelp = $holder->tagSearch('data_sources',$community->id,104,0,7);
$commHelp = $holder->tagSearch('comm_help',$community->id,104,0,7);
$tuts = $holder->getByPopularity(105,$community->id,0,7,false);

?>


<!--=== FAQ Page ===-->
<div class="container content faq-page">
<!-- FAQ Blocks -->


<!-- FAQ Content -->
<div class="row">
<!-- Begin Tab v1 -->
<div class="col-md-6">
    <div class="tab-v1">
        <ul class="nav nav-tabs margin-bottom-20">
            <li class="active"><a data-toggle="tab" href="#home">Top 7 Questions</a></li>
            <li><a data-toggle="tab" href="#profile">Data Sources</a></li>
            <li><a data-toggle="tab" href="#messages">Community Help</a></li>
            <li><a data-toggle="tab" href="#settings">Technical Support</a></li>
        </ul>
        <div class="tab-content">
            <!-- Tab Content 1 -->
            <div id="home" class="tab-pane fade in active">
                <div id="accordion-v1" class="panel-group acc-v1">
                    <?php
                    $count = 0;
                    foreach($popQuest as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v1" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php if($count==0) echo 'in'?>" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count++;
                    }
                    ?>

                </div>
            </div>
            <!-- End Tab Content 1 -->

            <!-- Tab Content 2 -->
            <div id="profile" class="tab-pane fade">
                <div id="accordion-v2" class="panel-group acc-v1">
                    <?php
                    foreach($sourceHelp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v2" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <!-- Tab Content 2 -->

            <!-- Tab Content 3 -->
            <div id="messages" class="tab-pane fade">
                <div id="accordion-v3" class="panel-group acc-v1">
                    <?php
                    foreach($commHelp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v3" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <!-- Tab Content 3 -->

            <!-- Tab Content 4 -->
            <div id="settings" class="tab-pane fade">
                <div id="accordion-v4" class="panel-group acc-v1">
                    <?php
                    foreach($techSupp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v4" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <!-- Tab Content 4 -->
        </div>
    </div>

    <a href="/<?php echo $community->portalName ?>/about/faq/questions" class="btn-u btn-u-default btn-u-sm btn-block" style="text-align: center">See All Questions</a>
</div>
<!--/col-md-6-->
<!--End Tab v1-->

<div class="col-md-6">
    <div class="tab-v1">
        <ul class="nav nav-tabs margin-bottom-20">
            <li class="active"><a data-toggle="tab" href="#tutHome">Top 7 Tutorials</a></li>
            <li><a data-toggle="tab" href="#tutData">Data Sources</a></li>
            <li><a data-toggle="tab" href="#tutHelp">Community Help</a></li>
            <li><a data-toggle="tab" href="#tutAccount">My Account</a></li>
        </ul>
        <div class="tab-content">
            <!-- Tab Content 1 -->
            <div id="tutHome" class="tab-pane fade in active">
                <div id="accordion-v5" class="panel-group acc-v1">
                    <?php
                    $first = true;
                    foreach($tuts as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v5" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php if($first) echo 'in'?>" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                    <br/>
                                    <a style="margin-top:10px" href="/faq/tutorials/<?php echo $data->id?>" class="btn-u">View Tutorial</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    $first = false;
                    }
                    ?>

                </div>
            </div>
            <!-- End Tab Content 1 -->

            <!-- Tab Content 2 -->
            <div id="tutData" class="tab-pane fade">
                <div id="accordion-v6" class="panel-group acc-v1">
                    <?php
                    $first = true;
                    foreach($sourceHelp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v6" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php if($first) echo 'in'?>" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php
                    $first = false;
                    }
                    ?>
                </div>
            </div>
            <!-- Tab Content 2 -->

            <!-- Tab Content 3 -->
            <div id="tutHelp" class="tab-pane fade">
                <div id="accordion-v7" class="panel-group acc-v1">
                    <?php
                    $first = true;
                    foreach($commHelp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v7" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php if($first) echo 'in'?>" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php
                    $first = false;
                    }
                    ?>
                </div>
            </div>
            <!-- Tab Content 3 -->

            <!-- Tab Content 4 -->
            <div id="tutAccount" class="tab-pane fade">
                <div id="accordion-v8" class="panel-group acc-v1">
                    <?php
                    $first = true;
                    foreach($techSupp as $data){?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapse-<?php echo $data->id?>" data-parent="#accordion-v8" data-toggle="collapse" class="accordion-toggle">
                                        <?php echo $data->title?>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse <?php if($first) echo 'in'?>" id="collapse-<?php echo $data->id?>">
                                <div class="panel-body">
                                    <?php echo $data->description?>
                                </div>
                            </div>
                        </div>
                    <?php
                    $first = false;
                    }
                    ?>
                </div>
            </div>
            <!-- Tab Content 4 -->
        </div>
    </div>
    <a href="/<?php echo $community->portalName?>/about/faq/tutorials" class="btn-u btn-u-default btn-u-sm btn-block" style="text-align: center">See All Tutorials</a>
</div>
<!--/col-md-6-->
<!-- End Popular Topics -->
</div>
<!-- End FAQ Content -->
<div class="margin-bottom-20"></div>

<div class="row extra-support">
    <div class="col-md-6">
        <div class="headline"><h2>More Instructions</h2></div>
        <!-- Begin Banner Info -->
        <div class="banner-info dark margin-bottom-10">
            <i class="rounded-x icon-user-following"></i>

            <div class="overflow-h">
                <h3>User permissions</h3>

                <p>
                    Within Communities we have several different user levels so communities can specify certain people
                    to help them manage the content.
                </p>
            </div>
        </div>
        <div class="banner-info dark margin-bottom-10">
            <i class="rounded-x icon-key"></i>

            <div class="overflow-h">
                <h3>Login Access</h3>

                <p>
                    Communities can set themselves to private or restrict who can join to keep their community more
                    exclusive.
                </p>
            </div>
        </div>
        <div class="banner-info dark margin-bottom-10">
            <i class="rounded-x icon-social-dropbox"></i>

            <div class="overflow-h">
                <h3>Source Updates</h3>

                <p>
                    Sources are update as often as once a week usually near the end of the week.
                </p>
            </div>
        </div>
        <!-- End Banner Info -->
    </div>
    <div class="col-md-6">
        <div class="headline"><h2>Ask a Question</h2></div>
        <!-- Begin Input Group -->
        <p>
            If you are having issues or have requests for SciCrunch, please feel free to send us a question or comment
            and we'll get back to you shortly.
        </p>

        <div class="margin-bottom-20"></div>
        <?php if(!isset($_SESSION['user'])){?>
            <form method="post" action="/forms/login.php">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group margin-bottom-10">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" name="email" placeholder="Email" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group margin-bottom-20">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" placeholder="password" class="form-control">
                        </div>
                    </div>
                </div>
                <input class="btn-u btn-u-sm pull-right" type="submit" value="Login to Ask Questions"/>
            </form>
        <?php } else {?>

            <form method="post" action="/forms/scicrunch-forms/question.php?cid=<?php echo $community->id?>">
                <textarea rows="5" class="form-control margin-bottom-20" placeholder="Type your question here..." name="title"></textarea>
                <input class="btn-u btn-u-sm pull-right" type="submit" value="Send question"/>
            </form>
        <?php }?>
        <!-- End Input-Group -->
    </div>
</div>
</div>