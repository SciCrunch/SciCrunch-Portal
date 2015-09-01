<style>
    .table-search-v1 td a {
    color:#72c02c;
    }
</style>

<div class="container content <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="heading heading-v1 margin-bottom-40">
        <h2><?php echo $thisComp->text1 ?></h2>
        <p><?php echo $thisComp->text3 ?></p>
    </div>

    <div class="table-search-v1 margin-bottom-50">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="hidden-sm">Description</th>
                    <?php
                    if($thisComp->icon2){
                        $splits = explode(',',$thisComp->icon2);
                        foreach($splits as $column){
                            echo '<th>'.trim($column).'</th>';
                        }
                    }
                    ?>
                    <th># of Files</th>
                    <th># of Documents</th>
                    <th>Added</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($datas) > 0) {
                    foreach ($datas as $i => $data) {
                        $extend = new Extended_Data();
                        $numFiles = $extend->getCountOfType($data->id, 'file');
                        $numDocs = $extend->getCountOfType($data->id, 'document');
                        $splits2 = explode(',',$data->icon);

                        echo '<tr>';
                        echo '<td><a href="'.$baseURL.$thisComp->text2.'/'.$data->id.'">'. $data->title . '</a></td>';
                        echo '<td>' . $data->description . '</td>';
                        if(count($splits)>0)
                        foreach($splits as $i=>$column){
                            if($splits2[$i])
                                echo '<td>'.$splits2[$i].'</td>';
                            else echo '<td></td>';
                        }

                        echo '<td>' . $numFiles . '</td>';
                        echo '<td>' . $numDocs . '</td>';
                        echo '<td>' . date('h:ia F j, Y', $data->time) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td>No Data Added</td><td></td><td></td><td></td><td></td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php if ($vars['editmode']) {
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
            <div class="close dark less-right">X</div>
            <h2 style="margin-bottom: 40px">Are you sure you want to delete this container and all data added to it?</h2>
            <a href="javascript:void(0)" class="btn-u close-btn">No</a>
            <a href="/forms/component-forms/container-component-delete.php?cid=<?php echo $community->id ?>&id=<?php echo $thisComp->id ?>"
               class="btn-u btn-u-default" style="">Yes</a>

        </div>
    <?php } ?>
</div>
