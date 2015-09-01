<?php

$holder = new Category();
$return = $holder->getUsed();
$communities = array();
$sources2 = array();
$colors = array();
$who = array();
foreach ($return as $cat) {
    if (!$communities[$cat->cid]) {
        $comm = new Community();
        $comm->getByID($cat->cid);
        $communities[$cat->cid] = $comm;
    }
    if ($communities[$cat->cid]->private == 1)
        continue;
    if (!isset($sources2[$cat->source]) || !in_array($cat->cid, $sources2[$cat->source])) {
        $sources2[$cat->source][] = $cat->cid;
        $colors[$cat->source][] = $communities[$cat->cid]->communityColor();
        $who[$cat->source][] = $communities[$cat->cid];
    }
}

$snippet = new Snippet();
$snippet->getSnippetByView($community->id, $vars['id']);

$splits = explode('-', $vars['id']);
$rootID = join('-', array_slice($splits, 0, count($splits) - 1));

$url = 'nif_services_federation_data_service_endpoint' . $rootID;
$xml = simplexml_load_file($url);
if ($xml) {
    foreach ($xml->result->results->row->data as $data) {
        $record[(string)$data->name] = (string)$data->value;
    }
}

$url = 'concept_map_summary_service_endpoint' . $vars['id'];
$xml = simplexml_load_file($url);
if ($xml) {
    $data['license'] = (string)$xml->license;
    $data['license-url'] = (string)$xml->{'license-url'};
    foreach ($xml->views->view as $view) {
        if ((string)$view['isView'] != 'true' || (string)$view['indexed']=='false' || !$sources[(string)$view['nifId']])
            continue;
        $views[] = $sources[(string)$view['nifId']];
    }
}

$source = $sources[$vars['id']];

?>

<div class="container">
    <h1 style="margin: 40px 0"><?php echo $record['Resource Name'] ?></h1>

    <div class="tab-v5">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#description" role="tab" data-toggle="tab">Description</a></li>
            <li><a href="#views" role="tab" data-toggle="tab">Views</a></li>
            <li><a href="#licenses" role="tab" data-toggle="tab">License</a></li>
        </ul>

        <div class="tab-content">
            <!-- Description -->
            <div class="tab-pane fade in active" id="description">
                <div class="row">
                    <div class="col-md-7">
                        <p><?php echo \helper\formattedDescription($record['Description']) ?></p><br>

                        <h3 class="heading-md margin-bottom-20">Details</h3>

                        <div class="row">

                            <?php
                            $count = 0;
                            foreach ($record as $key => $value) {
                                if ($key == 'Resource Name' || $key == 'Description')
                                    continue;
                                if ($count < 5)
                                    $left[$key] = $value;
                                else
                                    $right[$key] = $value;
                                $count++;
                            }
                            ?>
                            <div class="col-sm-6">
                                <ul class="list-unstyled specifies-list">
                                    <?php foreach ($left as $key => $value) {
                                        echo '<li style="margin-left:15px;text-indent:-15px;margin-bottom:5px;"><i class="fa fa-caret-right"></i> <b><u>' . $key . ':</u></b> <span>' . $value . '</span></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled specifies-list">
                                    <?php foreach ($right as $key => $value) {
                                        echo '<li style="margin-left:15px;text-indent:-15px;margin-bottom:5px;"><i class="fa fa-caret-right"></i> <b><u>' . $key . ':</u></b> <span>' . $value . '</span></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="responsive-image" style="text-align: center">
                            <img src="<?php echo $source->image ?>" class="responsive-image"/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Description -->

            <!-- Reviews -->
            <div class="tab-pane fade" id="licenses">
                <div style="margin-bottom: 10px;"><b>License URL: </b> <a
                        href="<?php echo $data['license-url'] ?>"><?php echo $data['license-url'] ?></a></div>
                <div style="margin-bottom: 10px;margin-left: 15px;text-indent: -15px"><b>License
                        Information: </b><br/><?php echo $data['license'] ?></div>
            </div>
            <div class="tab-pane fade" id="views">
                <?php
                foreach ($views as $i => $view) {

                    if ($i % 3 == 0)
                        echo '<div class="row">';
                    ?>
                    <div class="col-sm-4 ">
                        <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                            <div class="grid-boxes-caption ">
                                <div class="the-title">
                                    <h3 style="display: inline-block">
                                        <?php echo $view->getTitle() ?>
                                    </h3>
                                    <?php
                                    if (count($colors[$view->nif]) > 0) {
                                        echo '<div class="circle-container body-hide"><div class="circle" style="display:inline-block;margin-left:10px;vertical-align:middle" id="circle-' . $view->nif . '" num="' . count($colors[$view->nif]) . '" colors="' . join(',', $colors[$view->nif]) . '"></div>';
                                        echo '<div class="who-container no-propagation shadow-effect-1"><h3 align="center" style="margin:0;text-decoration: underline">Used in</h3>';
                                        foreach ($colors[$view->nif] as $j => $color) {
                                            if ($who[$view->nif][$j]->id == $community->id)
                                                echo '<div><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view->nif][$j]->name . '</div>';
                                            else
                                                echo '<div><a target="_blank" href="/' . $who[$view->nif][$j]->portalName . '"><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view->nif][$j]->name . '</a></div>';
                                        }
                                        echo '</div></div>';
                                    }
                                    ?>
                                </div>

                                <p><?php echo $view->description ?></p>

                                <ul class="list-unstyled specifies-list" style="margin-top:10px">
                                    <li style="margin-bottom:10px">
                                        <i class="fa fa-caret-right"></i> <b><u>Records:</u></b> <a href="/<?php echo $community->portalName?>/data/source/<?php echo $view->nif?>/search"><?php echo number_format($view->data) ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i % 3 == 2)
                        echo '</div>';
                }
                if ($i % 3 != 2)
                    echo '</div>';
                ?>

            </div>
            <!-- End Reviews -->
        </div>
    </div>
</div>
