<?php

$holder = new Resource();
$resources = $holder->getByUser($_SESSION['user']->id,0,20);

?>
<?php
echo Connection::createBreadCrumbs('My Resources',array('Home','Account'),array($profileBase,$profileBase.'account'),'My Resources');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <!--Service Block v3-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Identifier</th>
                                <th class="hidden-sm">Resource Name</th>
                                <th>Status</th>
                                <th>Insert Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $level_class = array('Curated'=>'label-success','Pending'=>'label-info','Rejected'=>'label-danger');
                            foreach($resources['results'] as $resource){
                                $resource->getColumns();
                                echo '<tr>';
                                echo '<td>'.$resource->rid.'</td>';
                                echo '<td>';
                                echo $resource->columns['Resource Name'];
                                echo '</td>';
                                echo '<td><span class="label '.$level_class[$resource->status].'">'.$resource->status.'</span></td>';
                                echo '<td>'.date('h:ia F j, Y', $resource->insert_time).'</td>';
                                echo '<td><a href="'.$profileBase.'account/resources/edit/'.$resource->rid.'"><i class="fa fa-cog" style="font-size: 20px;margin-right: 10px"></i></a></td>';
                                echo '</tr>';
                            }

                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!--End Profile Body-->
    </div>
    <!--/end row-->
</div>
<!--/container-->
<!--=== End Profile ===-->