<?php
$holder = new Resource();
$curated = $holder->getByCommunity($community->id, 'Curated', 0, 20);
$pending = $holder->getByCommunity($community->id, 'Pending', 0, 20);


$holder = new Form_Relationship();
$relationships = $holder->getByCommunity($community->id, 'resource');
foreach ($relationships as $relationship) {
    $type = new Resource_Type();
    $type->getByID($relationship->rid);
    $types[] = $type;
    $relArray[$type->id] = $relationship->id;
}
function cmp($a, $b) {
    if ($a->name == $b->name) {
        return 0;
    }
    return ($a->name < $b->name) ? -1 : 1;
}

usort($types, "cmp");
?>
<div class="tab-pane fade <?php if ($section == 'resources') echo 'in active' ?>" id="resources">

    <div class="panel panel-profile">
        <div class="panel-heading overflow-h">
            <h2 class="panel-title heading-sm pull-left"><i
                    class="fa fa-list-alt"></i>Community Resource Forms</h2>

            <div class="pull-right" style="margin-top:-4px;">
                <a href="javascript:void(0)" class="simple-toggle btn-u" modal=".type-existing-form">Add Existing</a>
                <a href="javascript:void(0)" class="simple-toggle btn-u btn-u-default" modal=".type-add-form">Create New</a></li>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-search-v2">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="hidden-sm">Description</th>
                            <th>Redirect</th>
                            <th>Insert Time</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($types) > 0) {
                            foreach ($types as $type) {
                                echo '<tr>';
                                echo '<td>' . $type->name . '</td>';
                                echo '<td>' . $type->description . '</td>';
                                if ($type->url)
                                    echo '<td>Yes</td>';
                                else
                                    echo '<td>No</td>';
                                echo '<td>' . date('h:ia F j, Y', $type->time) . '</td>';
                                echo '<td>';
                                echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                if ($type->cid == $community->id)
                                    echo '<li><a href="' . $profileBase . 'account/communities/' . $community->portalName . '/type/edit/' . $type->id . '"><i class="fa fa-cogs"></i> Edit Type</a></li>';
                                echo '<li><a href="' . $profileBase . 'account/communities/' . $community->portalName . '/form/edit/' . $type->id . '"><i class="fa fa-list-alt"></i> Edit Form</a></li>';

                                echo '<li><a href="/forms/resource-forms/relationship-delete.php?id=' . $relArray[$type->id] . '"><i class="fa fa-times"></i> Remove</a></li>
                                        </ul>
                                    </div>';
                                echo '</td>';
                            }
                        } else {
                            echo '<tr><td>No Resource Forms</td><td></td><td></td><td></td><td></td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr/>

    <div class="row margin-bottom-20">

        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Curated Resources
                    </h2>
                    <a href="<?php echo $profileBase ?>account/communities/<?php echo $community->portalName ?>/insert/102"><i
                            class="fa fa-plus-circle pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    foreach ($curated as $data) {
                        echo '<div class="profile-event">';
                        echo '<a href="' . $profileBase . 'account/communities/' . $community->portalName . '/resource/' . $data->id . '"><i style="font-size:20px;margin-top:5px;" class="fa fa-wrench pull-right"></i></a>';
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $data->columns['Resource_Name'] . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="col-sm-6 md-margin-bottom-20">
            <div class="panel panel-profile no-bg">
                <div class="panel-heading overflow-h">
                    <h2 class="panel-title heading-sm pull-left"><i class="fa fa-file-archive-o"></i>Pending Resources
                    </h2>
                    <a href="<?php echo $profileBase ?>account/communities/<?php echo $community->portalName ?>/resource/103"><i
                            class="fa fa-plus-circle pull-right"></i></a>
                </div>
                <div id="scrollbar2" class="panel-body contentHolder">
                    <?php
                    foreach ($pending as $data) {
                        echo '<div class="profile-event">';
                        echo '<a href="' . $profileBase . 'account/communities/' . $community->portalName . '/resource/' . $data->id . '"><i style="font-size:20px;margin-top:5px;" class="fa fa-wrench pull-right"></i></a>';
                        echo '<div class="overflow-h" style="display: inline-block">';
                        echo '<h3 class="heading-xs"><a href="#">' . $data->columns['Resource Name'] . '</a></h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="back-hide large-modal type-existing-form no-padding">
    <div class="close dark less-right">X</div>
    <form method="post"
          action="/forms/resource-forms/type-add-exist.php?cid=<?php echo $community->id ?>"
          id="header-component-form" class="sky-form" style="margin-bottom: 40px;"
          enctype="multipart/form-data">
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

            function cmp2($a, $b)
            {
                if ($a->name == $b->name) {
                    return 0;
                }
                return ($a->name < $b->name) ? -1 : 1;
            }

            usort($types2, "cmp2");
            usort($types, "cmp2");
        } else {
            $holder = new Resource_Type();
            $types2 = $holder->getAllNotMade(0);
            $types = $holder->getAll();
        }

        ?>
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
</div>
<div class="back-hide large-modal type-add-form no-padding">
    <div class="close dark less-right">X</div>
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
</div>