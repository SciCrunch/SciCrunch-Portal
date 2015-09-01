<?php
include '../classes/classes.php';
set_time_limit(600);

error_reporting(E_ALL);
ini_set("display_errors", 1);
$db = new Connection();
$db->connect();

$values = $db->select('resource_columns',array('value'),null,array(),'where name="Resource Type" limit 10000,4000');
foreach($values as $row){
    $splits = explode(',',$row['value']);
    foreach($splits as $facet){
        $facet = trim($facet);
        $return = $db->select('registry_facets',array('id'),'s',array($facet),'where name="Resource Type" and value=?');
        if(count($return)>0){
            $db->increment('registry_facets','ii',array('count'),array(1,$return[0]['id']),'where id=?');
        } else {
            $db->insert('registry_facets','issi',array(null,'Resource Type',$facet,1));
        }
    }
}
$db->close();

?>