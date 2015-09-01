<?php

include '../classes/classes.php';

$db = new Connection();
$db->connect();
$return = $db->select('scicrunch_communities',array('*'),null,array(),'order by id asc');

foreach($return as $row){
    $db->update('communities','ii',array('uid'),array($row['owner'],$row['id']),'where id=?');
}
$db->close();

?>