<?php
foreach ($fields as $field) {
    if ($field->display == 'title')
        $title = $field->name;
    elseif ($field->display == 'description')
        $description = $field->name;
    elseif ($field->display == 'url')
        $url = $field->name;
    else
        $bottom[] = $field;
}

$unused = array();
foreach ($bottom as $field) {
    if ($columns[$field->name] == '' || $columns[$field->name] == null) {
        $unused[] = $field->name;
        continue;
    }
    switch ($field->display) {
        case "text":
            $single[] = $field;
            break;
        case "resource":
            $single[] = $field;
            break;
        case "textarea":
            $double[] = $field;
            break;
        case "map-text":
            $double[] = $field;
            break;
        case "literature-text":
            $literature[] = $field;
            break;
    }
}
//if (count($unused) > 0) {
//    $field = new Resource_Fields();
//    $field->display = 'unused';
//    $field->name = "Unspecified Fields";
//    $single[] = $field;
//}

if (count($double) > 0) {
    if (count($single) > 6 && count($double) == 1) {
        $tiles['tiles'][0][0][] = $single[0];
        $tiles['tiles'][1][0][] = $single[1];
        $tiles['tiles'][1][0][] = $single[2];
        $tiles['tiles'][2][0][] = $single[3];
        $tiles['tiles'][1][1][] = $double[0];
        for ($i = 4; $i < count($single); $i++) {
            if ($i > 9) {
                if (($i-2) % 4 == 0)
                    $tiles['tiles'][0][floor($i / 2) - 1][] = $single[$i];
                elseif(($i-2)%4==1 || ($i-2)%4==2)
                    $tiles['tiles'][1][floor(($i-1) / 2) - 1][] = $single[$i];
                else
                    $tiles['tiles'][2][floor(($i-1) / 2) - 1][] = $single[$i];
            } else {
                if ($i % 2 == 0)
                    $tiles['tiles'][0][floor($i / 2) - 1][] = $single[$i];
                else
                    $tiles['tiles'][2][floor($i / 2) - 1][] = $single[$i];
            }
        }
    } else {
        for ($i = 0; $i < count($single); $i++) {
            $tiles['tiles'][0][floor($i / 2)][] = $single[$i];
        }
        for ($i = 0; $i < count($double); $i++) {
            $tiles['tiles'][1][$i][] = $double[$i];
        }
    }
} else {
    for ($i = 0; $i < count($single); $i++) {
        $tiles['tiles'][$i % 4][floor($i / 4)][] = $single[$i];
    }
}

$pmids = array();
foreach($literature as $section){
    if($section->display == 'literature-text'){
        if(strip_tags($columns[$section->name])!='')
            $pmids = array_merge($pmids, explode(',',str_replace(' ','',str_replace('PMID: ','',strip_tags($columns[$section->name])))));
    }
}

?>
<style>
    .tab-pane {
        background: #f8f8f8;
        padding: 15px 15px;
        border-bottom: 1px solid #dedede;
    }

    .tab-v5 {
        margin-top: 30px;
    }

    .tab-v5 .tab-content {
        margin: 0;
        padding: 0;
    }

    .tag-box {
        margin-bottom: 20px;
    }

    .map {
        width: 100%;
        height: 350px;
        border-top: solid 1px #eee;
        border-bottom: solid 1px #eee;
    }
</style>
<h1><a href="<?php echo $columns[$url] ?>"><?php echo $columns[$title] ?></a></h1>

<p class="truncate-desc">
    <?php echo $columns[$description] ?>
</p>
<p><b>URL:</b> <?php echo $columns[$url] ?></p>

<p style="margin-top: 15px;margin-bottom: 4px">
    <b>Resource
        ID:</b> <?php echo $resource->original_id ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>Resource Type:</b> <?php echo $resource->type ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if ($vars['article'] == $resource->version)
        echo '<b>Version:</b> Production Version';
    elseif ($vars['article'])
        echo '<b>Version:</b> ' . $vars['article'];
    else
        echo '<b>Version:</b> Latest Version';
    ?>
</p>

<div class="tab-v5">
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#description" role="tab" data-toggle="tab">Fields</a></li>
    <?php if($pmids){?>
        <li><a href="#literature" role="tab" data-toggle="tab">References</a></li>
    <?php } ?>
    <li><a href="#meta" role="tab" data-toggle="tab">Meta Info</a></li>
    <li><a href="#version" role="tab" data-toggle="tab">Versions</a></li>
    <?php if ($vars['article'])
        $url = $baseURL . $resource->rid . '/' . $vars['article'] . '/edit';
    else
        $url = $baseURL . $resource->rid . '/edit';
    ?>
    <?php if($can_edit_resource) { ?><li class="pull-right"><a class="btn-u" href="<?php echo $url ?>"><i class="fa fa-pencil"></i> Edit</a></li><?php } ?>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']->role > 0) { ?>
        <li class="pull-right">
            <a class="btn-u"
               href="/forms/resource-forms/update-version.php?rid=<?php echo $resource->rid ?>&version=<?php echo $version ?>&status=Curated">
                <i class="fa fa-star" style="color:#f7e741"></i> Mark Current</a>
        </li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div class="tab-pane fade in active" id="description">
        <div class="row">
            <?php
            foreach ($tiles['tiles'] as $x => $rows) {
                if (count($tiles['tiles']) == 4 || (count($tiles['tiles']) == 3 && $x != 1)) {
                    echo '<div class="col-md-3">';
                } elseif (count($tiles['tiles']) == 3 && $x == 1) {
                    echo '<div class="col-md-6">';
                } else
                    echo '<div class="col-md-6">';
                foreach ($rows as $y => $sections) {
                    echo '<div class="row">';
                    foreach ($sections as $section) {
                        if (($section->display == 'text' || $section->display == 'resource' || $section->display == 'unused') && count($sections) > 1) {
                            echo '<div class="col-md-6">';
                        } else {
                            echo '<div class="col-md-12">';
                        }
                        echo '<div class="tag-box tag-box-v2 box-shadow shadow-effect-1">';
                        echo '<h2>' . $section->name . '</h2>';
                        if ($section->display == 'unused') {
                            echo '<ul>';
                            foreach ($unused as $un) {
                                echo '<li>' . $un . '</li>';
                            }
                            echo '</ul>';
                        } elseif ($section->display == 'text') {
                            echo '<p>' . $columns[$section->name] . '</p>';
                        } elseif ($section->display == 'resource') {
                            if ($columns[$section->name] == '' || $columns[$section->name] == null)
                                echo '<p>&nbsp;</p>';
                            else
                                echo '<p>' . $columns[$section->name] . '</p>';
                        } elseif ($section->display == 'map-text') {
                            $url2 = 'https://maps.google.com/maps/api/geocode/xml?address=' . $columns[$section->name] . '&sensor=false';
                            $xml2 = simplexml_load_file($url2);
                            if ($xml2) {
                                $lat = $xml2->result->geometry->location->lat;
                                $lng = $xml2->result->geometry->location->lng;
                                echo '<div id="' . str_replace(' ', '_', $section->name) . '" class="map" lat="' . $lat . '" lng="' . $lng . '" point="' . $columns[$section->name] . '"></div>';
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
            <!-- Description -->

        </div>
    </div>

    <div class="tab-pane fade" id="meta">
        <div class="row">
            <div class="col-md-3">
                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                    <h2>Original Submitter</h2>
                    <?php

                    $userList = array();
                    $user = new User();
                    if ($resource->uid == 0) {
                        $user->firstname = 'Anonymous';
                    } else
                        $user->getByID($resource->uid);
                    $userList[$resource->uid] = $user;
                    echo $user->getFullName();
                    ?>

                </div>
                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                    <h2>Version Status</h2>
                    <?php
                    $ver = $resource->getVersionInfo($version);
                    echo $ver['status'];
                    ?>

                </div>
            </div>
            <div class="col-md-3">
                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                    <h2>Submitted On</h2>
                    <?php
                    echo date('h:ia F j, Y', $resource->insert_time);
                    ?>

                </div>
                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                    <h2>Originated From</h2>
                    <?php
                    if ($ver['cid'] != 0) {
                        $comm = new Community();
                        $community->getByID($ver['cid']);
                        echo '<a href="/' . $community->portalName . '">' . $community->name . '</a>';
                    } else {
                        echo 'SciCrunch';
                    }
                    ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                    <h2>Changes from Previous Version</h2>
                    <?php
                    if ($version == 1) {
                        echo 'First Version';
                    } else {
                        $prev = new Resource();
                        $prev->getByRID($resource->rid);
                        $prev->getVersionColumns($version - 1);
                        $changed = false;
                        echo '<ul>';
                        foreach ($resource->columns as $name => $value) {
                            if ($prev->columns[$name] != $value) {
                                echo '<li><b>' . $name . '</b> was changed</li>';
                                $changed = true;
                            }
                        }
                        echo '</ul>';
                        if (!$changed) {
                            echo '<p>No Changes</p>';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="version">
        <?php
        $versions = $resource->getVersions();
        $userList = array();
        foreach ($versions as $i => $version) {
            if (!$userList[$version['uid']]) {
                $user = new User();
                if ($version['uid'] == 0) {
                    $user->firstname = 'Anonymous';
                } else
                    $user->getByID($version['uid']);
                $userList[$version['uid']] = $user;
            } else
                $user = $userList[$version['uid']];
            if ($i % 4 == 0)
                echo '<div class="row">';
            echo '<div class="col-md-3">';
            echo '<div class="tag-box tag-box-v2 box-shadow shadow-effect-1">';
            echo '<h2><a href="' . $baseURL . $resource->rid . '/' . $version['version'] . '">Version ' . $version['version'] . '</a>';
            if ($version['version'] == $resource->version)
                echo ' <i class="fa fa-star" style="color:#f7e741" title="Current Version"></i>';
            echo '</h2>';
            echo '<p>Created ' . Connection::longTimeDifference($version['time']) . ' by ' . $user->getFullName() . '</p>';
            echo '</div></div>';
            if ($i % 4 == 3) {
                echo '</div>';
            }
        }
        if ($i % 4 != 3)
            echo '</div>';
        ?>
    </div>

    <?php
    if (count($pmids)) {
        echo '<div class="tab-pane fade" id="literature">';
        $url3 = 'nif_services_literature_service_endpoint' . join('&pmid=', $pmids);
        $xml3 = simplexml_load_file($url3);
        $months = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        if ($xml3) {
            foreach ($xml3->publication as $paper) {
                echo '<div class="row">';
                echo '<div class="col-md-12">';
                echo '<div class="tag-box tag-box-v2 box-shadow shadow-effect-1">';
                echo '<h2><a href="http://www.ncbi.nlm.nih.gov/pubmed/' . $paper['pmid'] . '">' . $paper->title . '</a></h2>';
                echo '<ul class="list-inline up-ul">';
                echo '<li>' . $paper->authors->author . '</li>';
                echo '<li>' . $paper->journalShort . '</li>';
                echo '<li>' . $paper->year . ' ' . $months[$paper->month] . ' ' . $paper->day . '</li>';
                echo '</ul>';
                echo '<p class="truncate-desc">' . $paper->abstract . '</p>';
                echo '<ul class="list-inline up-ul" style="margin-top:7px">';
                echo '<li><a href="http://www.ncbi.nlm.nih.gov/pubmed/' . $paper['pmid'] . '">PMID:' . $paper['pmid'] . '</a></li>';
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
    }
    ?>
</div>
</div>

