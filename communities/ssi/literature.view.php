<div class="container s-results margin-bottom-50">
    <div class="row">
        <div class="col-md-2 hidden-xs related-search">
            <div class="row">
                <div class="col-md-12 col-sm-4">
                    <?php echo $search->currentFacets($vars,'literature')?>
                    <h3 class="tut-options">Options</h3>
                    <ul class="list-unstyled">
                        <li><a href="javascript:lineGraph(<?php echo "'". str_replace("%27","\%27",str_replace('"','%22',json_encode($results['json'])))."'" ?>)"><i class="fa fa-bar-chart-o"></i> Year Chart</a></li>
                        <li><a href="<?php echo $results['export'] ?>"><i class="fa fa-cloud-download"></i> RIS Download</a></li>
                    </ul>
                    <hr/>
                </div>
                <?php
                echo '<div class="col-md-12 col-sm-4">';
                echo '<h3 class="tut-facets">Facets</h3>';
                echo '<ul class="list-group sidebar-nav-v1" id="sidebar-nav">';
                echo '<li class="list-group-item list-toggle" href="#collapse-option" data-toggle="collapse">';
                echo '<a href="javascript:void(0)" class="accordion-toggle" >Options</a>';
                echo '<ul id="collapse-option" class="collapse">';
                $newVars = $vars;
                $newVars['facet'][] = 'Search:true';
                echo '<li class="active"><a href="' . $search->generateURL($newVars) . '">Include Full Text</a></li>';
                $newVars = $vars;
                $newVars['facet'][] = 'Require:true';
                echo '<li class="active"><a href="' . $search->generateURL($newVars) . '">Require Full Text</a></li>';
                echo '</ul></li>';

                function filterSortDesc($a,$b){
                    if($a['text']==$b['text'])
                        return 0;
                    return ($a['text'] < $b['text']) ? 1 : -1;
                }

                function filterSortAsc($a,$b){
                    if($a['text']==$b['text'])
                        return 0;
                    return ($a['text'] < $b['text']) ? -1 : 1;
                }

                foreach ($results['facets'] as $type => $array) {
                    echo '<li class="list-group-item list-toggle" href="#collapse-'.str_replace(' ','_',$type).'" data-toggle="collapse">';
                    echo '<a class="accordion-toggle" href="javascript:void(0)">'.$type.'</a>';
                    echo '<ul id="collapse-'.str_replace(' ','_',$type).'" class="collapse">';
                    if($type=='Year')
                        usort($array,'filterSortDesc');
                    elseif($type=='Author'||$type=='Journal')
                        usort($array,'filterSortAsc');
                    foreach ($array as $facet) {
                        $newVars = $vars;
                        if($type!='Section'){
                            $newVars['facet'][] = $type.':'.$facet['text'];
                            echo '<li><a href="' . $search->generateURL($newVars) . '">' . $facet['text'] . ' (' . number_format($facet['count']) . ')</a></li>';
                        } else {
                            $newVars['facet'][] = $type.':'.$facet;
                            echo '<li><a href="' . $search->generateURL($newVars) . '">' . $facet . '</a></li>';
                        }
                    }
                    echo '</ul></li>';
                }
                echo '</ul></div><hr/>';
                ?>
            </div>
        </div>
        <!--/col-md-2-->

        <div class="col-md-10">
            <span
                class="results-number">
            <?php echo $search->getResultText('literature',array($results['total']),$results['expansion'],$vars);?>
            </span>
            <!-- Begin Inner Results -->

            <?php
            $months = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
            foreach ($results['papers'] as $paper) {
                echo '<div class="inner-results">';
                echo '<a target="_blank" href="http://www.ncbi.nlm.nih.gov/pubmed/'.$paper['pmid'].'"><h3>' . $paper['title'] . '</h3></a>';
                echo '<ul class="list-inline up-ul">';
                echo '<li>' . $paper['firstAuthor'] . '‎</li>';
                echo '<li>' . $paper['journalShort'] . '‎</li>';
                echo '<li>' . $paper['date']['year'] . ' '.$months[$paper['date']['month']].' '.$paper['date']['day'].'‎</li>';
                echo '</ul>';
                echo '<div class="overflow-h">';
                echo '<div style="float:left" title="Altmetric Information" class="altmetric-embed ocrc" data-hide-no-mentions="true"
                     data-badge-popover="right" data-badge-type="donut"
                     data-pmid="'.$paper['pmid'].'"></div>';
                echo '<div class="overflow-a">';
                echo '<p>' . $paper['abstract'] . '</p>';
                echo '<ul class="list-inline down-ul">';
                $newVars = $vars;
                $newVars['parent'] = $array['parent'];
                $newVars['child'] = $array['child'];
                echo '<li><a target="_blank" href="http://www.ncbi.nlm.nih.gov/pubmed/'.$paper['pmid'].'">PMID:' . $paper['pmid'] . '</a></li>';
                echo '</ul>';
                echo '</div></div></div>';
                echo '<hr/>';
            }
            ?>



            <div class="margin-bottom-30"></div>

            <div class="text-left">
                <?php echo $search->paginateLong($vars)?>
            </div>
        </div>
        <!--/col-md-10-->
    </div>
</div><!--/container-->
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
    <li data-class="tut-facets" data-button="Next" data-options="tipLocation:right;tipAnimation:fade">
        <h2>Facets</h2>
        <p>
            Here are the facets that you can filter your papers by.
        </p>
    </li>
    <li data-class="tut-options" data-button="Next" data-options="tipLocation:right;tipAnimation:fade">
        <h2>Options</h2>
        <p>
            From here we'll present any options for the literature, such as exporting your current results.
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
    <h1 style="text-align: center">Publications Per Year</h1>
    <div class="close dark">X</div>
    <div class="hover-text">
        <p style="padding:0;margin:0;margin-bottom:5px"><b>Year</b>: <span class="graph-year"></span></p>
        <p style="padding:0;margin:0"><b>Count</b>: <span class="graph-count"></span></p>
    </div>
    <div class="chart">

    </div>
    <!--    <div id="sidebar">-->
    <!--        <input type="checkbox" id="togglelegend"> Legend<br/>-->
    <!--        <div id="legend" style="visibility: hidden;"></div>-->
    <!--    </div>-->
</div>