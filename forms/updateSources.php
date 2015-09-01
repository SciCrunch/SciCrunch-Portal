<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../classes/classes.php';



set_time_limit(0);
$holder = new Sources();
$sources = $holder->getAllSources();


$dbImgThumbnailLocation = 'url_to_thumbnails';
$url = ENVIRONMENT . '/v1/federation/search.xml?q=*';
$xml = simplexml_load_file($url);

$done = array();

if ($xml) {
    foreach ($xml->result->results->result as $result) {
        if (!$done[(string)$result['nifId']]) {
            $vars = array();
            $vars['nif'] = (string)$result['nifId'];
            $vars['source'] = (string)$result['db'];
            $vars['view'] = (string)$result['indexable'];
            $vars['data'] = (int)$result->count;

            $update[] = $vars;
            $urls[] = 'concept_map_summary_service_endpoint' . $vars['nif'];
            $done[$vars['nif']] = true;
        }
    }

    $files = Connection::multi($urls);
    if (count($files) > 0) {
        foreach ($files as $i => $file) {
            $xml = simplexml_load_string($file);
            if ($xml) {
                foreach ($xml->views->view as $view) {
                    if ($view['nifId'] == $update[$i]['nif']) {
                        $descHolder = strip_tags((string)$view->description, '<a><img>');
                    }
                }
                $splits = end(explode("<a", $descHolder));
                $tutSplit = split('<img', $splits);
                $counts = explode("<a", $descHolder);
                $j = count($counts) - 1;
                if (count($tutSplit) == 1) {
                    $split2 = explode("<a", $descHolder);
                    $j = count($split2) - 2;
                    $splits = $split2[$j + 1];
                }
                $thisTut = "<a" . $splits;
                $newSplits = split('<a', $descHolder);
                $newDesc = $newSplits[0];
                for ($k = 1; $k < $j; $k++) {
                    $newDesc .= "<a" . $newSplits[$k];
                }
                $update[$i]['description'] = $newDesc;

                $dashSplit = explode('-', $update[$i]['nif']);
                $realId = join('-', array_slice($dashSplit, 0, count($dashSplit) - 1));

                if (fopen($dbImgThumbnailLocation . $realId . '.png', 'r')) { // if exists, append file extension, then rename the nifID to the whole nifID URL
                    $update[$i]['image'] = $dbImgThumbnailLocation . $realId . '.png';
                } else if (fopen($dbImgThumbnailLocation . $realId . '.PNG', 'r')) {
                    $update[$i]['image'] = $dbImgThumbnailLocation . $realId . '.PNG';
                } else if (fopen($dbImgThumbnailLocation . $realId . '.jpg', 'r')) {
                    $update[$i]['image'] = $dbImgThumbnailLocation . $realId . '.jpg';
                } else if (fopen($dbImgThumbnailLocation . $realId . '.gif', 'r')) {
                    $update[$i]['image'] = $dbImgThumbnailLocation . $realId . '.gif';
                } else {
                    $update[$i]['image'] = $realId;
                }
            }
        }
    }
    $html = '';
    foreach ($update as $row) {
        if ($sources[$row['nif']]) {
            $sources[$row['nif']]->updateData($row);
            $sources[$row['nif']]->updateDB();
        } else {
            $source = new Sources();
            $source->create($row);
            $source->insertDB();
        }
    }
}

header('location:/account/scicrunch/sources');
?>
