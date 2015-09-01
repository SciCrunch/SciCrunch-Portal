<?php

function allNotSameCategory($cat_source){
    if(count($cat_source) <= 1) return false;
    $first = NULL;
    foreach($cat_source as $cat){
        $split = explode("|", $cat);
        if(is_null($first)){
            $first = $split[0];
        }elseif($first != $split[0]){
            return true;
        }
    }
    return false;
}

?>
    <div class="container s-results margin-bottom-50">
    <div class="row">
    <div class="col-md-2 hidden-xs related-search">
        <div class="row">
            <div class="col-md-12 col-sm-4">
                <h3>Options</h3>
                <ul class="list-unstyled">
                    <li><a href="javascript:categoryGraph2(<?php echo "'". str_replace('"','%22',json_encode($results['info']['tree']))."'" ?>)">Category Graph <i class="fa fa-graph"></i></a></li>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <li><a href="javascript:void(0)" class="simple-toggle" modal=".new-collection">Create New
                                Collection</a></li>
                        <li><a href="javascript:void(0)" class="simple-toggle" modal=".add-all">Add All on Page to a
                                Collection</a></li>
                    <?php } else { ?>
                        <li><a href="#" class="login">Log in for Collection Options</a></li>
                    <?php } ?>
                </ul>
                <hr/>
            </div>
            <?php
            if (count($community->urlTree[$vars['category']]['subcategories']) > 0) {
                echo '<div class="col-md-12 col-sm-4">';
                echo '<h3 class="tut-subcategories">Subcategories</h3>';
                echo '<ul class="list-unstyled">';
                foreach ($community->urlTree[$vars['category']]['subcategories'] as $sub => $array) {
                    $newVars = $vars;
                    $newVars['subcategory'] = $sub;
                    if ($vars['subcategory'] && $sub == $vars['subcategory'])
                        echo '<li class="active"><a href="' . $search->generateURL($newVars) . '">' . $sub . ' (' . number_format($results['info']['counts']['subs'][$sub]) . ')</a></li>';
                    elseif($vars['subcategory'])
                        echo '<li><a href="' . $search->generateURL($newVars) . '">' . $sub . '</a></li>';
                    else
                        echo '<li><a href="' . $search->generateURL($newVars) . '">' . $sub . ' (' . number_format($results['info']['counts']['subs'][$sub]) . ')</a></li>';
                }
                echo '</ul><hr/></div>';
            } elseif ($vars['category'] == 'Any') {
                echo '<div class="col-md-12 col-sm-4">';
                echo '<h3 class="tut-categories">Categories</h3>';
                echo '<ul class="list-unstyled">';
                foreach ($results['info']['counts']['subs'] as $sub => $count) {
                    $splits = explode('|', $sub);
                    if (!isset($cate[$splits[0]]))
                        $cate[$splits[0]] = $count;
                    else
                        $cate[$splits[0]] += $count;
                }
                foreach ($cate as $category => $count) {
                    $newVars = $vars;
                    $newVars['category'] = $category;
                    echo '<li><a href="' . $search->generateURL($newVars) . '">' . $category . ' (' . number_format($count) . ')</a></li>';
                }
                echo '</ul><hr/></div>';
            }
            ?>
            <div class="col-md-12 col-sm-4">
                <h3 class="tut-sources">Sources</h3>
                <ul class="list-unstyled">
                    <?php
                    //print_r($results['info']['counts']['nif']);
                    $count_single = 0;
                    foreach ($results['info']['counts']['nif'] as $nif => $count) {
                        $source = $allSources[$nif];
                        $newVars = $vars;
                        $newVars['nif'] = $nif;
                        $category_source = $results['info']['nifDirect'][(string)$nif];
                        if (!in_array('CURRENT', $category_source)) {
                            $splits = explode('|', $category_source[0]);    // just check the first one
                            if(allNotSameCategory($category_source)){
                                $newVars['category'] = "Any";
                            }
                            elseif(count($splits) > 1) {
                                $newVars['category'] = $splits[0];
                                if(count($category_source) == 1) $newVars['subcategory'] = $splits[1];
                            }elseif(count($category_source) == 1){
                                if ($search->category == 'Any'){
                                    $newVars['category'] = $category_source[0];
                                }else{
                                    $newVars['subcategory'] = $category_source[0];
                                }
                            }
                        }
                        echo '<li><a href="' . $search->generateURL($newVars) . '">' . $source->getTitle() . ' (' . number_format($count) . ')</a></li>';
                        if($count > 0) $count_single += 1;
                    }
                    ?>
                </ul>
                <hr>
            </div>

            <?php 
                if($count_single == 1):
            ?>

                <div class="col-md-12 col-sm-4">
        
                    <?php echo $search->currentFacets($vars, 'table') ?>
                    <h3>Facets <a
                            href="javascript:categoryGraph2(<?php echo "'" . str_replace("%27", "\%27", str_replace('"', '%22', json_encode($results['graph']))) . "'" ?>)"><i
                                class="fa fa-bar-chart-o"></i></a></h3>
        
                    <form class="multi-facets" url="<?php echo $search->generateURL($vars) ?>">
                        <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                            <?php
                            foreach ($results['facets'] as $column => $array) {
                                echo '<li class="list-group-item list-toggle" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-' . str_replace(' ', '_', $column) . '"> 
                                  <a href="javascript:void(0)">' . $column . '</a>';
                                echo '<ul id="collapse-' . str_replace(' ', '_', $column) . '" class="collapse">';
                                foreach ($array as $facet) {
                                    $newVars = $vars;
                                    $newVars['facet'][] = $column . ':' . $facet['value'];
                                    echo '<li style="border-top:1px solid #ddd"><a href="' . $search->generateURL($newVars) . '" style="padding-right:30px;display:inline-block;border:0">' . $facet['value'] . ' (' . number_format($facet['count']) . ')</a>';
                                    echo '<div class="pull-right"><div class="checkbox"><input type="checkbox" class="facet-checkbox" style="margin-top:9px" column="'.rawurlencode($column).'" facet="'.rawurlencode($facet['value']).'"/></div></div></li>';
                                }   
        
                                echo '</ul></li>';
                            }   
                            ?>  
                        </ul>
                        <button type="submit" class="btn-u">Perform Search</button>
                    </form>
                    <hr style="margin-top:10px;margin-bottom:15px;"/>
                </div>

            <?php endif; ?>
        </div>
    </div>
    <!--/col-md-2-->

    <div class="col-md-10">
            <span class="results-number">
                <?php echo $search->getResultText('resource', array(count($results['results']), $results['total'], count($results['info']['counts']['nif'])), $results['expansion'], $vars); ?>
            </span>
        <!-- Begin Inner Results -->

        <?php
        //print_r($results);
        $uuids = array();
        $theViews = array();
        foreach ($results['results'] as $array) {
            $uuids[] = $array['uuid'];
            $theViews[] = $array['nif'];
            $source = $allSources[$array['nif']];

            $custom = new View();
            $custom->getByCommView($community->id,$array['nif']);

            echo '<div class="inner-results">';
            echo '<div class="the-title">';

            if($custom->id){
                $newVars = $vars;
                $newVars['view'] = $array['nif'];
                $newVars['uuid'] = $array['uuid'];
                echo ' <h3 style="display:inline-block"><a href="'.$search->generateURL($newVars).'">'.strip_tags($array['snippet']['title']).'</a></h3>';
            }else
                echo ' <h3 style="display:inline-block">' . $array['snippet']['title'] . '</h3>';


            echo '</div>';
            echo '<ul class="list-inline up-ul" style="margin:7px 0">';

            $newVars = $vars;
            $newVars['nif'] = $array['nif'];
            $splits = explode('|', $array['subcategory']);
            if (count($splits) > 1) {
                $newVars['category'] = $splits[0];
                $newVars['subcategory'] = $splits[1];
            } elseif ($array['subcategory'] != 'CURRENT')
                $newVars['subcategory'] = $array['subcategory'];
            echo '<li><a href="' . $search->generateURL($newVars) . '">' . $source->getTitle() . '</a>‎</li>';

            if($array['snippet']['citation'] && $array['snippet']['citation']!=''){
                echo '<li class="body-hide cite-this-div" style="position: relative;padding-left:10px"><a href="javascript:void(0)" class="cite-this-btn"><i class="fa fa-comment"></i> Cite This</a>';
                echo '<div class="hovering-cite-this body-hide no-propagation"><input type="text" class="form-control" style="background:#fff;cursor:text" readonly="readonly" value="'.$array['snippet']['citation'].'"/></div>';
            }

            echo '<li class="btn-group body-hide" uuid="' . $array['uuid'] . '" style="padding-left:10px;position: relative">';
            echo '<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">';
            echo 'Options<i class="fa fa-caret-down"></i>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul role="menu" class="dropdown-menu">';

            if (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 1)
                echo '<li><a class="snippet-edit" href="javascript:void(0)" cid="' . $community->id . '" view="' . $array['nif'] . '"><i class="fa fa-wrench"></i> Edit Source Snippet</a></li>';

            $newVars = $vars;
            $newVars['nif'] = $array['nif'];
            $splits = explode('|', $array['subcategory']);
            if (count($splits) > 1) {
                $newVars['category'] = $splits[0];
                $newVars['subcategory'] = $splits[1];
            } elseif ($array['subcategory'] != 'CURRENT')
                $newVars['subcategory'] = $array['subcategory'];
            echo '<li><a href="' . $search->generateURL($newVars) . '"><i class="fa fa-table"></i> View Source Table</a></li>';
            echo '<li><a href="/' . $community->portalName . '/about/sources/' . $array['nif'] . '" target="_blank"><i class="fa fa-info"></i> &nbsp;&nbsp;View Source Information</a></li>';


            echo '</ul>';


            echo '</li>';
            echo '<li class="coll-li body-hide">';
            if (isset($_SESSION['user'])) {
                $coll = new Item();
                $items = $coll->checkRecord($_SESSION['user']->id, $array['uuid']);
                if (count($items) > 0) {
                    echo '<i title="In a Collection" class="icon-custom icon-sm rounded-x icon-bg-green fa fa-folder-open-o collection-icon ' . $array['uuid'] . '-image" uuid="' . $array['uuid'] . '" style="cursor:pointer"></i>';
                } else {
                    echo '<i title="Not in a Collection" class="icon-custom icon-sm rounded-x icon-bg-gray fa fa-folder-open-o collection-icon ' . $array['uuid'] . '-image" uuid="' . $array['uuid'] . '" style="cursor:pointer"></i>';
                }
            } else {
                echo '<i title="Log In to Use Collections" class="icon-custom icon-sm rounded-x icon-bg-gray fa fa-folder-open-o btn-login" style="cursor:pointer"></i>';
            }
            $inColl = false;
            if (isset($_SESSION['user'])) {
                ?>
                <div class="collection-box no-propagation shadow-effect-1">
                    <div class="updating update-<?php echo $array['uuid'] ?>">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <div class="table-search-v2">
                        <div class="table-responsive">
                            <table class="table table-hover collection-tables" uuid="<?php echo $array['uuid'] ?>" style="margin:0">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Records</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($_SESSION['user']->collections as $id => $collection) {
                                    echo '<tr>';
                                    echo '<td><a href="/' . $community->portalName . '/account/collections/' . $collection->id . '">' . $collection->name . '</a></td>';
                                    echo '<td class="' . $id . '-count">' . number_format($collection->count) . '</td>';
                                    if ($items[$id]) {
                                        echo '<td><a href="javascript:void(0)" class="remove-item" collection="' . $collection->id . '" community="' . $community->id . '" view="' . $array['nif'] . '" uuid="' . $array['uuid'] . '"><i style="font-size: 16px;color:#bb0000" class="fa fa-times-circle"></i></a>';
                                        $inColl = true;
                                    } else {
                                        echo '<td><a href="javascript:void(0)" class="add-item" collection="' . $collection->id . '" community="' . $community->id . '" view="' . $array['nif'] . '" uuid="' . $array['uuid'] . '"><i style="font-size: 16px;color:#00bb00" class="fa fa-plus-circle"></i></a>';
                                    }
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                            <a class="ajax-new-collection btn-u" href="javascript:void(0)" style="width:100%;color:#fff;text-align: center" community="<?php echo $community->portalName ?>" cid="<?php echo $community->id ?>" view="<?php echo $array['nif'] ?>" uuid="<?php echo $array['uuid'] ?>">Create New Collection</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            echo '</li>';
            echo '</ul>';
            echo '<div class="overflow-h">';
            if (strlen($source->image) > 20)
                $imageSrc = $source->image;
            else $imageSrc = 'http://nif-dev-web.crbs.ucsd.edu/images/Neurolex_DB_IMAGES_WITH_ID/notfound.gif';
            echo '<a target="_blank" href="/' . $community->portalName . '/about/sources/' . $array['nif'] . '"><img src="' . $imageSrc . '" alt=""></a>';
            echo '<div class="overflow-a">';
            echo '<p>' . \helper\formattedDescription($array['snippet']['description']) . '</p>';
            echo '<ul class="list-inline down-ul">';
            $newVars = $vars;
            $splits = explode('|', $array['subcategory']);
            if (count($splits) > 1) {
                $newVars['category'] = $splits[0];
                $newVars['subcategory'] = $splits[1];
            } elseif ($search->category == 'Any')
                $newVars['category'] = $array['subcategory'];
            else
                $newVars['subcategory'] = $array['subcategory'];
            $splits = explode('|', $array['subcategory']);
            if ($array['subcategory'] != 'CURRENT') {
                if ($splits[1] == '')
                    echo '<li><a href="' . $search->generateURL($newVars) . '">' . $splits[0] . '</a></li>';
                else
                    echo '<li><a href="' . $search->generateURL($newVars) . '">' . join(':', $splits) . '</a></li>';
            } else echo '<li>From Current Category</li>';
            echo '</ul>';
            echo '</div></div></div>';
            echo '<hr/>';
        }
        ?>



        <div class="margin-bottom-30"></div>

        <div class="text-left">
            <?php
            //print_r($search);
            echo $search->paginateLong($vars) ?>
        </div>
    </div>
    <!--/col-md-10-->
    </div>
    </div>
    <div class="record-load back-hide"></div>
    <div class="snippet-load back-hide"></div>

<?php if (isset($_SESSION['user'])) { ?>
    <div class="new-collection back-hide no-padding">
        <div class="close dark less-right">X</div>
        <form method="post" id="name-form"
              action="/forms/collection-forms/create-collection.php" class="sky-form" enctype="multipart/form-data">
            <header>Create New Collection</header>
            <fieldset>
                <section>
                    <label class="label">Collection Name</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" name="name" placeholder="Focus to view the tooltip"
                               required>
                        <b class="tooltip tooltip-top-right">The name of your collection</b>
                    </label>
                </section>
                <section>
                    <label class="label">Transfer Records from Default Collection?</label>
                    <label class="select">
                        <i class="icon-append fa fa-question-circle"></i>
                        <select name="transfer">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <b class="tooltip tooltip-top-right">The name of your collection</b>
                    </label>
                </section>
            </fieldset>

            <footer>
                <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
            </footer>
        </form>
    </div>
    <div class="new-collection-ajax back-hide no-padding">
        <div class="close dark less-right">X</div>
        <form method="get" id="new-collection-ajax" class="sky-form" enctype="multipart/form-data">
            <header>Create New Collection</header>
            <fieldset>
                <section>
                    <label class="label">Collection Name</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" class="ajax-name" name="name" placeholder="Focus to view the tooltip"
                               required>
                        <b class="tooltip tooltip-top-right">The name of your collection</b>
                    </label>
                </section>
                <section>
                    <label class="label">Transfer Records from Default Collection?</label>
                    <label class="select">
                        <i class="icon-append fa fa-question-circle"></i>
                        <select class="ajax-transfer" name="transfer">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <b class="tooltip tooltip-top-right">The name of your collection</b>
                    </label>
                </section>
            </fieldset>

            <footer>
                <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
            </footer>
        </form>
    </div>
    <div class="add-all back-hide no-padding">
        <div class="close dark less-right">X</div>
        <form method="post" id="name-form"
              action="/forms/collection-forms/add-all-items.php"
              id="header-component-form" class="sky-form" enctype="multipart/form-data">
            <header>Add All Records on Page to a Collection</header>
            <input type="hidden" name="community" value="<?php echo $community->id ?>"/>
            <input type="hidden" name="items" value="<?php echo join(',', $uuids) ?>"/>
            <input type="hidden" name="views" value="<?php echo join(',', $theViews) ?>"/>
            <fieldset>
                <section>
                    <label class="label">Which Collection</label>
                    <label class="select">
                        <i class="icon-append fa fa-question-circle"></i>
                        <select name="collection">
                            <?php
                            foreach ($_SESSION['user']->collections as $id => $collection) {
                                echo '<option value="' . $id . '">' . $collection->name . '</option>';
                            }
                            ?>
                        </select>
                        <b class="tooltip tooltip-top-right">The name of your collection</b>
                    </label>
                </section>
            </fieldset>

            <footer>
                <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
            </footer>
        </form>
    </div>
    <!--/container-->
<?php } ?>
<ol id="joyRideTipContent">
    <li data-class="community-logo" data-text="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2><?php echo $community->name?> Resources</h2>
        <p>
            Welcome to the <?php echo $community->shortName?> Resources search. From here you can search through
            a compilation of resources used by <?php echo $community->shortName?> and see how data is organized within
            our community.
        </p>
    </li>
    <li data-class="resource-tab" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Navigation</h2>
        <p>
            You are currently on the Community Resources tab looking through categories and sources that <?php echo $community->shortName?>
            has compiled. You can navigate through those categories from here or change to a different tab to execute
            your search through. Each tab gives a different perspective on data.
        </p>
    </li>
    <li data-class="btn-login" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Logging in and Registering</h2>
        <p>
            If you have an account on SciCrunch (or previously NIF) then you can log in from here to get additional
            features in SciCrunch such as Collections, Saved Searches, and managing Resources.
        </p>
    </li>
    <li data-class="searchbar" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Searching</h2>
        <p>
            Here is the search term that is being executed, you can type in anything you want to search for. Some tips
            to help searching:
        </p>
        <ol>
            <li style="color:#fff">Use quotes around phrases you want to match exactly</li>
            <li style="color:#fff">You can manually AND and OR terms to change how we search between words</li>
            <li style="color:#fff">You can add "-" to terms to make sure no results return with that term in them (ex. Cerebellum -CA1)</li>
            <li style="color:#fff">You can add "+" to terms to require they be in the data</li>
            <li style="color:#fff">Using autocomplete specifies which branch of our semantics you with to search and can help refine your search</li>
        </ol>
    </li>
    <li data-class="tut-saved" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Save Your Search</h2>
        <p>
            You can save any searches you perform for quick access to later from here.
        </p>
    </li>
    <li data-class="tut-expansion" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Query Expansion</h2>
        <p>
            We recognized your search term and included synonyms and inferred terms along side your term to help get
            the data you are looking for.
        </p>
    </li>
    <li data-class="collection-icon" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Collections</h2>
        <p>
            If you are logged into SciCrunch you can add data records to your collections to create custom spreadsheets
            across multiple sources of data.
        </p>
    </li>
    <li data-class="tut-sources" data-button="Next" data-options="tipLocation:right;tipAnimation:fade">
        <h2>Sources</h2>
        <p>
            Here are the sources that were queried against in your search that you can investigate further.
        </p>
    </li>
    <li data-class="tut-categories" data-button="Next" data-options="tipLocation:right;tipAnimation:fade">
        <h2>Categories</h2>
        <p>
            Here are the categories present within <?php echo $community->shortName?> that you can filter your data on
        </p>
    </li>
    <li data-class="tut-subcategories" data-button="Next" data-options="tipLocation:right;tipAnimation:fade">
        <h2>Subcategories</h2>
        <p>
            Here are the subcategories present within this category that you can filter your data on
        </p>
    </li>
    <li data-class="tutorial-btn" data-button="Done" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Further Questions</h2>
        <p>
            If you have any further questions please check out our
            <a href="/<?php echo $community->portalName ?>/about/faq">FAQs Page</a> to ask questions and see our tutorials.
            Click this button to view this tutorial again.
        </p>
    </li>
</ol>
<div class="category-graph very-large-modal back-hide">
    <div class="close dark">X</div>
    <div id="main">
        <div id="sequence"></div>
        <div id="chart">
            <div id="explanation" style="visibility: hidden;">
                <span id="percentage"></span><br/>
                of results are within this section
            </div>
        </div>
    </div>
    <div id="sidebar">
        <h4>Category Graph</h4>
        <p>
            This is an overview of all the results for your given search. You will see each category, subcategory,
            and source present in this search and you can click on that section to be taken to just that portion.
        </p>
        <p>
            Please note that all sources are present and calculated in the chart, but if the result set has less than
            .001% of the total results returned it may not be visible. We recommend using the filters on the left of your
            results page to navigate to those result sets.
        </p>
    </div>
<!--    <div id="sidebar">-->
<!--        <input type="checkbox" id="togglelegend"> Legend<br/>-->
<!--        <div id="legend" style="visibility: hidden;"></div>-->
<!--    </div>-->
</div>
