<div class="tab-pane fade <?php if ($section == 'content') echo 'in active' ?>" id="content">

    <div class="pull-right" style="margin-bottom:20px;">
        <a class="btn-u btn-u-purple" href="/faq/tutorials/45">View Tutorial</a>
        <button type="button" class="btn-u container-add">Add New Container</button>
    </div>

    <?php
    $start = true;
    foreach ($components['page'] as $container) {
        if ($container->image == 'static') {
            $static[] = $container;
            continue;
        }
        if ($start) {
            echo '<div class="row margin-bottom-20">';
        }
        echo '<div class="col-sm-6 md-margin-bottom-20"><div class="panel panel-profile no-bg"><div class="panel-heading overflow-h" style="overflow: visible;height:45px;">';
        echo '<h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>' . $container->text1 . '</h2>';
        echo '<div class="btn-group pull-right" style="margin-top:-4px;">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
        echo '<li><a href="'.$profileBase.'account/communities/'.$community->portalName.'/component/insert/' . $container->component . '"><i class="fa fa-plus-circle"></i> Add Content</a></li>';
        if($container->position>0)
            echo '<li><a href="/forms/component-forms/container-component-shift.php?component='.$container->id.'&cid='.$community->id.'&direction=up"><i class="fa fa-angle-up"></i> Move Up</a></li>';
        elseif($container->position<count($components['page'])-1)
            echo '<li><a href="/forms/component-forms/container-component-shift.php?component='.$container->id.'&cid='.$community->id.'&direction=down"><i class="fa fa-angle-down"></i> Move Down</a></li>';
        echo '<li><a href="javascript:void(0)" class="edit-container" container="'.$container->id.'" community="'.$community->id.'"><i class="fa fa-wrench"></i> Edit Container</a></li>';
        echo '<li><a href="/forms/component-forms/container-component-delete.php?cid='.$community->id.'&id=' . $container->id . '"><i class="fa fa-times"></i> Delete</a></li>
                                        </ul>
                                    </div>';
        echo '</div>';
        echo '<div class="panel-body contentHolder" style="width:100%">';

        $holder = new Component_Data();
        $datas = $holder->getByComponentNewest($container->component, $community->id, 0, 10);
        foreach ($datas as $data) {
            echo '<div class="profile-event" style="clear:both">';
            if($community->id==0)
                echo $data->dropdown($profileBase.'account/scicrunch',$container->icon1);
            else
                echo $data->dropdown($profileBase.'account/communities/'.$community->portalName,$container->icon1);
            echo '<div class="overflow-h" style="display: inline-block">';
            echo '<h3 class="heading-xs"><a href="#">' . $data->title . '</a></h3>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<a href="'.$profileBase.'account/communities/'.$community->portalName.'/view/'.$container->component.'" class="btn-u btn-u-default" style="width:100%;text-align: center;margin-top: 10px;">SEE ALL</a>';
        echo '</div></div>';
        if ($start) {
            $start = false;
        } else {
            echo '</div><hr/>';
            $start = true;
        }
    }

    if (count($static) > 0) {
        if ($start) {
            echo '<div class="row margin-bottom-20">';
        }
        echo '<div class="col-sm-6 md-margin-bottom-20"><div class="panel panel-profile no-bg"><div class="panel-heading overflow-h" style="overflow: visible;height:45px;">';
        echo '<h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Static Pages</h2>';
        echo '</div>';
        echo '<div id="scrollbar2" class="panel-body contentHolder" style="width:100%">';

        foreach ($static as $data) {
            echo '<div class="profile-event">';
            echo '<div class="btn-group pull-right" style="margin-top:-4px;">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
            echo '<li><a href="javascript:void(0)" class="edit-container" container="'.$container->id.'" community="'.$community->id.'"><i class="fa fa-wrench"></i> Edit Container</a></li>';
            echo '<li><a href="/forms/component-forms/container-component-delete.php?cid='.$community->id.'&id=' . $data->id . '"><i class="fa fa-times"></i> Delete</a></li>
                                        </ul>
                                    </div>';
            echo '<div class="overflow-h" style="display: inline-block">';
            echo '<h3 class="heading-xs"><a href="#">' . $data->text1 . '</a></h3>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div></div></div>';
        echo '</div><hr/>';
    } elseif(!$start){
        echo '</div><hr/>';
    }
    ?>



    <div class="row margin-bottom-20">

        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Questions</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/component/insert/104"><i class="fa fa-plus-circle pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    foreach ($questions as $data) {
                        echo '<div class="profile-event">';
                        if($community->id==0)
                            echo $data->dropdown($profileBase.'account/scicrunch','questions');
                        else
                            echo $data->dropdown($profileBase.'account/communities/'.$community->portalName,'questions');
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $data->title . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
                <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/view/104" class="btn-u btn-u-default" style="width:100%;text-align: center;margin-top: 10px;">SEE ALL</a>
            </div>
        </div>

        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Tutorials</h2>
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/component/insert/105"><i class="fa fa-plus-circle pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    foreach ($tutorials as $data) {
                        echo '<div class="profile-event">';
                        if($community->id==0)
                            echo $data->dropdown($profileBase.'account/scicrunch','tutorials');
                        else
                            echo $data->dropdown($profileBase.'account/communities/'.$community->portalName,'tutorials');
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $data->title . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
                <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName?>/view/105" class="btn-u btn-u-default" style="width:100%;text-align: center;margin-top: 10px;">SEE ALL</a>
            </div>
        </div>
    </div>
</div>
<div class="cont-select-container back-hide">
    <div class="close dark">X</div>
    <div class="selection">
        <h2 align="center">Select a Container to Add</h2>

        <div class="components-select">
            <?php
            $holder = new Component();
            echo $holder->getContainerSelectHTML($community->id);
            ?>
        </div>
    </div>
</div>
<div class="container-add-load back-hide"></div>