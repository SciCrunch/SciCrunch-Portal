<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left">Add a Resource</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Resource Type Select</li>
        </ul>
    </div>
</div>
<?php

$holder = new Resource_Type();
$results = $holder->getByCommunity(0);
?>

<div class="container s-results margin-bottom-50" style="margin-top:50px">
    <div class="row">
        <div class="col-md-3 hidden-xs related-search">
            <div class="row">
                <div class="col-md-12 col-sm-4">
                    <h4>Resource Types</h4>
                    <p>
                        <a href="/browse/resources">SciCrunch Registry</a> is
                        a dynamic database of research resources (databases, data sets, software tools, materials and services)
                        of interest to and produced by biomedical researchers.
                    </p>
                    <p>
                        Each Research Resource receives a unique ID that allows it to be tracked in the literature and linked
                        to useful information. If you would like to add your resource or recommend a resource for inclusion in the
                        Registry, please follow the steps on this page.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-9 <?php if($vars['editmode']) echo "editmode" ?>">
            <div class="table-search-v2 margin-bottom-20">
                <h2>Step 1. Make sure your resource is not already included</h2>
                <form method="get" class="resource-find-form">
                    <div class="input-group margin-bottom-20">
                        <input type="text" class="form-control type-find" placeholder="Check if your resource already exists"
                               value="">

                                    <span class="input-group-btn">
                                        <button class="btn-u" type="submit">Go</button>
                                    </span>
                    </div>
                </form>
                <div class="resource-load"></div>
                <hr/>
                <h2>Step 2. Enter the resource into the SciCrunch Registry</h2>
                <div class="table-responsive">
                    <table class="table table-hover type-table">
                        <thead>
                        <tr class="first">
                            <th>Resource Type</th>
                            <th style="width:50px">Select</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($results as $data) {
                            echo '<tr values="' . strtolower($data->name) . '"><td>';
                            if ($data->url)
                                echo '<h3><a href="' . $data->url . '">' . $data->name . '</a></h3>';
                            else
                                echo '<h3><a href="/create/resource?form=' . $data->name . '">' . $data->name . '</a></h3>';
                            echo '<p>' . $data->description . '</p>';
                            echo '</td>';
                            if ($data->url)
                                echo '<td><a href="' . $data->url . '"><i class="icon-custom icon-sm rounded-x icon-line icon-bg-green fa fa-chevron-right"></i></a></td>';
                            else
                                echo '<td><a href="/create/resource?form=' . $data->name . '"><i class="icon-custom icon-sm rounded-x icon-line icon-bg-green fa fa-chevron-right"></i></a></td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr class="last">
                            <td>
                                <h3><a href="/create/resource?form=resource">Other</a></h3>

                                <p>
                                    Submit a more general resource to SciCrunch outside of this community
                                </p>
                            </td>
                            <td>
                                <a href="/create/resource?form=resource"><i
                                        class="icon-custom icon-sm rounded-x icon-line icon-bg-green fa fa-chevron-right"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <?php if ($vars['editmode']) {
                echo '<div class="body-overlay"><h3>Community Resource Forms</h3>';
                echo '<div class="pull-right">';
                echo '<button class="btn-u simple-toggle" modal=".type-existing-form"><i class="fa fa-plus"></i><span class="button-text"> Add Existing</span></button><a href="javascript:void(0)" class="btn-u btn-u-default simple-toggle" modal=".type-add-form"><i class="fa fa-plus"></i><span class="button-text"> Add New</span></a></div>';
                echo '</div>';
            } ?>
        </div>
    </div>
</div>
<?php if($vars['editmode']){?>
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
<?php } ?>