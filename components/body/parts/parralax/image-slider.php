<div class="tp-banner-container <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="tp-banner">
        <ul>
            <!-- SLIDE -->
            <?php
            $holder = new Component_Data();
            $datas = $holder->getByComponent($component->component, $community->id, 0, 3);
			if( $datas == 0){
				?>
				<li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000">
				<img src="../../../../assets/img/sliders/3.jpg" alt="darkblurbg"
                         data-bgfit="cover" data-bgposition="left top"
                         data-bgrepeat="no-repeat">
				<div class="tp-caption revolution-ch1 sft start"
				         data-x="center"
                         data-hoffset="0"
                         data-y="100"
                         data-speed="1500"
                         data-start="500"
                         data-easing="Back.easeInOut"
                         data-endeasing="Power1.easeIn"
					     data-endspeed="300" 
						 style="color:#FFFFFF;white-space: normal">
                        <?php echo 'Image Slider' ?>
                </div>
				<div class="tp-caption revolution-ch2 sft"
                         data-x="center"
                         data-hoffset="0"
                         data-y="190"
                         data-speed="1400"
                         data-start="2000"
                         data-easing="Power4.easeOut"
                         data-endspeed="300"
                         data-endeasing="Power1.easeIn"
                         data-captionhidden="off"
                         style="z-index: 6;white-space: normal;color:#FFFFFF">
                        <?php echo 'Image Slider Description' ?>
                </div>
				<div class="tp-caption sft"
                         data-x="center"
                         data-hoffset="0"
                         data-y="310"
                         data-speed="1600"
                         data-start="2800"
                         data-easing="Power4.easeOut"
                         data-endspeed="300"
                         data-endeasing="Power1.easeIn"
                         data-captionhidden="off"
                         style="z-index: 6" style="color:#FFFFFF">
                        <a href="<?php echo $community->url ?>" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn
                            More Button</a>
                </div>
				</li>
				<?php
			}
            foreach ($datas as $i => $data) {
                ?>
                <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="/upload/community-components/<?php echo $data->image ?>" alt="darkblurbg"
                         data-bgfit="cover" data-bgposition="left top"
                         data-bgrepeat="no-repeat">

                    <div class="tp-caption revolution-ch1 sft start"
                         data-x="center"
                         data-hoffset="0"
                         data-y="100"
                         data-speed="1500"
                         data-start="500"
                         data-easing="Back.easeInOut"
                         data-endeasing="Power1.easeIn"
                         data-endspeed="300" style="color:<?php echo '#' . $data->color ?>;white-space: normal">
                        <?php echo $data->title ?>
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption revolution-ch2 sft"
                         data-x="center"
                         data-hoffset="0"
                         data-y="190"
                         data-speed="1400"
                         data-start="2000"
                         data-easing="Power4.easeOut"
                         data-endspeed="300"
                         data-endeasing="Power1.easeIn"
                         data-captionhidden="off"
                         style="z-index: 6;white-space: normal;color:<?php echo '#' . $data->color ?>">
                        <?php echo $data->description ?>
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption sft"
                         data-x="center"
                         data-hoffset="0"
                         data-y="310"
                         data-speed="1600"
                         data-start="2800"
                         data-easing="Power4.easeOut"
                         data-endspeed="300"
                         data-endeasing="Power1.easeIn"
                         data-captionhidden="off"
                         style="z-index: 6" style="color:<?php echo '#' . $data->color ?>">
                        <a href="<?php echo $data->link ?>" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn
                            More</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div class="tp-bannertimer tp-bottom"></div>
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

<p><br></p>