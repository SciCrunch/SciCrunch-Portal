<?php

include '/vars/dataSource.php';

$component = new Component();
switch($arg3){
    case 104:
        $component->component = 104;
        $title = 'Questions';
        break;
    case 105:
        $component->component=105;
        $title = 'Tutorials';
        break;
    default:
        $component->getByType($community->id,$arg3);
        $title = $component->text1;
        break;
}
$component->component = $arg3;

$holder = new Component_Data();
$datas = $holder->getByComponent($arg3, $community->id, 0, 20);

//print_r($community);

if($component->type=='page'){
    if($community->id==0)
        $goto = array(array('name'=>'Goto Container','url'=>$profileBase.'page/'.$component->text2));
    else
        $goto = array(array('name'=>'Goto Container','url'=>$profileBase.'about/'.$component->text2));
} else {
    $goto = null;
}

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
    echo Connection::createBreadCrumbs($title,array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=content'),$title);
else
    echo Connection::createBreadCrumbs($title,array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=content'),$title);
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
                    echo Connection::createProfileTabs(1,$profileBase.'account/scicrunch',null,$goto);
                else
                    echo Connection::createProfileTabs(1,$profileBase.'account/communities/'.$community->portalName,$profileBase,$goto);
                ?>

                <div class="pull-right" style="margin-bottom:20px;">
                    <a class="btn-u btn-u-purple" href="/faq/tutorials/45">View Tutorial</a>
                    <button type="button" class="btn-u simple-toggle" modal=".add-content-box">Add Article
                    </button>
                </div>

                <!--Table Search v2-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th class="hidden-sm">Description</th>
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
                                    echo $data->description;
                                    echo '</td>';
                                    echo '<td>' . number_format($data->views) . '</td>';
                                    echo '<td>';

                                    if($community->id==0)
                                        echo $data->dropdown($profileBase.'account/scicrunch');
                                    else
                                        echo $data->dropdown($profileBase.'account/communities/'.$community->portalName);
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
<div class="large-modal back-hide add-content-box no-padding">
    <div class="close dark less-right">X</div>
    <form method="post"
          action="/forms/component-forms/component-insert.php?id=<?php echo $component->component ?>&cid=<?php echo $community->id ?>"
          id="header-component-form" class="sky-form" enctype="multipart/form-data">

        <header><h2>Add <?php echo $component->text1 ?></h2></header>
        <div class="row margin-bottom-10">
            <?php
            $holder = new Component_Data();
            echo $holder->getContainerDataForm($component->icon1, '');
            ?>
        </div>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
        </footer>
    </form>
</div>