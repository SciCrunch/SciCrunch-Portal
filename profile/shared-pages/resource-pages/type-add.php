<?php

if ($community->id != 0) {
    $holder = new Form_Relationship();
    $relationships = $holder->getByCommunity($community->id, 'resource');
    foreach($relationships as $rel){
        $typesIDs[] = $rel->rid;
    }

    $holder = new Resource_Type();
    $check = $holder->getAll();

    foreach($check as $type){
        if(!in_array($type->id,$typesIDs))
            $types2[] = $type;
        $types[] = $type;
    }

    function cmp($a, $b)
    {
        if ($a->name == $b->name) {
            return 0;
        }
        return ($a->name < $b->name) ? -1 : 1;
    }

    usort($types2, "cmp");
} else {
    $holder = new Resource_Type();
    $types2 = $holder->getAllNotMade(0);
    $types = $holder->getAll();
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
    echo Connection::createBreadCrumbs('Add Resource Type',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=resources'),'Add Resource Type');
else
    echo Connection::createBreadCrumbs('Add Resource Type',array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=resources'),'Add Resource Type');
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
                <?php

                //print_r($community);
                if (count($types2) > 0) {
                    ?>

                    <form method="post"
                          action="/forms/resource-forms/type-add-exist.php?cid=<?php echo $community->id ?>"
                          id="header-component-form" class="sky-form" style="margin-bottom: 40px;"
                          enctype="multipart/form-data">
                        <header>Add Existing Resource Type</header>
                        <fieldset>
                            <section>
                                <label class="label">Existing Types</label>
                                <label class="select">
                                    <i class="icon-append fa fa-question-circle"></i>
                                    <select name="type">
                                        <?php
                                        foreach ($types2 as $type) {
                                            echo '<option value="' . $type->id . '">' . $type->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </label>
                            </section>
                        </fieldset>

                        <footer>
                            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                        </footer>
                    </form>

                    <div style="height: 2px; background-color: #72c02c; text-align: center;margin-bottom:40px;">
                    <span
                        style="background-color: #f7f7f7; color:#72c02c;font-size:14px; position: relative; top: -0.9em; padding:5px;">
                      Or Create New
                    </span>
                    </div>

                <?php } ?>

                <form method="post" action="/forms/resource-forms/type-add.php?cid=<?php echo $community->id ?>"
                      id="header-component-form" class="sky-form" enctype="multipart/form-data">
                    <header>Add New Resource Type</header>
                    <fieldset>
                        <section>
                            <label class="label">Resource Type Label</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="name" placeholder="Focus to view the tooltip">
                                <b class="tooltip tooltip-top-right">The Type name</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Description</label>
                            <label class="textarea">
                                <i class="icon-append fa fa-question-circle"></i>
                                <textarea rows="3" placeholder="Focus to view the tooltip"
                                          name="description"></textarea>
                                <b class="tooltip tooltip-top-right">A description of this resource type</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Parent Resource Type</label>
                            <label class="select">
                                <i class="icon-append fa fa-question-circle"></i>
                                <select name="parent">
                                    <option value="0">No Parent
                                        Container Type
                                    </option>
                                    <?php
                                    foreach ($types as $data) {
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
                                    >
                                <b class="tooltip tooltip-top-right">If there is a parent resource to select, what
                                    should the facet for filtering the registry to select it be?</b>
                            </label>
                        </section>
                        <section>
                            <label class="label">Redirect URL</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="url" placeholder="Focus to view the tooltip"
                                    >
                                <b class="tooltip tooltip-top-right">Only filled in if the type should go to an external
                                    form</b>
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