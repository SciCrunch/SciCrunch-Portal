<?php
include '../classes/classes.php';
$view = filter_var($_GET['view'],FILTER_SANITIZE_STRING);
$uuid = filter_var($_GET['uuid'],FILTER_SANITIZE_STRING);

$url = ENVIRONMENT.'/v1/federation/data/'.$view.'.xml?q=*&filter=v_uuid:'.$uuid;
$xml = simplexml_load_file($url);
echo '<div class="close dark less-right">X</div>';
if($xml){?>
<table class="table-responsive" style="width:100%">
    <?php
    foreach($xml->result->results->row->data as $data){
        if($data->name == "Reference") $data->value = \helper\checkLongURL($data->value);
        echo '<tr><th style="background:#f7f7f7;padding:10px;border:1px solid #999">'.$data->name.'</th><td style="padding:10px;border:1px solid #999">'.$data->value.'</td></tr>';
    }
    ?>
</table>
<?php }
else{
    echo '<h2>No available data</h2>';
}

?>
