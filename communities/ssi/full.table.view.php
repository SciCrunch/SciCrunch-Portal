<style>
    body {
        background:#fff;
    }
</style>
<div class="full-screen-closed">
    <a href="javascript:void(0)" class="full-side-open" style="color:#fff;font-size: 26px;" title="Open Side Bar"><i
            class="fa fa-caret-square-o-right"></i></a>
</div>
<div class="full-screen-left">
    <?php
    $newVars = $vars;
    $newVars['fullscreen'] = null;
    ?>
    <a class="btn-u btn-u-purple" href="<?php echo $search->generateURL($newVars) ?>" style="margin-bottom: 15px"
       type="button">Exit Fullscreen
    </a>
    <a href="javascript:void(0)" class="pull-right full-side-close" title="Collapse Sidebar"
       style="color:#fff;font-size: 26px;"><i class="fa fa-caret-square-o-left"></i></a>
    <?php
    $urlArray = explode('?', $search->generateURL($vars));
    $formUrl = $urlArray[0];
    ?>
    <form method="get" action="<?php echo $url ?>">
        <div class="input-group" style="margin-bottom: 15px;">
            <input type="text" class="form-control" name="q" placeholder="Search words with regular expressions."
                   value="<?php if ($search->display) echo $search->display; else echo $search->query ?>">
                    <span class="input-group-btn">
                        <button class="btn-u" type="button"><i class="fa fa-search"></i></button>
                    </span>
            <input name="fullscreen" value="true" type="hidden"/>
        </div>
    </form>

    <hr style="margin:15px 0"/>

    <p><i class="fa fa-group"></i> <a href="/<?php echo $community->portalName ?>"><?php echo $community->name ?></a>
    </p>

    <p><i class="fa fa-database"></i> <?php echo $sources[$search->source]->getTitle ?></p>

    <p><i class="fa fa-empire"></i> <?php echo number_format($results['total']) ?> results</p>

    <p><i class="fa fa-file"></i>
        Results <?php echo number_format(($search->page - 1) * 50 + 1) . ' - ' . number_format(($search->page * 50)) ?>
    </p>

    <hr style="margin:15px 0"/>

    <select id="column-select">
        <option value="">-- Select Column to Scroll To --</option>
        <?php
        foreach ($results['table'][0] as $column => $value) {
            echo '<option value="'.rawurlencode($column).'">' . $column . '</option>';
        }
        ?>
    </select>

    <?php echo $search->paginate($vars); ?>

    <hr style="margin:15px 0"/>

    <?php

    if ($search->facet || $search->filter) {
        echo '<h4 style="color:#fff">Current Filters</h4>';
        //print_r($search);
        foreach ($search->filter as $filter) {
            $newVars = $vars;
            $newVars['filter'] = array_diff($search->filter, array($filter));
            echo '<p><a href="' . $search->generateURL($newVars) . '"><i class="fa fa-times-circle" style="color:#f2d9d9"></i></a> ' . $filter . '</p>';
        }
        foreach ($search->facet as $filter) {
            $newVars = $vars;
            $newVars['facet'] = array_diff($search->facet, array($filter));
            echo '<p><a href="' . $search->generateURL($newVars) . '"><i class="fa fa-times-circle" style="color:#f26666"></i></a> ' . $filter . '</p>';
        }
        echo '<hr style="margin:15px 0"/>';
    }

    ?>

    <div class="panel-heading" style="background:#d9d9f2">
        <h3 style="margin:0">Facets</h3>
    </div>
    <ul class="list-group sidebar-nav-v1" id="sidebar-nav" style="margin-bottom: 0">
        <?php
        foreach ($results['facets'] as $column => $array) {
            echo '<li class="list-group-item list-toggle">
                          <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-' . str_replace(' ', '_', $column) . '">' . $column . '</a>';
            echo '<ul id="collapse-' . str_replace(' ', '_', $column) . '" class="collapse">';
            foreach ($array as $facet) {
                $newVars = $vars;
                $newVars['facet'][] = $column . ':' . $facet['value'];
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $facet['value'] . ' (' . number_format($facet['count']) . ')</a></li>';
            }

            echo '</ul></li>';
        }
        ?>
    </ul>
</div>
<div class="fixed-header">
    <table class="table table-bordered"
           style="table-layout: fixed;margin-bottom:0;height:50px;width:<?php echo (200 * count($results['table'][0])) . 'px'; ?>">
        <tr>
            <?php
            foreach ($results['table'][0] as $column => $value) {
                echo '<th style="width:200px;padding:5px;background:#d9d9f2;border:1px solid #999" column="'.rawurlencode($column).'">' . $column . '</th>';
            }
            ?>
        </tr>
    </table>
</div>
<div class="full-screen-right">
    <table class="table table-bordered table-striped full-screen-inner"
           style="table-layout: fixed;overflow-y: scroll;width:<?php echo (200 * count($results['table'][0])) . 'px'; ?>">

        <tbody>
        <?php
        foreach ($results['table'] as $i => $row) {
            echo '<tr>';
            foreach ($row as $column => $value) {
                $final_value = $column == "Reference" ? \helper\checkLongURL($value) : $value;
                echo '<td style="width:200px; word-break: break-all;">' . $final_value . '</td>';
            }
            echo '</tr>';
        }
        ?>

        </tbody>
    </table>
</div>
