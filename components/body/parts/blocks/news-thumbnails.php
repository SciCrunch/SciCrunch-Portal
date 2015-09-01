<?php
$holder = new Component_Data();
$datas = $holder->getByComponent($component->component, $community->id, 0, 8);
?>
<!--=== Container Part ===-->
<div class="container margin-bottom-20 <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="title-box-v2">
        <h2><?php echo $component->text1?></h2>
        <p><?php echo $component->text2?></p>
    </div>

    <div class="row margin-bottom-40">
        <?php
        for ($i = 0; $i < 4; $i++) {
            if ($datas[$i]) {
                echo '<div class="col-md-3 col-sm-6 md-margin-bottom-20">';
                echo '<a href="'.$datas[$i]->link.'" class="" data="'.$datas[$i]->id.'" class="data-link">';
                echo '<div class="simple-block">';
                echo '<img class="img-responsive img-bordered news-img" src="/upload/community-components/'.$datas[$i]->image.'" alt="">';
                echo '<p>' . $datas[$i]->title . '</p>';
                echo '</div></a></div>';
            }
        }
        ?>

        <!-- End Simple Block -->
    </div>

    <div class="row margin-bottom-20">
        <?php
        for ($i = 4; $i < 8; $i++) {
            if ($datas[$i]) {
                echo '<div class="col-md-3 col-sm-6 md-margin-bottom-20">';
                echo '<a href="'.$datas[$i]->link.'" data="'.$datas[$i]->id.'" class="data-link">';
                echo '<div class="simple-block">';
                echo '<img class="img-responsive img-bordered news-img" src="/upload/community-components/'.$datas[$i]->image.'" alt="">';
                echo '<p>' . $datas[$i]->title . '</p>';
                echo '</div></a></div>';
            }
        }
        ?>
        <!-- End Simple Block -->
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
</div><!--/container-->