
<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="row-fluid privacy">
        <?php echo $thisComp->text3 ?>
    </div>
    <?php
    if ($vars['editmode']) {
    echo '<div class="body-overlay"><h3>Container Options</h3>';
    echo '<div class="pull-right">';
    echo '<button class="btn-u btn-u-default edit-body-btn" componentType="data" componentID="' . $thisComp->component . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="' . $thisComp->component . '" community="' . $community->id . '" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
    echo '</div>';
    if (count($tags) > 0) {
        foreach ($tags as $tag) {
            $tagText[] = $tag->tag;
        }
        $tt = join(', ', $tagText);
    } else {
        $tt = '';
    }

    ?>


    <div class="custom-form back-hide no-padding">
        <div class="close light less-right">X</div>
        <style>
            .servive-block-default {
                cursor: pointer;
            }

            .panel-dark .panel-heading {
                background: #555;
                color: #fff;
            }
        </style>
        <form method="post"
              action="/forms/component-forms/container-component-edit.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
              id="header-component-form" class="sky-form" enctype="multipart/form-data">
            <?php echo $thisComp->bodyComponentHTML(0, 0, false, array()); ?>
            <footer>
                <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
            </footer>
        </form>
    </div>
    <div class="article-delete back-hide">
        <div class="close dark">X</div>
        <h2 style="margin-bottom: 40px">Are you sure you want to delete this page?</h2>
        <a href="javascript:void(0)" class="btn-u close-btn">No</a>
        <a href="/forms/component-forms/container-component-delete.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
           class="btn-u btn-u-default" style="">Yes</a>

    </div>
<?php
}?>
</div>