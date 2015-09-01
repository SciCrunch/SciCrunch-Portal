<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="row margin-bottom-40">
        <?php
        $holder = new Component_Data();
        $datas = $holder->getByComponent($component->component, $community->id, 0, 4);
        foreach ($datas as $i => $data) {
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="service-block service-block-default" style="background:<?php echo '#'.$data->image?>">
                    <i class="icon-custom rounded-x icon-bg-dark <?php echo $data->icon?>" style="background:<?php echo '#'.$data->color?>;color:<?php echo '#'.$data->image ?>"></i>

                    <h2 class="heading-md" style="color:<?php echo '#'.$data->color?>"><?php echo $data->title ?></h2>

                    <p style="color:<?php echo '#'.$data->color?>"><?php echo $data->description?></p>
                </div>
            </div>
        <?php } ?>

    </div>
    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
        echo '<div class="pull-right">';
        if ($componentCount > 0)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=up"><i class="fa fa-angle-up"></i><span class="button-text"> Shift Up</span></a>';
        if ($componentCount != $componentTotal - 1)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=down"><i class="fa fa-angle-down"></i><span class="button-text"> Shift Down</span></a>';
        echo '<button class="btn-u add-data-btn" componentType="body" componentID="' . $component->component . '" cid="' . $community->id . '"><i class="fa fa-plus"></i><span class="button-text"> Edit</span></button>';

        if($community->id==0)
            echo '<a class="btn-u btn-u-purple" href="/account/scicrunch/dynamic/'.$component->component.'"><i class="fa fa-list-alt"></i></a>';
        else
            echo '<a class="btn-u btn-u-purple" href="/'.$community->portalName.'/account/communities/'.$community->portalName.'/dynamic/'.$component->component.'"><i class="fa fa-list-alt"></i></a>';

        echo '<button class="btn-u btn-u-default edit-body-btn" componentType="body" componentID="' . $component->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="' . $component->id . '" community="' . $community->id . '" class="btn-u btn-u-red component-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';
    } ?>
</div>