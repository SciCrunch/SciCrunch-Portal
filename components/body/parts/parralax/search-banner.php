<style>
    <?php if($component->image){ ?>
    .search-block {
        background: url('/upload/community-components/<?php echo $component->image ?>') 50% 0 fixed;
    }

    <?php } else { ?>
    .search-block {
        background: url('/upload/community-components/default-12.png') 50% 0 fixed;
    }
    <?php } ?>
    <?php if($component->color1){ ?>
    .search-block form.page-search-form .checkbox, .search-block h1 {
        color: <?php echo '#'.$component->color1 ?>
    }

    <?php } ?>
    <?php if($component->color2){ ?>
    .search-icon, .search-icon:hover {
        background: <?php echo '#'.$component->color2 ?>
    }

    <?php } ?>
    <?php if($component->color3){ ?>
    .save-icon, .save-icon:hover, .save-icon:active, .open .dropdown-toggle.save-icon, .save-icon:focus {
        background: <?php echo '#'.$component->color3 ?>
    }

    <?php } ?>
    .search-block {
        margin-bottom: 0;
    }
</style>

<!--=== Search Block ===-->
<div class="search-block parallaxBg <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <h1><?php echo $component->text1 ?></h1>

            <form action="" class="sky-form page-search-form">
                <input type="hidden" class="search-community" value="<?php echo $community->portalName ?>"/>
                <input type="hidden" class="stripped-community" value="<?php echo $vars['stripped'] ?>"/>
                <div class="input-group">
                    <span class="input-group-btn">
                        <div class="btn-group">
                            <button type="button" class="btn-u save-icon dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-floppy-o"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu" style="text-align: left">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $holder = new Saved();
                                    $searches = $holder->getUserSearches($_SESSION['user']->id);
                                    if (count($searches) > 0) {
                                        foreach ($searches as $saved) {
                                            echo '<li><a href="' . $saved->returnURL() . '"><i class="fa fa-share"></i>' . $saved->name . '</a></li>';
                                        }
                                    } else {
                                        echo '<li><a>No Saved Searches</a></li>';
                                    }
                                } else {
                                    echo '<li><a href="javascript:void(0)" class="btn-login">Login to Save Searches</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </span>
                    <input type="text" class="form-control searchbar" style="height:34px" id="search-banner-input"
                           name="l" placeholder="<?php echo $component->text2 ?>">
                    <input type="hidden" id="autoValues"/>

                    <div class="autocomplete_append auto" style="z-index:10"></div>
                    <span class="input-group-btn">
                        <button class="btn-u search-icon" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>

                <div class="inline-group">
                    <?php
                    $one_group = count($community->urlTree) == 1;
                    if(!$one_group) echo '<label class="checkbox"><input type="radio" name="checkbox-inline" value="Any" checked><i></i>Any</label>';

                    $first = true;
                    foreach ($community->urlTree as $cat => $array) {
                        $checked_string = "";
                        if($first && $one_group) $checked_string = "checked";
                        echo '<label class="checkbox"><input type="radio" name="checkbox-inline" value="' . $cat . '" ' . $checked_string . '><i></i>' . $cat . '</label>';
                        $first = false;
                    }

                    ?>
                </div>
            </form>
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
</div><!--/container-->
<!--=== End Search Block ===-->
