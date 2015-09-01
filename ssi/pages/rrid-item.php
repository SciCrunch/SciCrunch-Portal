<?php
$holder = new Sources();
$allSources = $holder->getAllSources();
$search = new Search();

$query = trim(str_replace('RRID:', '', $id));


$urls = array(
    ENVIRONMENT . '/v1/federation/data/nif-0000-07730-1.xml?q=*&count=1&&filter=Antibody%20ID:' . $query,
    ENVIRONMENT . '/v1/federation/data/nlx_144509-1.xml?q=*&count=1&filter=see_full_record:' . $query,
    ENVIRONMENT . '/v1/federation/data/nlx_154697-1.xml?q=*&count=1&filter=proper_citation:"RRID:' . $query . '"'
);

$nifs = array('nif-0000-07730-1', 'nlx_144509-1', 'nlx_154697-1');
$types = array('Antibody', 'Resource', 'Animal');

$orderArray = array();
$count = 0;
$newURLs = array();
foreach ($urls as $i => $url) {
    $string = $search->checkLocalStore($url);
    if ($string) {
        $theFiles[$i] = $string;
    } else {
        $orderArray[$count] = $i;
        $newURLs[$count] = $url;
        $count++;
    }
}

//print_r($urls);

if (count($newURLs) > 0) {
    $files = Connection::multi($newURLs);

    foreach ($files as $i => $file) {
        $search->insertIntoLocalStore($newURLs[$i], $file);
        $theFiles[$orderArray[$i]] = $file;
    }
}

$total = 0;
$theMax = 0;
foreach ($theFiles as $i => $file) {
    $count = 0;
    $xml = simplexml_load_string($file);
    if ($xml) {
        foreach ($xml->result->results->row->data as $data) {
            $record[(string)$data->name] = (string)$data->value;
        }
        if ((int)$xml->result['resultCount'] > 0) {
            $total = $i;
            break;
        }
    }
}

if ($total == 0) {
    $title = $record['Antibody Name'];
} elseif ($total == 1) {
    $title = $record['Resource Name'];
    $description = $record['Description'];
} elseif ($total == 2) {
    $title = $record['Name'];
}

?>
<div class="container">
    <h1 style="margin-top:40px;"><?php echo $title ?></h1>

    <p class="truncate-desc">
        <?php echo $description ?>
    </p>

    <p><b>RRID:</b> <?php echo $query ?></p>

    <div class="tab-v5">
        <div class="tab-content">
            <div class="tab-pane fade in active" style="background:#f8f8f8;padding:10px;border-top:1px solid #dedede;border-bottom:1px solid #dedede" id="description">
                <?php

                $count = 0;
                foreach ($record as $key => $value) {
                    if ($key == 'Resource Name' || $key == 'Description' || $key == 'Antibody Name' || $key == 'Name')
                        continue;
                    if ($count % 4 == 0)
                        echo '<div class="row">';
                    echo '<div class="col-md-3">';
                    echo '<div class="tag-box tag-box-v2 box-shadow shadow-effect-1">';
                    echo '<h2>' . $key . '</h2>';
                    echo '<p>' . $value . '</p>';
                    echo '</div></div>';
                    if ($count % 4 == 3)
                        echo '</div>';
                    $count++;
                }
                if ($count % 4 != 0)
                    echo '</div>';


                ?>
                <!-- Description -->

            </div>
        </div>
    </div>
</div>