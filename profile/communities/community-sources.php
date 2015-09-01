<?php

$holder = new Sources();
$sources = $holder->getAllSources();


$holder = new Category();
$categories = $holder->getCategories($community->id);

if (!$section) {
    $section = 'information';
}

if ($categories) {
    foreach ($categories as $category) {
        $catArray[$category->category]['pos'] = $category->x;
        if ($category->subcategory) {
            $catArray[$category->category]['subcategories'][$category->subcategory]['pos'] = $category->y;
            $catArray[$category->category]['subcategories'][$category->subcategory]['objects'][] = $category;
        } else {
            $catArray[$category->category]['pos'] = $category->x;
            $catArray[$category->category]['objects'][] = $category;
        }
    }
}

//print_r($catArray);

?>
<style>
    .servive-block-default {
        cursor: pointer;
    }

    .panel-dark .panel-heading {
        background: #555;
        color: #fff;
    }

    .panel-grey .panel-heading {
        background: #95a5a6;
        color: #fff;
    }
</style>
<?php
echo Connection::createBreadCrumbs($community->shortName . ' Categories', array('Home', 'Account', 'Communities', $community->shortName), array($profileBase, $profileBase . 'account', $profileBase . 'account/communities', $profileBase . 'account/communities/' . $community->portalName . '?tab=information'), 'Categories');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <?php echo Connection::createProfileTabs(0, $profileBase . 'account/communities/' . $community->portalName, $profileBase); ?>
            <div class="pull-right" style="margin-bottom:0px;">
                <a class="btn-u btn-u-purple" href="/faq/tutorials/41">View Tutorial</a>
                <button type="button" class="btn-u category-load-btn" cid="<?php echo $community->id ?>" control="add">
                    Add New Category
                </button>
            </div>
            <div style="height:50px;"></div>
            <p style="margin-bottom: 20px">
                SciCrunch works by call each Source individual upon loading your search pages. This means that doing a
                search on a category with 12 sources (on category and within the subcategories) does 12 web service
                calls. Adding more sources might affect the performance of your pages so we recommend keeping the
                number of sources to a minimum. <br/><br/> Note that removing all rows in the sources table will remove
                that category/subcategory.
            </p>
            <?php
            $cat = new Category();
            foreach ($catArray as $category => $array) {
                $x = $array['pos'];
                echo $cat->getPanelHeader(null, $x, null, count($catArray), $category, $community->id, $category, null);
                echo '<div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>';
                echo '<tr>';
                echo '<th>Source Name</th><th>Filter</th><th>Facet</th><th>Actions</th>';
                echo '</tr>
                    </thead>
                    <tbody>';
                $hasSource = false;
                if (count($array['objects']) > 0) {
                    foreach ($array['objects'] as $object) {
                        if ($object->source) {
                            echo '<tr>';
                            echo '<td>' . $sources[$object->source]->getTitle() . '</td>';
                            if ($object->filter) {
                                $splits = explode('&filter=', rawurldecode($object->filter));
                                $realSplits = array_slice($splits, 1);
                                echo '<td>' . join(', ', $realSplits) . '</td>';
                            } else
                                echo '<td>None</td>';
                            if ($object->facet) {
                                $splits = explode('&facet=', rawurldecode($object->facet));
                                $realSplits = array_slice($splits, 1);
                                echo '<td><b>' . join('</b> and <b>', $realSplits) . '</b></td>';
                            } else
                                echo '<td>None</td>';
                            echo '<td>';
                            echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                            if ($object->z > 0)
                                echo '<li><a href="/forms/community-forms/category-shift.php?x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';

                            echo '<li><a href="/forms/community-forms/category-shift.php?x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';
                            echo '<li><a href="javascript:void(0)" data="' . $object->id . '" class="category-edit-btn"><i class="fa fa-cogs"></i> Edit</a></li>';
                            echo '<li><a href="/forms/community-forms/category-delete.php?type=source&x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '"><i class="fa fa-times"></i> Remove</a></li>
                                        </ul>
                                    </div>';
                            echo '</td>';
                            echo '</tr>';
                            $hasSource = true;
                        }
                    }
                    if (!$hasSource)
                        echo '<tr><td>No Sources attached to the Category</td><td></td><td></td><td></td></tr>';
                } else {
                    echo '<tr><td>No Sources attached to the Category</td><td></td><td></td><td></td></tr>';
                }
                echo '</tbody></table></div></div>';

                if (count($array['subcategories']) > 0) {
                    echo '<hr/>';
                    foreach ($array['subcategories'] as $subcategory => $arr) {
                        $y = $arr['pos'];
                        echo $cat->getPanelHeader(true, $x, $y, count($arr), $subcategory, $community->id, $category, $subcategory);
                        echo '<div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>';
                        echo '<tr>';
                        echo '<th>Source Name</th><th>Filter</th><th>Facet</th><th>Actions</th>';
                        echo '</tr>
                    </thead>
                    <tbody>';
                        if (count($arr['objects']) > 0) {
                            $hasSource = false;
                            foreach ($arr['objects'] as $object) {
                                if ($object->source) {
                                    echo '<tr>';
                                    if (!$object->source)
                                        echo '<td>No Source</td>';
                                    else
                                        echo '<td>' . $sources[$object->source]->getTitle() . '</td>';
                                    if ($object->filter) {
                                        $splits = explode('&filter=', rawurldecode($object->filter));
                                        $realSplits = array_slice($splits, 1);
                                        echo '<td>' . join(', ', $realSplits) . '</td>';
                                    } else
                                        echo '<td>None</td>';
                                    if ($object->facet) {
                                        $splits = explode('&facet=', rawurldecode($object->facet));
                                        $realSplits = array_slice($splits, 1);
                                        echo '<td><b>' . join('</b> and <b></b>', $realSplits) . '</b></td>';
                                    } else
                                        echo '<td>None</td>';
                                    echo '<td>';
                                    echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                    if ($object->z > 0)
                                        echo '<li><a href="/forms/community-forms/category-shift.php?x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';

                                    echo '<li><a href="/forms/community-forms/category-shift.php?x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';
                                    echo '<li><a href="javascript:void(0)"class="category-edit-btn" data="' . $object->id . '"><i class="fa fa-cogs"></i> Edit</a></li>';
                                    echo '<li><a href="/forms/community-forms/category-delete.php?type=source&x=' . $object->x . '&y=' . $object->y . '&z=' . $object->z . '&cid=' . $object->cid . '"><i class="fa fa-times"></i> Remove</a></li>
                                        </ul>
                                    </div>';
                                    echo '</td>';
                                    echo '</tr>';
                                    $hasSource = true;
                                }
                            }
                            if(!$hasSource)
                                echo '<tr><td>No Sources attached to the SubCategory</td><td></td><td></td><td></td></tr>';
                        } else {
                            echo '<tr><td>No Sources attached to the SubCategory</td><td></td><td></td><td></td></tr>';
                        }
                        echo '</tbody></table></div></div>';
                        echo '</div></div>';
                    }
                }
                echo '</div></div>';
            }
            ?>
        </div>
    </div>
</div>
<div class="background"></div>
<div class="category-form-load back-hide"></div>
