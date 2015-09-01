<?php

include '../classes/classes.php';

$name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);
$currName = filter_var($_GET['currName'],FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['uid'],FILTER_SANITIZE_NUMBER_INT);

if(!$name){
    echo '0';
    exit;
}

if($name==$currName){
    echo '1';
    exit();
}

$component = new Component();
$component->getPageByType($cid,$name);

$invalidNames = array(
    'sources','resources','search'
);

if($component->id || in_array($name,$invalidNames)){
    echo '0';
} else {
    echo '1';
}

?>