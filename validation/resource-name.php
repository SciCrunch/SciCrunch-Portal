<?php

include '../classes/classes.php';

$name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);

$db = new Connection();
$db->connect();
$return = $db->select('resource_columns',array('count(*)'),'ss',array($name,$name),'where (name="Resource Name" and value=?) or ((name="Synonyms" or name="Abbreviations") and find_in_set(?,value)>0)');
$db->close();

$splitres = explode('/', $name);
if($return[0]['count(*)']>0 || $name=='' || count($splitres) > 1){
    echo '0';
} else {
    echo '1';
}

?>
