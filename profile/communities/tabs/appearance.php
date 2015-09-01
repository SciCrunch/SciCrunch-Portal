<div class="tab-pane fade <?php if($section=='appearance') echo 'in active'?>" id="appearance">

    <div class="row margin-bottom-20">
        <div class="col-sm-4 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Header</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/components/header"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar3" class="panel-body contentHolder">
                    <div class="profile-event">
                        <div class="overflow-h" style="display: block">
                            <h3 class="heading-xs"><?php echo $components['header'][0]->getName() ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Body</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/components/body"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar4" class="panel-body contentHolder">
                    <?php
                    foreach ($components['body'] as $component) {
                        ?>
                        <div class="profile-event">
                            <div class="overflow-h" style="display: block">
                                <h3 class="heading-xs"><?php echo $component->getName() ?>
                                    <?php
                                    if($component->getDynamicStatus()){
                                        echo '<a href="'.$profileBase.'account/communities/'.$community->portalName.'/dynamic/'.$component->component.'" class="pull-right"><i class="fa fa-file-text-o"></i></a>';
                                    }
                                    ?>
                                </h3>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Footer</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/components/footer"><i class="fa fa-cog pull-right"></i></a>
                </div>
                <div id="scrollbar5" class="panel-body contentHolder">
                    <div class="profile-event">
                        <div class="overflow-h" style="display: block">
                            <h3 class="heading-xs"><?php echo $components['footer'][0]->getName() ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>