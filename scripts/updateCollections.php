<?php


include '../classes/classes.php';

$db = new Connection();
$db->connect();

$return = $db->select('collections',array('*'),null,array(),'');
foreach($return as $row){
    $collection = new Collection();
    $collection->createFromRow($row);
    $collections[] = $collection;
}

foreach($collections as $collection){
    $return = $db->select('collected',array('count(*)'),'i',array($collection->id),'where collection=?');
    $db->update('collections','ii',array('count'),array($return[0]['count(*)'],$collection->id),'where id=?');
    $ids[] = $collection->id;
}

$db->delete('collected',null,array(),'where collection!='.join(' and collection!=',$ids));

$db->close();

?>