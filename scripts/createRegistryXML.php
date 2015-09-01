<?php

include '../classes/classes.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit(600);

$columns = array('Resource Name','Description','Resource URL','Keywords','Defining Citation',
    'Related To','Parent Organization','Abbreviation','Synonyms','Funding Information','Listed By',
    'Lists','Used By','Uses','Recommended By','Recommends','Availability','Related Disease','Species');

$db = new Connection();
$db->connect();
$return = $db->select('resources',array('*'),null,array(),'where status="Curated"');
//$return = $db->select('resources',array('*'),null,array(),'where original_id="nlx_inv_1005082" or original_id="nif-0000-10208" or original_id="nlx_145859" or original_id="nlx_145380"');
$db->close();

$file = '<?xml version="1.0" encoding="UTF-8"?><resources>';

if(count($return)>0){
    foreach($return as $row){
        $vars = array();
        $resource = new Resource();
        $resource->createFromRow($row);
        $resource->getColumns();

        foreach($resource->columns as $name=>$value){
            if(in_array($name,$columns)){
                $vars[$name] = htmlentities($value);
            } else {
                $vars['Other Columns'] = htmlentities($value).' ';
            }
        }

        $file .= '<resource>';
        $file .= '<column><name>Internal ID</name><value>'.$resource->rid.'</value></column>';
        $file .= '<column><name>Original ID</name><value>'.$resource->original_id.'</value></column>';
        $file .= '<column><name>Insert Date</name><value>'.date('h:ia F j, Y', $resource->insert_time).'</value></column>';
        $file .= '<column><name>Edit Date</name><value>'.date('h:ia F j, Y', $resource->edit_time).'</value></column>';
        foreach($vars as $name=>$value){
            $file .= '<column><name>'.$name.'</name><value>'.$value.'</value></column>';
        }
        $file .= '</resource>';
    }
}
$file .= '</resources>';

file_put_contents('registry.dump.xml',$file);
?>