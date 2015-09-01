<div class="container margin-bottom-50">
    <div class="row">

        <!--/col-md-2-->

        <div class="col-md-2">

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
        <div class="col-md-10">
            <div class=" panel panel-grey margin-bottom-50">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left"><i
                            class="fa fa-globe"></i> <?php echo $search->getResultText('table', array($results['total']), $results['expansion'], $vars) ?>
                    </h3>

                    <div class="pull-right">
                        <div class="btn-group navbar-right">
                            <button data-toggle="dropdown"
                                    class="btn-u btn-u-default btn-u-split-default dropdown-toggle"
                                    type="button">
                                <i class="fa fa-cog"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <?php
                                $newVars = $vars;
                                $newVars['fullscreen'] = 'true';
                                ?>
                                <li><a href="javascript:void(0)" class="showMoreColumns"><i class="fa fa-plus"></i>
                                        Show More Columns</a></li>
                                <li><a href="<?php echo $search->generateURL($newVars) ?>"><i
                                            class="fa fa-arrows-alt"></i> Fullscreen</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $results['export'] . "&exportType=data&count=1000" ?>"><i class="fa fa-cloud-download"></i>
                                        Download 1000 results</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <?php
                            $count = 0;
                            foreach ($results['table'][0] as $column => $value) {
                                if ($count > 6)
                                    echo '<th style="position:relative" class="search-header hidden-column showing"><a href="javascript:void(0)">' . $column . '<a>';
                                else
                                    echo '<th style="position:relative" class="search-header"><a href="javascript:void(0)">' . $column . '<a>';
                                if ($count > count($results['table'][0]) - 3)
                                    echo '<div class="column-search" style="left:auto;right:-1px;">';
                                else
                                    echo '<div class="column-search invis-hide">';
                                echo '<form method="get" class="column-search-form" column="' . rawurlencode($column) . '">';
                                echo '<div class="input-group">
                                        <input type="text" class="form-control" name="value" placeholder="Search Column" value="" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn-u search-filter-btn" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>';
                                echo '</form>';
                                echo '<hr style="margin:0"/>';
                                $newVars = $vars;
                                $newVars['column'] = $column;
                                $newVars['sort'] = 'asc';
                                echo '<p><a class="sortin-column" href="' . $search->generateURL($newVars) . '"><i class="fa fa-sort-amount-asc"></i> Sort Ascending</a></p>';

                                $newVars['sort'] = 'desc';
                                echo '<p><a class="sortin-column" href="' . $search->generateURL($newVars) . '"><i class="fa fa-sort-amount-desc"></i> Sort Descending</a></p>';
                                echo '</div>';
                                echo '</th>';
                                $count++;
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($results['table'] as $i => $row) {
                            echo '<tr>';
                            $count = 0;
                            foreach ($row as $column => $value) {
                                $fmt_value = $column == "Description" ? \helper\formattedDescription($value) : $value;
                                $fmt_value = $column == "Reference" ? \helper\checkLongURL($value) : $value;
                                if ($count > 6)
                                    echo '<td class="hidden-column">' . $fmt_value . '</td>';
                                else
                                    echo '<td>' . $fmt_value . '</td>';
                                $count++;
                            }
                            echo '</tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo $search->paginateLong($vars) ?>
        </div>
    </div>
</div>
<div class="category-graph very-large-modal back-hide">
    <div class="close dark">X</div>
    <div id="main">
        <div id="sequence"></div>
        <div id="chart">
            <div id="explanation" style="visibility: hidden;">
                <span id="percentage"></span><br/>
                of results have this facet
            </div>
        </div>
    </div>
    <div id="sidebar">
        <h4>Facet Graph</h4>

        <p>
            This is an overview of all the faceted data within your result set. You can click on the lowest level to
            apply the facet to your search.
        </p>

        <p>
            Please note that all facets are present and calculated in the chart, but if the result set has less than
            .001% of the total results returned it may not be visible.
        </p>
    </div>
    <!--    <div id="sidebar">-->
    <!--        <input type="checkbox" id="togglelegend"> Legend<br/>-->
    <!--        <div id="legend" style="visibility: hidden;"></div>-->
    <!--    </div>-->
</div>
