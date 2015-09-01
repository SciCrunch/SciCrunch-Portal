<?php
$custom = new View();
$custom->getByCommView($community->cid, $vars['view']);
$holder = new View_Column();
$tiles = $holder->getByCustom($custom->id);
$url = 'nif_services_federation_data_service_endpoint' . $vars['view'] . '.xml?q=*&filter=v_uuid:' . $vars['uuid'];
$xml = simplexml_load_file($url);
if ($xml) {
    foreach ($xml->result->results->row->data as $data) {
        $columns[(string)$data->name] = (string)$data->value;
    }
}
$pmids = array();
foreach($tiles['literature'] as $section){
    if($section->type == 'literature-link'){
        if(strip_tags($columns[$section->field])!='')
            $pmids = array_merge($pmids, explode(',',str_replace(' ','',str_replace('PMID: ','',strip_tags($columns[$section->field])))));
    }
}
$splits = explode('-', $vars['view']);
$rootID = join('-', array_slice($splits, 0, count($splits) - 1));
$url = 'nif_services_federation_data_service_endpoint' . $rootID;
$xml = simplexml_load_file($url);
if ($xml) {
    foreach ($xml->result->results->row->data as $data) {
        $record[(string)$data->name] = (string)$data->value;
    }
}

$info_data = buildSections($tiles, $columns);

function buildSections($tiles, $columns){
    $info_data = Array('sections' => Array());
    foreach($tiles['tiles'] as $x => $rows){
        foreach($rows as $y => $sections){
            foreach($sections as $section){
                $this_info = Array();
                $this_info['title'] = $section->field;
                $this_info['type'] = $section->type;
                if($this_info['type'] == "text"){
                    $this_info['text'] = $columns[$this_info['title']];
                    if(!$this_info['text']) continue;	// skip empty fields
                    array_push($info_data['sections'], $this_info);
                }elseif($this_info['type'] == "map-text"){
                    $url = 'https://maps.google.com/maps/api/geocode/xml?address=' . $columns[$this_info['title']] . '&sensor=false';
                    $xml = simplexml_load_file($url);
                    if($xml){
                        $this_info['lat'] = $xml->result->geometry->location->lat;
                        $this_info['lng'] = $xml->result->geometry->location->lng;
                        $this_info['divid'] = str_replace(' ', '_', $this_info['title']);
                        $this_info['point'] = $columns[$this_info['title']];
                        $info_data['map'] = $this_info;
                    }
                }
            }
        }
    }
    return $info_data;
}


/******************************************************************************************************************************************************************************************************/
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


<div class="container margin-bottom-50" style="margin-top:50px">
    <h1><?php echo $columns[$custom->title] ?></h1>

    <p class="truncate-desc">
        <?php echo \helper\formattedDescription($columns[$custom->description]) ?>
    </p>

    <div class="tab-v5">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#description" role="tab" data-toggle="tab">Information</a></li>
            <li><a href="#source" role="tab" data-toggle="tab">Source</a></li>
            <?php if($pmids){?>
                <li><a href="#literature" role="tab" data-toggle="tab">References</a></li>
            <?php } ?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="description">
                <div class="row">
                    <?php if(isset($info_data['map'])): ?>
                        <div class="col-md-6">
                    <?php else: ?>
                        <div class="col-md-12">
                    <?php endif ?>
                    <div class="row">
                    <?php foreach($info_data['sections'] as $section): ?>
                        <div class="col-md-6">
                            <div class="tag-box tag-box-v2 box-shadow shadow-effect-1">
                                <h2><?php echo $section['title'] ?></h2>
                                <p><?php echo $section['text'] ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                    <?php if(isset($info_data['map'])): ?>
                        </div>
                        <div class="col-md-6">
                            <div id="<?php echo $info_data['map']['divid'] ?>" class="map" lat="<?php echo $info_data['map']['lat'] ?>" lng="<?php echo $info_data['map']['lng'] ?>" point="<?php echo $info_data['map']['point'] ?>"></div>
                        </div>
                    <?php endif ?>
                    </div>
                    <!-- Description -->

                </div>

            <div class="tab-pane fade" id="source">
                <?php
                echo '<div class="row">';
                echo '<div class="col-md-8">';
                echo '<h2>'.$record['Resource Name'].'</h2>';
                echo '<p class="truncate-desc">'.\helper\formattedDescription($record['Description']).'</p>';
                echo '</div>';
                echo '<div class="col-md-4"><a href="/'.$community->portalName.'/about/sources/'.$vars['view'].'" class="btn-u btn-u-lg">View Source Info</a></div>';
                echo '</div>';
                ?>
            </div>

            <?php
            if(count($pmids)){
                echo '<div class="tab-pane fade" id="literature">';
                $url3 = 'nif_services_literature_service_endpoint'.join('&pmid=',$pmids);
                $xml3 = simplexml_load_file($url3);
                $months = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                if($xml3){
                    foreach($xml3->publication as $paper){
                        echo '<div class="row">';
                        echo '<div class="col-md-12">';
                        echo '<div class="tag-box tag-box-v2 box-shadow shadow-effect-1">';
                        echo '<h2><a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$paper['pmid'].'">'.$paper->title.'</a></h2>';
                        echo '<ul class="list-inline up-ul">';
                        echo '<li>'.$paper->authors->author.'</li>';
                        echo '<li>'.$paper->journalShort.'</li>';
                        echo '<li>'.$paper->year.' '.$months[$paper->month].' '.$paper->day.'</li>';
                        echo '</ul>';
                        echo '<p class="truncate-desc">'.$paper->abstract.'</p>';
                        echo '<ul class="list-inline up-ul" style="margin-top:7px">';
                        echo '<li><a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$paper['pmid'].'">PMID:'.$paper['pmid'].'</a></li>';
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
</div>
