<?php


$component_id = $arg3;
$component = new Component();

if($component_id!=104 && $component_id!=105)
    $component->getByType($community->id,$component_id);
else {
    if($component_id==104)
        $component->icon1 = 'question';
    elseif($component_id==105)
        $component->icon1 = 'tutorial';
}

if($component->type=='page')
    $title = 'Add to '.$component->text1;
else
    $title = $component->dynamic_titles[$component_id];

if ($component->icon1 == 'series1')
	$pass_position = '&series1_position=' . $component->position;
else	
	$pass_position = '';

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

            <form method="post" action="/forms/component-forms/component-insert.php?id=<?php echo $component_id?>&cid=<?php echo $community->id; echo $pass_position; ?>" id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10">
                    <?php
                    $holder = new Component_Data();
                    echo $holder->getContainerDataForm($component->icon1,'');
                    ?>
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