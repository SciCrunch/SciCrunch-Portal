<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../classes/classes.php';

$db = new Connection();
$db->connect();
$return = $db->select('scicrunch_communities',array('*'),null,array(),'order by id asc');
$db->close();

foreach($return as $row){
    $community = new Community();
    $row['uid'] = $row['owner'];
    $community->createFromRow($row);
    $community->insertDB();
}

?>