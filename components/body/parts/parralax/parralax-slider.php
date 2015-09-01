<style>
    <?php if($component->color1){?>
    .da-slide h2 i {
        background: <?php '#'.$component->color1 ?>;
    }

    <?php }?>
    <?php if($component->image){?>
    .da-slider {
        background: transparent url('/upload/community-components/<?php echo $component->image?>') repeat 0% 0%;
    }

    <?php }?>
    .da-slide h2, .da-slide-current h2 {
        position: relative;
        margin: 0;
        top: auto;
        left: auto;
        margin-bottom: 20px;
    }

    .da-slide .da-img {
        top:0px;
        height: 100%;
    }
    .da-slide .da-img img {
        margin:auto;
        height:80%;
        margin-top:5%;
    }

    .da-slide p, .da-slide-current p {
        position: relative;
        margin: 0;
        top: auto;
        left: auto;
    }

    .da-slide p i {
        line-height: 32px;
        padding: 0;
    }

    .da-slide a {
        color: #fff;
    }
    .da-slide {
        display: none;
    }
    .da-slide-current {
        display: block;
    }
</style>
<!--=== Slider ===-->
<div class="slider-inner <?php if($vars['editmode']) echo 'editmode' ?>">
    <div id="da-slider" class="da-slider">
        <?php
        $holder = new Component_Data();
        $datas = $holder->getByComponent($component->component, $community->id, 0, 3);
        foreach ($datas as $data) {
            echo '<div class="da-slide"><a href="' . $data->link . '">';
            echo '<div style="margin-top:100px;width:30%;margin-left:9%">';
            echo '<h2><i>' . $data->title . '</i></h2>';
            echo '<a href="' . $data->link . '"><p><i>' . $data->description . '</i></p>';
            echo '</div>';
            echo '<div class="da-img"><img class="img-responsive" style="" src="/upload/community-components/' . $data->image . '" alt=""></div>';
            echo '</a></div>';
        }
        ?>
        <div class="da-arrows">
            <span class="da-arrows-prev"></span>
            <span class="da-arrows-next"></span>
        </div>
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
<!--/slider-->
<!--=== End Slider ===-->