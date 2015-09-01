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

<?php

$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$custom = new View();
$custom->getByCommView($community->cid, $vars['view']);

$holder = new View_Column();
$tiles = $holder->getByCustom($custom->id);

$url = 'nif_services_literature_service_endpoint' . $vars['pmid'];
$xml = simplexml_load_file($url);
if ($xml) {
    $paper['title'] = (string)$xml->publication->title;
    $paper['abstract'] = (string)$xml->publication->abstract;
    foreach ($xml->publication->authors->author as $author) {
        $paper['authors'][] = (string)$author;
    }
    foreach ($xml->publication->meshHeadings->meshHeading as $mesh) {
        $paper['mesh'][] = (string)$mesh;
    }
    $paper['date'] = $months[(int)$xml->publication->month - 1] . ' ' . $xml->publication->day . ', ' . $xml->publication->year;
    $paper['journal'] = (string)$xml->publication->journal;
    foreach ($xml->publication->grantAgencies->grantAgency as $grant) {
        $paper['grants'][] = (string)$grant;
    }
    foreach ($xml->publication->grantIds->grantId as $grant) {
        $paper['grantIds'][] = (string)$grant;
    }
}

$url2 = 'nif_services_federation_data_service_endpoint' . $vars['pmid'] . '&count=50';
$xml2 = simplexml_load_file($url2);
if ($xml2) {
    foreach ($xml2->result->results->row as $row) {
        $columns = array();
        foreach ($row->data as $data) {
            $columns[(string)$data->name] = (string)$data->value;
        }
        $links[] = $columns;
    }
}

foreach ($links as $array) {
    $info[strip_tags($array['resource_name'])]['meta'] = '/browse/resources/' . $array['id'];
    $info[strip_tags($array['resource_name'])]['links'][] = '<a target="_blank" href="' . $array['link_url'] . '">' . $array['link_name'] . '</a>';
}
?>

<div class="container margin-bottom-50" style="margin-top:50px">
    <h1><?php echo $paper['title'] ?></h1>

    <p class="truncate-desc">
        <?php echo $paper['abstract'] ?>
    </p>

    <p>
        <b>Pubmed ID:</b> <?php echo $vars['pmid'] ?>
    </p>

    <div class="tab-v5">
        <ul class="nav nav-tabs" role="tablist">
            <li <?php if (!isset($vars['resource'])) echo 'class="active"' ?>><a href="#description" role="tab"
                                                                                 data-toggle="tab">Information</a></li>
            <li <?php if (isset($vars['resource'])) echo 'class="active"' ?>><a href="#link" role="tab"
                                                                                data-toggle="tab">Linkouts</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade <?php if (!isset($vars['resource'])) echo 'in active' ?>" id="description">
                <div class="row">
                    <div class="col-md-3">
                        <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                            <h2>Authors</h2>
                            <ul style="max-height:250px;overflow: auto">
                                <?php foreach ($paper['authors'] as $author) {
                                    echo '<li>' . $author . '</li>';
                                }?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                                    <h2>Journal</h2>

                                    <p><?php echo $paper['journal'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                                    <h2>Publication Data</h2>

                                    <p><?php echo $paper['date'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                                    <h2>Associated Grants</h2>
                                    <?php
                                    if (count($paper['grants']) > 0) {
                                        echo '<ul>';
                                        foreach ($paper['grants'] as $i => $grant) {
                                            echo '<li><b>Agency: </b>' . $grant . ', <b>Id: </b>' . $paper['grantIds'][$i] . '</li>';
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo 'None';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                            <h2>Mesh Terms</h2>
                            <ul style="max-height:250px;overflow: auto">
                                <?php foreach ($paper['mesh'] as $mesh) {
                                    echo '<li>' . $mesh . '</li>';
                                }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?php if (isset($vars['resource'])) echo 'in active' ?>" id="link">
                <?php
                $i = 0;
                foreach ($info as $name => $array) {
                    ?>
                    <?php if ($i % 2 == 0) echo '<div class="row">'; ?>
                    <div class="col-md-6">
                        <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                            <h2><a href="<?php echo $array['meta'] ?>"><?php echo $name ?></a></h2>
                            <ul style="max-height:250px;overflow: auto">
                                <?php foreach ($array['links'] as $link) {
                                    echo '<li>' . $link . '</li>';
                                }?>
                            </ul>
                        </div>
                    </div>
                    <?php if ($i % 2 == 1) echo '</div>'; ?>
                    <?php $i++; ?>
                <?php } ?>
                <?php if ($i % 2 != 0) echo '</div>'; ?>
            </div>
        </div>
    </div>
</div>
