<style>
    .table-search-v1 td a {
        color:#72c02c;
    }
</style>

<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="heading heading-v1 margin-bottom-40">
        <h2><?php echo $thisComp->text1 ?></h2>
    </div>

    <div class="table-search-v1 margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <?php
                    if($thisComp->icon2){
                        $splits = explode(',',$thisComp->icon2);
                        $splits2 = explode(',',$thisComp->icon3);
                        foreach($splits as $i=>$column){
                            echo '<th>'.trim($column).'</th>';
                            if($splits2[$i] && $splits2[$i]!='' && ($splits2[$i]=='text'||$split2[$i]=='textarea'))
                                $columns[$i] = array('label'=>trim($splits[$i]),'type'=>trim($splits2[$i]));
                            else
                                $columns[$i] = array('label'=>trim($splits[$i]),'type'=>'textarea');
                        }
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($datas) > 0) {
                    $dbLabels = array('image','title','icon','description','content','link','color');
                    foreach ($datas as $i => $data) {
                        echo '<tr>';
                        foreach($splits as $i=>$junk){
                            echo '<td>'.$data->$dbLabels[$i].'</td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    foreach ($splits as $i => $data) {
                        if($i==0)
                            echo '<td>No Data Added</td>';
                        else echo '<td></td>';
                    }
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>Container Options</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u simple-toggle" modal=".add-content-box" title="Add New '.$thisComp->text1.'"><i class="fa fa-plus"></i></button><button class="btn-u btn-u-default edit-body-btn" componentType="data" componentID="' . $thisComp->component . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="' . $thisComp->component . '" community="' . $community->id . '" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
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

                <header><h2>Add <?php echo $thisComp->text1?></h2></header>
                <div class="row margin-bottom-10">
                    <?php
                    $holder = new Component_Data();
                    echo $holder->getContainerDataForm($thisComp->icon1,'',$columns);
                    ?>
                </div>

                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>
        </div>
        <div class="article-delete back-hide">
            <div class="close dark less-right">X</div>
            <h2 style="margin-bottom: 40px">Are you sure you want to delete this container and all data added to it?</h2>
            <a href="javascript:void(0)" class="btn-u close-btn">No</a>
            <a href="/forms/component-forms/container-component-delete.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
               class="btn-u btn-u-default" style="">Yes</a>

        </div>
    <?php } ?>
</div>