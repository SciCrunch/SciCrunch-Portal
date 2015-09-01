<?php

$holder = new Resource_Fields();
$fields = $holder->getByType($type->id, $community->id);

if($community->id != 0){
$relation = new Form_Relationship();
$relation->getByRID($community->id,$type->id);
}



?>

<?php
if ($community->id == 0)
    echo Connection::createBreadCrumbs($type->name . ' Form Editing', array('Home', 'Account', 'Manage SciCrunch'), array($profileBase, $profileBase . 'account', $profileBase . 'account/scicrunch?tab=resources'), $type->name . ' Form Editing');
else
    echo Connection::createBreadCrumbs($type->name . ' Form Editing', array('Home', 'Account', 'Communities', $community->shortName), array($profileBase, $profileBase . 'account', $profileBase . 'account/communities', $profileBase . 'account/communities/' . $community->portalName . '?tab=resources'), $type->name . ' Form Editing');
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

                <?php
                if ($community->id == 0) {
                    echo Connection::createProfileTabs(3, $profileBase . 'account/scicrunch', null,array(array('name'=>'Goto Form','url'=>'/create/resource?form='.$type->name)));
                } else {
                    echo Connection::createProfileTabs(3, $profileBase . 'account/communities/' . $community->portalName, $profileBase,array(array('name'=>'Goto Form','url'=>$profileBase.'about/resource?form='.$type->name.'&rel='.$relation->id)));
                }
                ?>

                <div class="pull-right" style="margin-bottom:20px;">
                    <a class="btn-u btn-u-purple" href="/faq/tutorials/30">View Tutorial</a>
                    <button type="button" class="btn-u field-add-btn">Add New Field</button>
                </div>
                <!--Table Search v2-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Provider</th>
                                <th>Type</th>
                                <th>Autocompletes</th>
                                <th>Tooltip</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $communities = array();
                            foreach ($fields as $field) {
                                $count = 0;
                                if($field->tid==0)
                                    echo '<tr style="background:rgba(245,200,200,.4)">';
                                elseif($field->cid==0)
                                    echo '<tr style="background:rgba(245,245,200,.6)">';
                                else
                                    echo '<tr>';

                                echo '<td>' . $field->name . '</td>';
                                if($field->cid==0)
                                    echo '<td>SciCrunch</td>';
                                else {
                                    if($communities[$field->cid])
                                        echo '<td>'.$communities[$field->cid]->shortName.'</td>';
                                    else {
                                        $commu = new Community();
                                        $commu->getByID($field->cid);
                                        $communities[$field->cid] = $commu;
                                        echo '<td>'.$commu->shortName.'</td>';
                                    }
                                }
                                echo '<td>' . $field->type . '</td>';
                                if ($field->autocomplete != '')
                                    echo '<td>Yes</td>';
                                else
                                    echo '<td>No</td>';
                                if ($field->alt != '')
                                    echo '<td>Yes</td>';
                                else
                                    echo '<td>No</td>';
                                echo '<td>';
                                if (($field->tid != 0 && $community->id == $field->cid) || $type->id == -1) {
                                    echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                    echo '<li><a href="javascript:void(0)" class="edit-popup" field="' . $field->id . '"><i class="fa fa-cogs"></i> Edit Field</a></li>';

                                    if ($field->tid != 0 && $field->position > 0)
                                        echo '<li><a href="/forms/resource-forms/field-shift.php?id=' . $field->id . '&direction=up"><i class="fa fa-angle-up"></i> Move Up</a></li>';

                                    if ($field->tid != 0 && $count < count($fields) - 1)
                                        echo '<li><a href="/forms/resource-forms/field-shift.php?id=' . $field->id . '&direction=down"><i class="fa fa-angle-down"></i> Move Down</a></li>';
                                    echo '</ul>
                                    </div>';
                                } else {
                                    echo 'N/A';
                                }
                                echo '</td>';
                                echo '</tr>';
                                $count++;
                            }

                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--End Table Search v2-->
            </div>
            <!--End Profile Body-->
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->

<div class="background"></div>
<div class="field-edit back-hide"></div>
<div class="field-add back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post"
          action="/forms/resource-forms/field-add.php?type=<?php echo $type->id ?>&cid=<?php echo $community->id ?>"
          id="header-component-form" class="sky-form" enctype="multipart/form-data">
        <header>Add Field to <?php echo $type->name ?> Form</header>
        <fieldset>
            <section>
                <label class="label">Field Name</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="name" placeholder="Focus to view the tooltip">
                    <b class="tooltip tooltip-top-right">The Label of the field shown to users</b>
                </label>
            </section>
            <section>
                <label class="label">Position</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="position">
                        <?php
                        $start = false;
                        foreach ($fields as $field) {
                                if ($field->tid == 0 || $field->cid==0)
                                    continue;
                                if (!$start) {
                                    echo '<option value="-1"> Before ' . $field->name . '</option>';
                                    $start = true;
                                }
                                echo '<option value="' . $field->position . '">After ' . $field->name . '</option>';
                            }
                            if ($start == false)
                                echo '<option value="-1">At End</option>';
                        ?>
                    </select>
                </label>
            </section>
            <section>
                <label class="label">Field Type</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="type">
                        <option value="text">Text Input</option>
                        <option value="textarea">Text Area</option>
                        <option value="map-text">File Input</option>
                        <option value="image">Image</option>
                    </select>
                </label>
            </section>
            <section>
                <label class="label">Display Type</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="display">
                        <option value="text">Text</option>
                        <option value="literature-text">Comma Separated PMIDs</option>
                        <option value="map-text">Map based on place</option>
                        <option value="resource">Resource</option>
<!--                        <option value="image">Image</option>-->
                    </select>
                </label>
            </section>
            <section>
                <label class="label">Autocomplete Category</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="autocomplete">
                        <option value="">-- None --</option>
                        <?php
                        $url = 'nif_services_vocab_category_service';
                        $xml = simplexml_load_file($url);
                        if ($xml) {
                            foreach ($xml->category as $category) {
                                $categories[] = $category;
                            }
                            natcasesort($categories);
                            foreach ($categories as $category) {
                                echo '<option value="' . $category . '">' . $category . '</option>';
                            }
                        }
                        ?>
                    </select>
                </label>
            </section>
            <section>
                <label class="label">Tooltip</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="alt" placeholder="Focus to view the tooltip">
                    <b class="tooltip tooltip-top-right">The tooltip shown on select</b>
                </label>
            </section>
            <section>
                <label class="label">Required</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="required">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </label>
            </section>
        </fieldset>
        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
        </footer>
    </form>
</div>
<!--=== End Profile ===-->
