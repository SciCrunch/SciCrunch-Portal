<?php
$holder = new Extended_Data();
$files = $holder->getByData($data->id, true);
?>
<style>
    .table-search-v1 td a {
        color: #ffffff;
    }
</style>


<div class="container content">
<div class="row margin-bottom-20">
    <div class="heading heading-v1 margin-bottom-40">
        <h2><?php echo $data->title ?></h2>

        <p><?php echo $data->description ?></p>
    </div>
</div>
<div class="row blog-page blog-item">
    <!-- Left Sidebar -->
    <div class="col-md-6 md-margin-bottom-60">
        <div class="table-search-v1 panel panel-grey margin-bottom-50">
            <div class="panel-heading">
                <h3 class="panel-title pull-left"><i class="fa fa-globe"></i> Data Files</h3>

                <div class="pull-right">
                    <div class="btn-group navbar-right">
                        <button data-toggle="dropdown"
                                class="btn-u btn-u-default btn-u-split-default dropdown-toggle" type="button">
                            <i class="fa fa-cog"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-cloud-download"></i> Download All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th class="hidden-sm">Description</th>
                        <th>Date Added</th>
                        <th>Download</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($files['File']) > 0) {
                        foreach ($files['File'] as $file) {
                            echo '<tr>';
                            echo '<td>' . $file->name . '</td>';
                            echo '<td>' . $file->description . '</td>';
                            echo '<td>' . date('h:ia F j, Y', $file->time) . '</td>';
                            echo '<td>';
                            echo '<a href="/php/file-download.php?type=extended&id=' . $file->id . '" class="btn-u">Download</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td>No Data Files</td><td></td><td></td><td></td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 md-margin-bottom-60">
        <div class="table-search-v1 panel panel-grey margin-bottom-50">
            <div class="panel-heading">
                <h3 class="panel-title pull-left"><i class="fa fa-globe"></i> Document Files</h3>

                <div class="pull-right">
                    <div class="btn-group navbar-right">
                        <button data-toggle="dropdown"
                                class="btn-u btn-u-default btn-u-split-default dropdown-toggle" type="button">
                            <i class="fa fa-cog"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-cloud-download"></i> Download All</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th class="hidden-sm">Description</th>
                        <th>Date Added</th>
                        <th>Download</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($files['Document']) > 0) {
                        foreach ($files['Document'] as $file) {
                            echo '<tr>';
                            echo '<td>' . $file->name . '</td>';
                            echo '<td>' . $file->description . '</td>';
                            echo '<td>' . date('h:ia F j, Y', $file->time) . '</td>';
                            echo '<td>';
                            echo '<a href="/php/file-download.php?type=extended&id=' . $file->id . '" class="btn-u">Download</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td>No Document Files</td><td></td><td></td><td></td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if ($data->color) {
    $newVars = $vars;
    $newVars['category'] = 'data';
    $newVars['nif'] = $data->color;

    $search->create($newVars);
    $results = $search->doSearch();

    ?>
<hr/>
    <div class="row">

        <!--/col-md-2-->

        <div class="col-md-2">

            <?php echo $search->currentSpecialFacets($vars,'/'.$community->portalName.'/about/'.$thisComp->text2.'/'.$data->id) ?>
            <?php 
                // Delete or otherwise suppress “Facets” from the dataset pages. #194
				if (isset($results['facets'])): ?>
				<h3>Facets</h3>
				<ul class="list-group sidebar-nav-v1" id="sidebar-nav">
					<?php
					foreach ($results['facets'] as $column => $array) {
						echo '<li class="list-group-item list-toggle" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-' . str_replace(' ', '_', $column) . '">
							  <a href="javascript:void(0)">' . $column . '</a>';
						echo '<ul id="collapse-' . str_replace(' ', '_', $column) . '" class="collapse">';
						foreach ($array as $facet) {
							$newVars = $vars;
							$newVars['facet'][] = $column.':'.$facet['value'];
							echo '<li><a href="' . $search->generateSpecialURL($newVars,'/'.$community->portalName.'/about/'.$thisComp->text2.'/'.$data->id) . '">' . $facet['value'] . ' (' . number_format($facet['count']) . ')</a></li>';
						}

						echo '</ul></li>';
					}
					?>
				</ul>
				<hr style="margin-top:10px;margin-bottom:15px;"/>
			<?php endif; ?>            
        </div>
        <div class="col-md-10">
            <div class=" panel panel-grey margin-bottom-50">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left"><i
                            class="fa fa-globe"></i> <?php echo number_format($results['total']) ?> Results</h3>

                    <div class="pull-right">
                        <div class="btn-group navbar-right">
                            <button data-toggle="dropdown"
                                    class="btn-u btn-u-default btn-u-split-default dropdown-toggle"
                                    type="button">
                                <i class="fa fa-cog"></i>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="<?php echo $results['export'] ?>"><i class="fa fa-cloud-download"></i>
                                        Download
                                        All</a></li>
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
                            foreach ($row as $column => $value) {
                                echo '<td>' . $value . '</td>';
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
<?php } ?>
</div>
