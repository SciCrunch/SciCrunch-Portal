<?php

include '/vars/dataSource.php';

$component = new Component();
$component->component = $arg3;

$holder = new Component_Data();
$datas = $holder->getByComponent($arg3, $community->id, 0, 20);

//print_r($community);

?>
<style>
    .servive-block-default {
        cursor: pointer;
    }

    .panel-dark .panel-heading {
        background: #555;
        color: #fff;
    }
</style>

<?php
if($community->id==0)
    echo Connection::createBreadCrumbs($component->getTitle().' Data',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=appearance'),$component->getTitle().' Data');
else
    echo Connection::createBreadCrumbs($component->getTitle().' Data',array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=appearance'),$component->getTitle().' Data');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <div class="profile-body">
                <!--Service Block v3-->
                <?php
                if($community->id==0)
                    echo Connection::createProfileTabs(2,$profileBase.'account/scicrunch',null);
                else
                    echo Connection::createProfileTabs(2,$profileBase.'account/communities/'.$community->portalName,$profileBase);
                ?>

                <div class="pull-right" style="margin-bottom:20px;">
                    <a class="btn-u btn-u-purple" href="/faq/tutorials/13">View Tutorial</a>
                    <button type="button" class="btn-u data-add" community="<?php echo $community->id ?>"
                            component="<?php echo $component->component ?>">Add Article
                    </button>
                </div>

                <!--Table Search v2-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th class="hidden-sm">Link</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            if (count($datas) > 0) {
                                foreach ($datas as $data) {
                                    echo '<tr>';
                                    echo '<td>' . $data->title . '</td>';
                                    echo '<td class="td-width">';
                                    echo $data->link;
                                    echo '</td>';
                                    echo '<td>' . number_format($data->views) . '</td>';
                                    echo '<td>';
                                    echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                    if ($data->position > 0)
                                        echo '<li><a href="/forms/component-forms/body-data-shift.php?component=' . $data->id . '&cid=' . $data->cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';

                                    echo '<li><a href="/forms/component-forms/body-data-shift.php?component=' . $data->id . '&cid=' . $data->cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';
                                    echo '<li><a href="javascript:void(0)" data="' . $data->id . '" class="data-edit"><i class="fa fa-cogs"></i> Edit</a></li>';
                                    echo '<li><a href="/forms/component-forms/body-data-delete.php?component=' . $data->id . '&cid=' . $data->cid . '"><i class="fa fa-times"></i> Remove</a></li>
                                        </ul>
                                    </div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td>No Data</td><td></td><td></td><td></td></tr>';
                            }

                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--End Table Search v2-->
            </div>
        </div>
    </div>
</div>

<div class="background"></div>
<div class="data-add-load back-hide">

</div>