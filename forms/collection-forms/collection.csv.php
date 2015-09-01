<?php

include '../../classes/classes.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
session_start();

$id = filter_var($_GET['collection'],FILTER_SANITIZE_NUMBER_INT);
if(!isset($_SESSION['user']) || !$_SESSION['user']->collections[$id]){
    exit();
}

$holder = new Sources();
$sources = $holder->getAllSources();
$collection = $_SESSION['user']->collections[$id];

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename='.str_replace(' ','_',$collection->name).'.csv');
header('Pragma: no-cache');

$snippet = new Snippet();
$rows[] = 'title,description,citation,url,community,view id,source name,uuid';

$holder = new Item();
$items = $holder->getByCollection($collection->id, $_SESSION['user']->id);

foreach($items as $item){
    $xml = simplexml_load_string($item->snippet);
    $community = new Community();
    $community->getByID($item->community);
    $rows[] = '"'.str_replace('"','""',strip_tags($xml->title)).'","'.str_replace('"','""',strip_tags($xml->description)).'","'.str_replace('"','""',strip_tags($xml->citation)).'","'.str_replace('"','""',strip_tags($xml->url)).'","'.str_replace('"','""',$community->name).'",'.$item->view.','.$sources[$item->view]->getTitle().','.$item->uuid;
}

echo join("\r\n",$rows);

?>
