<?php $component = $components['search'][0] ?>
<style>
    <?php if($component->color1){?>
    .search-block-v2 h2 {
        color: <?php echo '#'.$component->color1?>;
    }

    <?php } ?>
    <?php if($component->color2){?>
    .search-block-v2 .btn-u {
        background: <?php echo '#'.$component->color2?>;
    }

    <?php } ?>
</style>
<!--=== Search Block Version 2 ===-->
<div class="search-block-v2">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <h2>Search again</h2>

            <form method="get" action="/<?php echo $community->portalName ?>/about/search">
                <div class="input-group">
                    <input type="text" class="form-control" name="query"
                           placeholder="<?php echo $searchText ?>" value="<?php echo $query ?>">
                    <input type="hidden" name="content" value="<?php echo $filter?>"/>
                    <span class="input-group-btn">
                        <button class="btn-u" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/container-->
<!--=== End Search Block Version 2 ===-->

<!--=== Search Results ===-->
<div class="container s-results margin-bottom-50">
    <div class="row">
        <div class="col-md-2 hidden-xs related-search">
            <div class="row">
                <div class="col-md-12 col-sm-4">
                    <h3>All Types</h3>
                    <ul class="list-unstyled">
                        <li <?php if (!$filter) echo 'class="active"' ?>><a
                                href="/<?php echo $community->portalName ?>/about/search?query=<?php echo $query ?>">All Content</a></li>
                        <?php
                        foreach($components['page'] as $compon){
                            if($compon->icon1=='static')
                                continue;
                            if($filter==$compon->text2)
                                echo '<li class="active"><a href="/'.$community->portalName.'/about/search?query='.$query .'&content='.$compon->text2.'">'.$compon->text1.'</a></li>';
                            else
                                echo '<li><a href="/'.$community->portalName .'/about/search?query='.$query .'&content='.$compon->text2.'">'.$compon->text1.'</a></li>';
                        }
                        ?>
                    </ul>
                    <hr>
                </div>
                <div class="col-md-12 col-sm-4">
                    <h3>Most Used Tags</h3>
                    <ul class="list-unstyled">
                        <?php
                        $holder = new Tag();
                        $tags = $holder->getPopularTags(false, $community->id, 0, 5);
                        foreach ($tags as $tag) {
                            echo '<li><a href="/'.$community->portalName .'/about/search?query=tag:' . $tag->tag . '"><i class="fa fa-tags"></i> ' . $tag->tag . '</a></li>';
                        }
                        ?>
                    </ul>
                    <hr>
                </div>
            </div>
        </div>
        <!--/col-md-2-->

        <div class="col-md-10">
            <?php
            $holder = new Component_Data();
            $splits = explode(':', $query);
            if (strtolower($splits[0]) == 'tag') {
                $search = $splits[1];
                $theTag = $splits[1];
            } else {
                $search = $query;
            }

            if ($filter) {
                switch ($filter) {
                    case 'tutorials':
                        $component = 105;
                        $title = 'Tutorials';
                        break;
                    case 'questions':
                        $component = 104;
                        $title = 'Questions';
                        break;
                    default:
                        $component = $holds->component;
                        $title = $holds->text1;
                        break;
                }
                if ($theTag)
                    $results = $holder->tagSearch($search, $community->id, $component, (($page-1)*20), 20);
                else
                    $results = $holder->searchData($search, $community->id, $component, (($page-1)*20), 20);
            } else {
                if ($theTag)
                    $results = $holder->tagSearch($search, $community->id, false, (($page-1)*20), 20);
                else
                    $results = $holder->searchAllFromComm($search, $community->id, (($page-1)*20), 20);

            }

            ?>
            <span class="results-number">Showing <?php echo (($page-1)*20+1).' - '.(($page-1)*20+count($results['results'])) ?> out of <?php echo number_format($results['count']) ?> Articles on page <?php echo $page?></span>
            <!-- Begin Inner Results -->

            <?php
            $compList = array();
            foreach ($results['results'] as $data) {
                if(isset($compList[$data->component])){
                    $compTitle = $compList[$data->component]['title'];
                    $compURL = $compList[$data->component]['url'];
                } else {
                    $dataComp = new Component();
                    if($data->component<200){
                        $compTitle = $dataComp->component_ids[$data->component];
                        $compURL = '/'.$community->portalName.'/about/search?query='.$query.'&content='.$dataComp->component_urls[$data->component];
                        $text2 = $dataComp->component_urls[$data->component];
                    } else {
                        $dataComp->getByType($community->id,$data->component);
                        $compTitle = $dataComp->text1;
                        $compURL = '/'.$community->portalName.'/about/search?query='.$query.'&content='.$dataComp->text2;
                        $text2 = $dataComp->text2;
                    }
                    $compList[$data->component] = array('title'=>$compTitle,'url'=>$compURL,'page'=>$text2);
                }
                $user = new User();
                $user->getByID($data->uid);
                $tags = $data->getTags();
                echo '<div class="inner-results">';
                echo '<h3><a href="/'.$community->portalName.'/about/'.$compList[$data->component]['page'].'/' . $data->id . '">' . $data->title . '</a></h3>';
                echo '<ul class="list-unstyled list-inline blog-tags">';
                echo '<li><i class="fa fa-tags"></i>';
                if ($filter) {
                    $params = '&content=' . $filter;
                } else {
                    $params = '';
                }
                foreach ($tags as $tag) {
                    if ($theTag && $theTag == $tag->tag)
                        echo '<a class="active" href="/'.$community->portalName.'/about/search?query=tag:' . $tag->tag . $params . '">' . $tag->tag . '</a>';
                    else
                        echo '<a href="/'. $community->portalName .'/about/search?query=tag:' . $tag->tag . $params . '">' . $tag->tag . '</a>';
                }
                echo '</li>‎';
                echo '</ul>';
                echo '<div class="overflow-h">';
                echo '<p>' . $data->description . '</p>';
                echo '<ul class="list-inline down-ul">';
                echo '<li><a href="'.$compURL.'">'.$compTitle.'</a></li>';
                echo '<li>' . Connection::longTimeDifference($data->time) . ' - by ' . $user->getFullName() . '</li>';
                echo '</ul>';
                echo '</div></div>';
                echo '<hr/>';
            }
            ?>



            <div class="margin-bottom-30"></div>

            <div class="text-left">
                <?php
                echo '<ul class="pagination">';

                if($filter)
                    $params = 'query='.$query.'&content='.$filter;
                else
                    $params = 'query='.$query;
                $max = ceil($results['count']/20);

                if ($page > 1)
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/'.($page-1).'?'.$params.'">«</a></li>';
                else
                    echo '<li><a href="javascript:void(0)">«</a></li>';

                if ($page - 3 > 0) {
                    $start = $page - 3;
                } else
                    $start = 1;
                if ($page + 3 < $max) {
                    $end = $page + 3;
                } else
                    $end = $max;

                if ($start > 2) {
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/1?'.$params.'">1</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/2?'.$params.'">2</a></li>';
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
                    } else {
                        echo '<li><a href="/'.$community->portalName .'/about/search/page/'.$i.'?'.$params.'">' . number_format($i) . '</a></li>';
                    }
                }

                if ($end < $max - 3) {
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/'.($max-1).'?'.$params.'">' . number_format($max - 1) . '</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/'.$max.'?'.$params.'">' . number_format($max) . '</a></li>';
                }

                if ($page < $max)
                    echo '<li><a href="/'.$community->portalName .'/about/search/page/'.($page+1).'?'.$params.'">»</a></li>';
                else
                    echo '<li><a href="javascript:void(0)">»</a></li>';


                echo '</ul>';
                ?>
            </div>
        </div>
        <!--/col-md-10-->
    </div>
</div>
<!--/container-->