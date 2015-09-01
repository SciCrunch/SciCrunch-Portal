<?php

include '/vars/dataSource.php';


$types = $type->getByCommunity(0);

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
    echo Connection::createBreadCrumbs('Edit Resource Type',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=resources'),'Edit Resource Type');
else
    echo Connection::createBreadCrumbs('Edit Resource Type',array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=resources'),'Edit Resource Type');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <?php
                if($community->id==0)
                    echo Connection::createProfileTabs(3,$profileBase.'account/scicrunch',null);
                else
                    echo Connection::createProfileTabs(3,$profileBase.'account/communities/'.$community->portalName,$profileBase);
                ?>

                <form method="post" action="/forms/resource-forms/type-edit.php?id=<?php echo $type->id ?>"
                      id="header-component-form" class="sky-form" enctype="multipart/form-data">
                    <header>Edit Resource Type</header>
                    <fieldset>
                        <section>
                            <label class="label">Resource Type Label</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="name" placeholder="Focus to view the tooltip"
                                       value="<?php echo $type->name ?>">
                                <b class="tooltip tooltip-top-right">The Type name</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Description</label>
                            <label class="textarea">
                                <i class="icon-append fa fa-question-circle"></i>
                                <textarea rows="3" placeholder="Focus to view the tooltip"
                                          name="description"><?php echo $type->description ?></textarea>
                                <b class="tooltip tooltip-top-right">A description of this resource type</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Parent Resource Type</label>
                            <label class="select">
                                <i class="icon-append fa fa-question-circle"></i>
                                <select name="parent">
                                    <option value="0" <?php if ($type->parent == 0) echo 'selected' ?>>No Parent
                                        Container Type
                                    </option>
                                    <?php
                                    foreach ($types as $data) {
                                        if ($type->parent == $data->id)
                                            echo '<option value="' . $data->id . '" selected>' . $data->name . '</option>';
                                        else
                                            echo '<option value="' . $data->id . '">' . $data->name . '</option>';
                                    }
                                    ?>
                                </select>
                                <b class="tooltip tooltip-top-right">If there is a parent resource type to select
                                    before submitting.</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Parent Resource Type Facet</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="facet" placeholder="Focus to view the tooltip"
                                       value="<?php echo $type->facet ?>">
                                <b class="tooltip tooltip-top-right">If there is a parent resource to select, what
                                    should the facet for filtering the registry to select it be?</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Redirect URL</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="url" placeholder="Focus to view the tooltip"
                                       value="<?php echo $type->url ?>">
                                <b class="tooltip tooltip-top-right">Only filled in if the type should go to an external form</b>
                            </label>
                        </section>
                    </fieldset>

                    <footer>
                        <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                    </footer>
                </form>

                <!--End Profile Body-->
            </div>
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->

<!--=== End Profile ===-->