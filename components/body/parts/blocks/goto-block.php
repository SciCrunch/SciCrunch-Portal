<style>
    <?php if($component->color1){?>
    .goto-btn {
        background: <?php echo '#'.$component->color1?>;
    }
    .goto-btn:hover {
        background: <?php echo '#'.$component->color2?>;
    }
    <?php } ?>
</style>
<!--=== Purchase Block ===-->
<div class="purchase <?php if($vars['editmode']) echo 'editmode'?>">
    <div class="container">
        <div class="row">
            <div class="col-md-9 animated fadeInLeft">
                <span><?php echo $component->text1?></span>
                <p><?php echo $component->text2?></p>
            </div>
            <div class="col-md-3 btn-buy animated fadeInRight">
                <a href="<?php echo $component->image?>" class="btn-u btn-u-lg goto-btn"><i class="<?php echo $component->icon1?>"></i> <?php echo $component->text3?></a>
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
        echo '<button class="btn-u btn-u-default edit-body-btn" componentType="body" componentID="'.$component->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$component->id.'" community="'.$community->id.'" class="btn-u btn-u-red component-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';
    } ?>
</div><!--/row-->
<!-- End Purchase Block -->