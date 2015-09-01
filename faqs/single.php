<?php
$user = new User();
$user->getByID($data->uid);

$tags = $data->getTags();
$holder = new Tag();
$popular = $holder->getPopularTags($component->component, 0, 0, 20);

?>

<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left"><?php echo $component->component_ids[$component->component] ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li>
                <a href="/faq/<?php echo $component->component_urls[$component->component] ?>"><?php echo $component->component_ids[$component->component] ?></a>
            </li>
            <li class="active"><?php echo $data->title ?></li>
        </ul>
    </div>
</div>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row blog-page blog-item">
        <!-- Left Sidebar -->
        <div class="col-md-9 md-margin-bottom-60">
            <!--Blog Post-->
            <div class="blog margin-bottom-40">
                <h2><?php echo $data->title ?></h2>

                <div class="blog-post-tags">
                    <ul class="list-unstyled list-inline blog-info">
                        <li><i class="fa fa-calendar"></i> <?php echo date('h:ia F j, Y', $data->time) ?></li>
                        <li><i class="fa fa-pencil"></i> <?php echo $user->getFullName() ?></li>
                    </ul>
                    <ul class="list-unstyled list-inline blog-tags">
                        <li>
                            <i class="fa fa-tags"></i>
                            <?php foreach ($tags as $tag) {
                                echo '<a href="/browse/content?filter=' . $component->component_urls[$component->component] . '&query=tag:' . $tag->tag . '">' . $tag->tag . '</a>';
                            }?>
                        </li>
                    </ul>
                </div>
                <?php
                if ($component->component == 104)
                    echo $data->description;
                else
                    echo $data->content
                ?>
            </div>
            <!--End Blog Post-->

            <hr>

            <!-- Recent Comments -->

            <!-- End Comment Form -->
        </div>
        <!-- End Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="col-md-3 magazine-page">
            <!-- Search Bar -->
            <div class="headline headline-md"><h2>Search</h2></div>
            <form method="get" action="/browse/content">
                <div class="input-group margin-bottom-40">
                    <input type="text" name="query" class="form-control" placeholder="Search">
                    <input type="hidden" name="filter" value="<?php echo $component->component_urls[$component->component] ?>"/>
                    <span class="input-group-btn">
                        <button class="btn-u" type="submit">Go</button>
                    </span>
                </div>
            </form>
            <!-- End Search Bar -->

            <!-- Posts -->
            <div class="posts margin-bottom-40">
                <div class="headline headline-md"><h2>
                        Recent <?php echo $component->component_ids[$component->component] ?></h2></div>
                <?php
                $datas = $data->getByComponent($component->component, 0, 0, 3);
                foreach ($datas as $compData) {
                    echo '<dl class="dl-horizontal">';
                    if ($compData->image)
                        echo '<dt><a href="/faq/' . $component->component_urls[$component->component] . '/' . $compData->id . '"><img src="/assets/img/sliders/elastislide/6.jpg" alt="" /></a></dt>';
                    echo '<dd>
                    <p><a href="/faq/' . $component->component_urls[$component->component] . '/' . $compData->id . '">' . $compData->title . '</a></p>
                </dd>
            </dl>';
                }
                ?>

            </div>
            <!--/posts-->
            <!-- End Posts -->

            <!-- Tabs Widget -->


            <!-- Blog Tags -->
            <div class="headline headline-md"><h2><?php echo $component->component_ids[$component->component] ?> Tags</h2>
            </div>
            <ul class="list-unstyled blog-tags margin-bottom-30">
                <?php foreach ($popular as $tag) {
                    echo '<li><a href="/browse/content?filter=' . $component->component_urls[$component->component] . '&query=tag:' . $tag->tag . '"><i class="fa fa-tags"></i> ' . $tag->tag . '</a></li>';
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