<style>
    <?php if($component->image){?>
    .job-img-2 {
        background: url('/upload/community-components/<?php echo $component->image?>') 70% 40% no-repeat;
    }

    <?php } ?>
    <?php if($component->color1){
        $decimal = Connection::hex2RGB('#'.$component->color1);?>
    .job-img .job-bar {
        background: rgba(<?php echo $decimal['red']?>,<?php echo $decimal['green']?>,<?php echo $decimal['blue']?>, 0.9);
    }

    <?php } ?>
    <?php if($component->color2){?>
    .search-image-btn-2:hover, .search-image-btn-2:focus, .search-image-btn-2:active, .search-image-btn-2.active, .open .search-image-btn-2 {
        background: <?php echo '#'. $component->color2?>;
    }

    .search-image-btn-2 {
        background: <?php echo '#'. $component->color2?>;
    }

    <?php } ?>
    .search-select select {
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.428571429;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
    }
</style>
<div class="job-img margin-bottom-30 job-img-2 <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="job-banner">
        <h2><?php echo $component->text1 ?></h2>
    </div>
    <div class="job-img-inputs job-bar">

        <div class="container">
            <form class="page-search-3">
                <input type="hidden" class="search-community" value="<?php echo $community->portalName ?>"/>

                <div class="row">
                    <div class="col-sm-4 md-margin-bottom-10">
                        <div class="search-select">
                            <select name="category">
                                <option value="Any">Any</option>
                                <?php foreach ($community->urlTree as $cat => $array) {
                                    echo '<option value="' . $cat . '">' . $cat . '</option>';

                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 md-margin-bottom-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            <input type="text" placeholder="<?php echo $component->text2 ?>"
                                   class="form-control searchbar" id="search-block-input">
                            <input type="hidden" id="autoValues"/>

                            <div class="autocomplete_append auto" style="z-index:10"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit"
                                class="btn-u btn-block btn-u-dark search-image-btn-2"> <?php echo $component->text3 ?></button>
                    </div>
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
        echo '<button class="btn-u add-data-btn" componentType="body" componentID="'.$component->component.'" cid="'.$community->id.'"><i class="fa fa-plus"></i><span class="button-text"> Edit</span></button><button class="btn-u btn-u-default edit-body-btn" componentType="body" componentID="'.$component->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$component->id.'" community="'.$community->id.'" class="btn-u btn-u-red component-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';
    } ?>
</div>
