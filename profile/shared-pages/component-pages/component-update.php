<?php

include '/vars/dataSource.php';

$component_id = $arg3;

$data = new Component_Data();
$data->getByID($arg3);

$component = new Component();
if($data->component!=104 && $data->component!=105)
    $component->getByType($community->id,$data->component);
else {
    if($data->component==104)
        $component->icon1 = 'question';
    elseif($data->component==105)
        $component->icon1 = 'tutorial';
}

if($component->type=='page')
    $title = $component->text1;
else
    $title = $component->dynamic_titles[$component->component];

$tags = $data->getTags();
if(count($tags)>0){
    foreach($tags as $tag){
        $tagText[] = $tag->tag;
    }
    $tt = join(', ',$tagText);
} else {
    $tt = '';
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
    echo Connection::createBreadCrumbs('Edit from '.$title,array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=content'),'Edit from '.$title);
else
    echo Connection::createBreadCrumbs('Edit from '.$title,array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=content'),'Edit from '.$title);
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <?php
            if($community->id==0)
                echo Connection::createProfileTabs(1,$profileBase.'account/scicrunch',null);
            else
                echo Connection::createProfileTabs(1,$profileBase.'account/communities/'.$community->portalName,$profileBase);
            ?>
            <!--Profile Body-->

            <form method="post" action="/forms/component-forms/component-update.php?id=<?php echo $arg3?>" id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10">
                    <fieldset>
                        <?php

                        echo $data->getContainerDataForm($component->icon1,$tt);
                        ?>
                    </fieldset>
                </div>

                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>

            <!--End Profile Body-->
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->

<!--=== End Profile ===-->