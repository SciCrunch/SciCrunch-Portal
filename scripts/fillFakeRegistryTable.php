<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../classes/classes.php';
set_time_limit(300);

$xml = simplexml_load_file('registry.xml');
$db = new Connection();
$db->connect();
if($xml){
    $columns = array("resource_name","description","url","keyword","nif_pmid_display","relatedto","parent_organization","abbrev","synonym","supporting_agency","grants","resource_type","listedby","lists","usedby","uses","recommendedby","recommends","availability","termsofuseurl","alturl","oldurl","xref","relation","related_application","related_disease","located_in","processing","species","supercategory","publicationlink","resource_pubmedids_display","comment","editorial_note","resource_updated","valid_status","website_status","curationstatus","resource_type_ids","see_full_record","relatedtoforfacet","date_created","date_updated");

    foreach($xml->result->results->row as $row){
        $array = array();
        for($i=0;$i<43;$i++){
            $array[$i] = '';
        }
        foreach($row->data as $data){
            $key = array_search((string)$data->name,$columns);
            if($key!==false){
                if($key==41||$key==42)
                    $array[$key] = strtotime((string)$data->value);
                else
                    $array[$key] = (string)$data->value;
            }
        }
        //print_r($array);
        $db->insert('fake_registry','sssssssssssssssssssssssssssssssssssssssssss',$array);
    }
}
$db->close();

?>