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

            <form method="get" action="/<?php echo $community->portalName ?>/about/registry">
                <div class="input-group">
                    <input type="text" class="form-control" name="query"
                           placeholder="<?php echo 'Search across all '.$community->shortName.' resources' ?>" value="<?php echo $query ?>">
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
                    <h3><?php echo $community->shortName?> Resource Types</h3>
                    <ul class="list-unstyled">
                        <?php
                        $holder = new Form_Relationship();
                        $relationships = $holder->getByCommunity($community->id,'Resource');
                        foreach($relationships as $rel){
                            $type = new Resource_Type();
                            $type->getByID($rel->rid);
                            if($filter==$type->name)
                                echo '<li class="active"><a href="/'.$community->portalName.'/about/registry?query='.$query.'&filter='.$type->name.'">'.$type->name.'</a></li>';
                            else
                                echo '<li><a href="/'.$community->portalName.'/about/registry?query='.$query.'&filter='.$type->name.'">'.$type->name.'</a></li>';
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
            $holder = new Resource();

            if ($filter) {
                $results = $holder->searchByComm($community->id,$query,$filter,(($page-1)*20),20);
            } else {
                $results = $holder->searchByComm($community->id,$query,false,(($page-1)*20),20);

            }

            ?>
            <span class="results-number">Showing <?php echo count($results['results']) ?> out of <?php echo number_format($results['count']) ?> Resources on page <?php echo $page?></span>
            <!-- Begin Inner Results -->

            <?php
            $userList = array();
            foreach ($results['results'] as $data) {
                if(!$userList[$data->uid]){
                    $user = new User();
                    if($data->uid==0){
                        $user->firstname = 'Anonymous';
                    } else
                        $user->getByID($data->uid);
                    $userList[$data->uid] = $user;
                } else
                    $user = $userList[$data->uid];
                echo '<div class="inner-results">';
                echo '<h3><a href="/'.$community->portalName.'/about/registry/' . $data->rid . '">' . $data->columns['Resource Name'] . '</a></h3>';
                echo '<div class="overflow-h">';
                echo '<p>' . $data->columns['Description'] . '</p>';
                echo '<ul class="list-inline down-ul">';
                echo '<li><a href="/'.$community->portalName.'/about/registry?query='.$query.'&filter='.$data->type.'">'.$data->type.'</a></li>';
                echo '<li>' . Connection::longTimeDifference($data->insert_time) . ' - by ' . $user->getFullName() . '</li>';
                echo '<li>Last Edited: ' . Connection::longTimeDifference($data->edit_time) . '</li>';
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
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/'.($page-1).'?'.$params.'">«</a></li>';
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
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/1?'.$params.'">1</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/2?'.$params.'">2</a></li>';
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
                    } else {
                        echo '<li><a href="/'.$community->portalName .'/about/registry/page/'.$i.'?'.$params.'">' . number_format($i) . '</a></li>';
                    }
                }

                if ($end < $max - 3) {
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/'.($max-1).'?'.$params.'">' . number_format($max - 1) . '</a></li>';
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/'.$max.'?'.$params.'">' . number_format($max) . '</a></li>';
                }

                if ($page < $max)
                    echo '<li><a href="/'.$community->portalName .'/about/registry/page/'.($page+1).'?'.$params.'">»</a></li>';
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