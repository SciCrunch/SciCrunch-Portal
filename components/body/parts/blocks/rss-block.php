<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $component->text1 ?></h2>

            <?php echo $component->text2 ?>
        </div>
        <div class="col-md-6">
            <div class="headline"><h3><?php echo $component->text3 ?></h3></div>
            <div class="scrollbox" style="max-height: 300px;overflow: auto">
            <?php
            $xml = simplexml_load_file($component->image);
            if($xml){
                $image = $xml->channel->image->url;
                foreach($xml->channel->item as $item){?>
                    <dl class="dl-horizontal">
                        <dt><a href="<?php echo $item->link ?>"><img alt="<?php echo $item->title ?>" src="<?php echo $image ?>"></a></dt>
                        <dd>
                            <h3><a href="<?php echo $item->link ?>" style="color:#787878;font-size: 18px"><?php echo $item->title ?></a></h3>
                            <p><a href="<?php echo $item->link ?>" style="color:#000;"><?php echo $item->description ?></a></p>
                        </dd>
                    </dl>
                <?php }
            }
            ?>
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