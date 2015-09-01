<?php

include '../classes/classes.php';

$db = new Connection();
$db->connect();


$xml = simplexml_load_file('registry.xml');
if($xml){
    foreach($xml->result->results->row as $row){
        $isDknet = false;
        $isCinergi = false;
        $id = false;
        foreach($row->data as $data){
            switch ((string)$data->name) {
                case "relatedtoforfacet":
                    $splits = explode('dkNET', (string)$data->value);
                    if (count($splits) > 1)
                        $isDknet = true;
                    break;
                case "see_full_record":
                    $id = (string)$data->value;
                    break;
                case "listedby":
                    $splits = explode('Consortia-pedia', (string)$data->value);
                    if (count($splits) > 1) {
                        $isCinergi = true;
                    }
                    break;
            }
        }
        if($isDknet)
            $db->update('resources','is',array('cid'),array(34,$id),'where original_id=?');
        if($isCinergi)
            $db->update('resources','iiss',array('cid','typeID','type'),array(55,17,'Consortium',$id),'where original_id=?');
    }
}
$db->close();

?>