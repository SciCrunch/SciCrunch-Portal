<?php

include '../../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$views = filter_var($_POST['views'],FILTER_SANITIZE_STRING);
$uuids = filter_var($_POST['items'],FILTER_SANITIZE_STRING);
$vars['collection'] = filter_var($_POST['collection'],FILTER_SANITIZE_NUMBER_INT);
$vars['community'] = filter_var($_POST['community'],FILTER_SANITIZE_NUMBER_INT);



if (!isset($_SESSION['user'])||!$_SESSION['user']->collections[$vars['collection']]) {
    exit();
}

$uuidSplit = explode(',',$uuids);
$viewSplit = explode(',',$views);

$collection = $_SESSION['user']->collections[$vars['collection']];

$vars['uid'] = $_SESSION['user']->id;
foreach($uuidSplit as $i=>$uuid){
    $item = new Item();
    if($item->checkExistence($_SESSION['user']->id,$vars['collection'],$uuid))
        continue;

    $snippet = new Snippet();
    $snippet->getSnippetByView($vars['community'],$viewSplit[$i]);
    $snippet->resetter();

    $url = ENVIRONMENT.'/v1/federation/data/'.$viewSplit[$i].'.xml?exportType=all&filter=v_uuid:'.$uuid;
    $xml = simplexml_load_file($url);
    if($xml){
        foreach($xml->result->results->row->data as $data){
            $snippet->replace((string)$data->name,(string)$data->value);
        }
    }

    $vars['uuid'] = $uuid;
    $vars['view'] = $viewSplit[$i];
    $vars['snippet'] = $snippet->using;

    $item->create($vars);
    $item->insertDB();

    $_SESSION['user']->collections[$collection->id]->count++;
}


$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $vars['community'],
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'collection-add-all',
    'content' => 'Successfully added the records to: ' . $collection->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>