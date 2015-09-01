<style>
    <?php if($component->color3){?>
    .p-styling p {
        color: <?php echo '#'.$component->color3?>;
    }

    <?php } ?>
</style>
<div class="one-page <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="one-page-inner one-red"
         style="background:<?php echo '#' . $component->color1 ?>;color:<?php echo '#' . $component->color3 ?>">
        <div class="container">
            <h1 style="color:<?php echo '#' . $component->color3 ?>"><?php echo $component->text1 ?></h1>

            <div class="row">
                <div class="col-md-6 p-styling">
                    <?php echo $component->text2 ?>
                    <a class="btn-u btn-u-green one-page-btn" href="<?php echo $component->icon2 ?>"
                       style="background:<?php echo '#' . $component->color2 ?>;color:<?php echo '#' . $component->color3 ?>"><i
                            class="<?php echo $component->icon1 ?>"></i> <?php echo $component->text3 ?></a>
                </div>
                <div class="col-md-6">
                    <img src="/upload/community-components/<?php echo $component->image ?>"
                         class="img-responsive margin-bottom-10" alt="">
                </div>
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
</div>