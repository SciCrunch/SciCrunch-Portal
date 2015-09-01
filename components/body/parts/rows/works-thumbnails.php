<style>
    <?php if($component->color1){?>
    .works-component h2 {
        border-bottom: 2px solid <?php echo '#'.$component->color1?>;
    }

    .thumbnail-style a.btn-more {
        background: <?php echo '#'.$component->color1?>;
    }

    <?php } ?>
</style>

<?php
$holder = new Component_Data();
$datas = $holder->getByComponent($component->component, $community->id, 0, 4);
?>
<div class="container <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="headline works-component"><h2><?php echo $component->text1 ?></h2></div>
    <div class="row margin-bottom-20">
        <?php
        for ($i = 0; $i < 4; $i++) {
            echo '<div class="col-md-3 col-sm-6">';
            if ($datas[$i]) {
                echo '<div class="thumbnails thumbnail-style thumbnail-kenburn">';
                echo '<div class="thumbnail-img"><div class="overflow-hidden">';
                echo '<img class="img-responsive works-img" src="/upload/community-components/' . $datas[$i]->image . '" alt="">';
                echo '</div><a class="btn-more hover-effect" href="' . $datas[$i]->link . '">read more +</a></div>';
                echo '<div class="caption"><h3><a class="hover-effect" href="' . $datas[$i]->link . '">' . $datas[$i]->title . '</a></h3>';
                echo '<p>' . $datas[$i]->description . '</p></div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
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