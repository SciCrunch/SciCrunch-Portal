
<div class="blog_masonry_3col <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="container content grid-boxes">
        <?php
        foreach($results as $data){
            $user = new User();
            $user->getByID($data->uid);
            ?>
            <div class="grid-boxes-in">
                <div class="grid-boxes-caption">
                    <h3>
                        <a href="/<?php echo $community->portalName?>/about/faq/<?php echo $faq?>/<?php echo $data->id?>"><?php echo $data->title?></a>
                        <?php
                        if(isset($_SESSION['user'])&&$_SESSION['user']->role>0){
                            echo '<a class="pull-right" href="/account/scicrunch/component/update/'.$data->id.'"><i class="fa fa-pencil-square-o"></i></a>';
                        }
                        ?>
                    </h3>
                    <ul class="list-inline grid-boxes-news">
                        <li><span>By</span> <a href="#"><?php echo $user->getFullName()?></a></li>
                        <li>|</li>
                        <li><i class="fa fa-clock-o"></i> <?php echo date('h:ia F j, Y', $data->time) ?></li>
                    </ul>
                    <p><?php echo $data->description?></p>
                </div>
            </div>
        <?php }
        ?>
    </div><!--/container-->
    <?php
    if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>Container Options</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u simple-toggle" modal=".add-content-box" title="Add New '.$thisComp->text1.'"><i class="fa fa-plus"></i></button>
              <a title="Manage the data under this container" href="/'.$community->portalName.'/account/communities/'.$community->portalName.'/view/'.$thisComp->component.'" class="btn-u btn-u-blue"><i class="fa fa-pencil-square-o"></i></a>
              <button class="btn-u btn-u-default simple-toggle" modal=".custom-form" title="Edit Container"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button>
              <a href="javascript:void(0)" componentID="' . $thisComp->component . '" community="' . $community->id . '" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
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
        <div class="large-modal back-hide add-content-box no-padding">
            <div class="close dark less-right">X</div>
            <form method="post" action="/forms/component-forms/component-insert.php?id=<?php echo $thisComp->component?>&cid=<?php echo $community->id?>" id="header-component-form" class="sky-form" enctype="multipart/form-data">

                <header><h2>Add <?php echo $theTitle?></h2></header>
                <div class="row margin-bottom-10">
                    <?php
                    $holder = new Component_Data();
                    echo $holder->getContainerDataForm($thisComp->icon1,'');
                    ?>
                </div>

                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>
        </div>
        <div class="article-delete back-hide">
            <div class="close dark">X</div>
            <h2 style="margin-bottom: 40px">Are you sure you want to delete this article and all data added to it?</h2>
            <a href="javascript:void(0)" class="btn-u close-btn">No</a>
            <a href="/forms/component-forms/container-component-delete.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
               class="btn-u btn-u-default" style="">Yes</a>

        </div>
    <?php
    }

    ?>
</div>