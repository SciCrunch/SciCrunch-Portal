<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left"><?php echo $theTitle ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/faq">FAQ</a></li>
            <li class="active"><?php echo $theTitle ?></li>
        </ul>
    </div>
</div>
<div class="blog_masonry_3col">
    <div class="container content grid-boxes">
        <?php
        foreach($results as $data){
            $user = new User();
            $user->getByID($data->uid);
            ?>
            <div class="grid-boxes-in">
                <div class="grid-boxes-caption">
                    <h3>
                        <a href="/faq/<?php echo $type?>/<?php echo $data->id?>"><?php echo $data->title?></a>
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
</div>