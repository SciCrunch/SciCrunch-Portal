<style>
    <?php if($component->color1){?>
    .cat-component-headline h2 {
        border-bottom: 2px solid <?php echo '#'.$component->color1?>;
    }

    <?php } ?>
</style>

<?php
$holder = new Component_Data();
$datas = $holder->getByComponent($component->component, $community->id, 0, 8);
?>
<div class="container content <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="headline cat-component-headline" style="margin-top:0"><h2><?php echo $component->text1 ?></h2></div>
    <div class="row category margin-bottom-20">
        <!-- Info Blocks -->
        <div class="col-md-4">
            <?php
            for ($i = 0; $i < 4; $i++) {
                if ($datas[$i]) {
                    echo '<div class="content-boxes-v3">';
                    echo '<a href="' . $datas[$i]->link . '">';
                    echo '<i class="icon-custom icon-sm rounded-x icon-bg-light-grey ' . $datas[$i]->icon . '"></i>';
                    echo '<div class="content-boxes-in-v3">';
                    echo '<h3>' . $datas[$i]->title . '</h3>';
                    echo '<p>' . $datas[$i]->description . '</p>';
                    echo '</div></a></div>';
                }
            }
            ?>
        </div>
        <!-- End Info Blocks -->

        <!-- Info Blocks -->
        <div class="col-md-4">
            <?php
            for ($i = 4; $i < 8; $i++) {
                if ($datas[$i]) {
                    echo '<div class="content-boxes-v3">';
                    echo '<a href="' . $datas[$i]->link . '">';
                    echo '<i class="icon-custom icon-sm rounded-x icon-bg-light-grey ' . $datas[$i]->icon . '"></i>';
                    echo '<div class="content-boxes-in-v3">';
                    echo '<h3>' . $datas[$i]->title . '</h3>';
                    echo '<p>' . $datas[$i]->description . '</p>';
                    echo '</div></a></div>';
                }
            }
            ?>
        </div>
        <!-- End Info Blocks -->

        <div class="col-md-4">
            <!-- Begin Section-Block -->
            <a class="twitter-timeline" href="https://twitter.com/<?php echo $component->text2 ?>"
               data-widget-id="<?php echo $component->text3 ?>">Tweets by @<?php echo $component->text2 ?></a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + "://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");</script>
            <!-- End Section-Block -->
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