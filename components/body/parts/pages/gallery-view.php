<div class="container <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="content">
        <div class="fusion-portfolio wrapper-portfolio cbp-3-col cbp-caption-3-col">
            <div id="grid-container" class="cbp-l-grid-blog">
                <ul>
                    <?php foreach ($datas as $data) {
                        $extended = new Extended_Data();
                        $files = $extended->getByData($data->id, false);
                        ?>
                        <li class="cbp-item motion">
                            <?php if (count($files) > 0){ ?>
                            <a href="/php/file-download.php?type=extended&id=<?php echo $files[0]->id ?>"
                               class="cbp-caption" data-title="<?php echo $data->title ?>">
                                <?php } else { ?>
                                <a href="javascript:void(0);"
                                   class="cbp-caption" data-title="<?php echo $data->title ?>">
                                    <?php } ?>
                                    <div class="cbp-caption-defaultWrap">
                                        <img src="/upload/community-components/<?php echo $data->image ?>" alt=""
                                             width="100%">
                                    </div>
                                    <div class="cbp-caption-activeWrap">
                                        <div class="cbp-l-caption-alignCenter">

                                            <div class="cbp-l-caption-body">
                                                <div class="cbp-l-caption-icon"><i class="fa fa-cloud-download"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="product-description">
                                    <h3><?php echo $data->title ?></h3>
                                </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--/End Wrapper Portfolio-->

        <div class="text-center">
            <ul class="pagination">
                <?php
                $page = $vars['page'];
                $max = $count;
                if ($page > 1)
                    echo '<li><a href="/browse/resources/page/' . ($page - 1) . '?' . $params . '">«</a></li>';
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
                    echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/1">1</a></li>';
                    echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/2">2</a></li>';
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
                    } else {
                        echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/' . $i . '">' . number_format($i) . '</a></li>';
                    }
                }

                if ($end < $max - 3) {
                    echo '<li><a href="javascript:void(0)">..</a></li>';
                    echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/' . ($max - 1) . '">' . number_format($max - 1) . '</a></li>';
                    echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/' . $max . '">' . number_format($max) . '</a></li>';
                }

                if ($page < $max)
                    echo '<li><a href="' . $baseURL . $thisComp->text2 . '/page/' . ($page + 1) . '">»</a></li>';
                else
                    echo '<li><a href="javascript:void(0)">»</a></li>';
                ?>
            </ul>
        </div>
    </div>
    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>Container Options</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u simple-toggle" modal=".add-content-box" title="Add New ' . $thisComp->text1 . '"><i class="fa fa-plus"></i></button>
              <a title="Manage the data under this container" href="/' . $community->portalName . '/account/communities/' . $community->portalName . '/view/' . $thisComp->component . '" class="btn-u btn-u-blue"><i class="fa fa-pencil-square-o"></i></a>
              <button class="btn-u btn-u-default simple-toggle" modal=".custom-form" title="Edit this Container"><i class="fa fa-cogs"></i></button>
              <a href="javascript:void(0)" componentID="' . $thisComp->component . '" community="' . $community->id . '" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';

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
            <form method="post"
                  action="/forms/component-forms/component-insert.php?id=<?php echo $thisComp->component ?>&cid=<?php echo $community->id ?>"
                  id="header-component-form" class="sky-form" enctype="multipart/form-data">

                <header><h2>Add <?php echo $thisComp->text1 ?></h2></header>
                <div class="row margin-bottom-10">
                    <?php
                    $holder = new Component_Data();
                    echo $holder->getContainerDataForm($thisComp->icon1, '');
                    ?>
                </div>

                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>
        </div>
        <div class="article-delete back-hide">
            <div class="close dark">X</div>
            <h2 style="margin-bottom: 40px">Are you sure you want to delete this Container and all data added to
                it?</h2>
            <a href="javascript:void(0)" class="btn-u close-btn">No</a>
            <a href="/forms/component-forms/container-component-delete.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
               class="btn-u btn-u-default" style="">Yes</a>

        </div>
    <?php
    }?>
</div>