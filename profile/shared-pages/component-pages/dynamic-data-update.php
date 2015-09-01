<?php

include '/vars/dataSource.php';

$community = new Community();
$community->getByPortalName($arg1);

$data = new Component_Data();
$data->getByID($arg3);
$tags = $data->getTags();
foreach($tags as $tag){
    $tagList[] = $tag->tag;
}

$component_id = $data->component;
$component = new Component();
$component->component = $component_id;

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
    echo Connection::createBreadCrumbs($component->dynamic_titles[$component->component],array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=appearance'),$component->dynamic_titles[$component->component]);
else
    echo Connection::createBreadCrumbs($component->dynamic_titles[$component->component],array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=appearance'),$component->dynamic_titles[$component->component]);
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <?php
            if($community->id==0)
                echo Connection::createProfileTabs(2,$profileBase.'account/scicrunch',null);
            else
                echo Connection::createProfileTabs(2,$profileBase.'account/communities/'.$community->portalName,$profileBase);
            ?>

            <form method="post" action="/forms/community-forms/dynamic-update.php?id=<?php echo $arg3?>" id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10">
                    <fieldset>
                        <section>
                            <label class="label">Title</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="title" placeholder="Focus to view the tooltip" value="<?php echo $data->title?>">
                                <b class="tooltip tooltip-top-right">The Title of the page</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Tags</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="tags" class="" placeholder="Focus to view the tooltip" value="<?php echo join(', ',$tagList)?>">
                                <b class="tooltip tooltip-top-right">Comma Separated Tag list</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Description</label>

                            <textarea rows="3" placeholder="Focus to view the tooltip" class="summer-text" name="description"><?php echo $data->description?></textarea>

                        </section>
                        <section>
                            <label class="label">Content</label>

                            <textarea rows="3" placeholder="Focus to view the tooltip" class="summer-text" name="content"><?php echo $data->content?></textarea>

                        </section>
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