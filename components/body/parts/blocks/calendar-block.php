<style>

</style>

<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="row promo-service">
        <div class="col-md-6 md-margin-bottom-20">
            <div class="responsive-calendar">
                <iframe
                    src="<?php echo $component->text1 ?>"
                    style=" border-width:0 " width="400" height="400" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>

        <div class="col-md-6">
            <div class="responsive-video">
                <iframe width="100%" src="<?php echo $component->text2 ?>" frameborder="0" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
        echo '<div class="pull-right">';
        if ($componentCount > 0)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=up"><i class="fa fa-angle-up"></i><span class="button-text"> Shift Up</span></a>';
        if ($componentCount != $componentTotal - 1)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=down"><i class="fa fa-angle-down"></i><span class="button-text"> Shift Down</span></a>';
        echo '<button class="btn-u add-data-btn" componentType="body" componentID="'.$component->component.'" cid="'.$community->id.'"><i class="fa fa-plus"></i><span class="button-text"> Edit</span></button><button class="btn-u btn-u-default edit-body-btn" componentType="body" componentID="'.$component->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$component->id.'" community="'.$community->id.'" class="btn-u btn-u-red component-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';
    } ?>
</div>