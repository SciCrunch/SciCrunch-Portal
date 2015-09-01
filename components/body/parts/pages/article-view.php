<?php
$user = new User();
$user->getByID($data->uid);

$tags = $data->getTags();
$holder = new Tag();
$popular = $holder->getPopularTags($thisComp->component, $community->id, 0, 15);

?>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row blog-page blog-item">
        <!-- Left Sidebar -->
        <div class="col-md-9 md-margin-bottom-60 <?php if($vars['editmode']) echo 'editmode' ?>">
            <!--Blog Post-->
                <div class="blog margin-bottom-40">
                    <h2><?php echo $data->title ?></h2>

                    <div class="blog-post-tags">
                        <ul class="list-unstyled list-inline blog-info">
                            <li><i class="fa fa-calendar"></i> <?php echo date('h:ia F j, Y', $data->time) ?></li>
                            <li style="margin-left: 10px"><i class="fa fa-pencil"></i> <?php echo $user->getFullName() ?></li>
                        </ul>
                        <ul class="list-unstyled list-inline blog-tags" style="margin-top: 10px">
                            <li>
                                <i class="fa fa-tags"></i>
                                <?php foreach ($tags as $tag) {
                                    echo '<a style="margin:0 3px" href="' . $searchURL .'?query=tag:' . $tag->tag . '">' . $tag->tag . '</a>';
                                }?>
                            </li>
                        </ul>
                    </div>
                    <?php echo $data->content ?>
                </div>
            <!--End Blog Post-->

            <hr>

            <!-- Recent Comments -->

            <!-- End Comment Form -->

            <?php if ($vars['editmode']) {
                echo '<div class="body-overlay"><h3>Article Options</h3>';
                echo '<div class="pull-right">';
                echo '<button class="btn-u btn-u-default edit-body-btn" componentType="data" componentID="'.$data->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$data->id.'" community="'.$community->id.'" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
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
                    <div class="close dark less-right">X</div>
                    <style>
                        .servive-block-default {
                            cursor: pointer;
                        }

                        .panel-dark .panel-heading {
                            background: #555;
                            color: #fff;
                        }
                    </style>
                    <form method="post" action="/forms/component-forms/component-update.php?id=<?php echo $data->id ?>"
                          id="header-component-form" class="sky-form" enctype="multipart/form-data">
                        <div class="row margin-bottom-10">
                            <fieldset>
                                <?php

                                echo $data->getContainerDataForm($thisComp->icon1, $tt);
                                ?>
                            </fieldset>
                        </div>

                        <footer>
                            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                        </footer>
                    </form>
                </div>
                <div class="article-delete back-hide">
                    <div class="close dark">X</div>
                    <h2 style="margin-bottom: 40px">Are you sure you want to delete this article?</h2>
                    <a href="javascript:void(0)" class="btn-u close-btn">No</a>
                    <a href="/forms/component-forms/body-data-delete.php?cid=<?php echo $community->id ?>&component=<?php echo $data->id ?>" class="btn-u btn-u-default" style="">Yes</a>

                </div>
            <?php } ?>
        </div>
        <!-- End Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="col-md-3 magazine-page">
            <!-- Search Bar -->
            <div class="headline headline-md"><h2>Search</h2></div>
            <form method="get" action="<?php echo $searchURL ?>">
                <div class="input-group margin-bottom-40">
                    <input type="text" class="form-control" name="query" placeholder="Search">
                    <input type="hidden" name="content" value="<?php echo $vars['title'] ?>"/>
                    <span class="input-group-btn">
                        <button class="btn-u" type="submit">Go</button>
                    </span>
                </div>
            </form>
            <!-- End Search Bar -->

            <!-- Posts -->
            <div class="posts margin-bottom-40">
                <div class="headline headline-md"><h2>
                        Recent <?php echo $thisComp->text1 ?></h2></div>
                <?php
                $datas = $data->getByComponentNewest($thisComp->component, $community->id, 0, 3);
                foreach ($datas as $compData) {
                    echo '<dl class="dl-horizontal">';
                    if ($compData->image)
                        echo '<dt><a href="#"><img src="/upload/community-components/'.$compData->image.'" alt="" /></a></dt>';
                    elseif($community->id != 0)
                        echo '<dt><a href="'.$baseURL . $thisComp->text2 . '/' . $compData->id . '"><img src="/upload/community-logo/' . $community->logo . '" alt="" /></a></dt>';
                    else
                        echo '<dt><a href="'.$baseURL . $thisComp->text2 . '/' . $compData->id . '"><img src="/images/scicrunch.png" alt="" /></a></dt>';
                    echo '<dd>
                    <p><a href="'.$baseURL . $thisComp->text2 . '/' . $compData->id . '">' . $compData->title . '</a></p>
                </dd>
            </dl>';
                }
                ?>

            </div>
            <!--/posts-->
            <!-- End Posts -->

            <!-- Tabs Widget -->


            <!-- Blog Tags -->
            <div class="headline headline-md"><h2><?php echo $thisComp->text1 ?> Tags</h2>
            </div>
            <ul class="list-unstyled blog-tags margin-bottom-30">
                <?php foreach ($popular as $tag) {
                    echo '<li><a href="' . $searchURL.'?query=tag:' . $tag->tag . '"><i class="fa fa-tags"></i> ' . $tag->tag . '</a></li>';
                }?>
            </ul>
            <!-- End Blog Tags -->


            <!-- End Blog Latest Tweets -->
        </div>
        <!-- End Right Sidebar -->
    </div>
    <!--/row-->
</div><!--/container-->
<!--=== End Content Part ===-->