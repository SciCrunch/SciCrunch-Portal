<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../classes/classes.php';

$db = new Connection();
$db->connect();
$return = $db->select('resources',array('id,uid,cid,status,insert_time'),null,array(),'');

foreach($return as $row){
    $db->insert('resource_versions','iisiiisi',array(null,$row['uid'],$row['cid'],'',$row['id'],1,$row['status'],$row['insert_time']));
}

$db->close();


?>