<?php

include '../classes/classes.php';

$db = new Connection();
$db->connect();
$orig = $db->select('resources',array('original_id'),null,array(),'');
$db->close();

$text = '';

foreach($orig as $row){
    $text .= $row['original_id']."\r\n";
}

file_put_contents('neurolex.txt',$text);

?>