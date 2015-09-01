<?php

include '../../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$vars['view'] = filter_var($_GET['view'],FILTER_SANITIZE_STRING);
$vars['uuid'] = filter_var($_GET['uuid'],FILTER_SANITIZE_STRING);
$vars['collection'] = filter_var($_GET['collection'],FILTER_SANITIZE_NUMBER_INT);
$vars['community'] = filter_var($_GET['community'],FILTER_SANITIZE_NUMBER_INT);

$item = new Item();

if (!isset($_SESSION['user'])||!$_SESSION['user']->collections[$vars['collection']]||$item->checkExistence($_SESSION['user']->id,$vars['collection'],$vars['uuid'])) {
    exit();
}

$collection = $_SESSION['user']->collections[$vars['collection']];

$snippet = new Snippet();
$snippet->getSnippetByView($vars['community'],$vars['view']);
$snippet->resetter();

$url = ENVIRONMENT.'/v1/federation/data/'.$vars['view'].'.xml?exportType=all&filter=v_uuid:'.$vars['uuid'];
$xml = simplexml_load_file($url);
if($xml){
    foreach($xml->result->results->row->data as $data){
        $snippet->replace((string)$data->name,(string)$data->value);
    }
}

$vars['snippet'] = $snippet->using;
$vars['uid'] = $_SESSION['user']->id;

$item->create($vars);
$item->insertDB();

$_SESSION['user']->collections[$collection->id]->count++;

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $vars['community'],
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'collection-add',
    'content' => 'Successfully added the record to: ' . $collection->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

echo json_encode(array('item'=>$item->id,'num'=>$collection->count));

?>