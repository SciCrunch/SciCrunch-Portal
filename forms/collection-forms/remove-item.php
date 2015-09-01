<?php

include '../../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$redirect = filter_var($_GET['redirect'], FILTER_SANITIZE_STRING);

$vars['view'] = filter_var($_GET['view'], FILTER_SANITIZE_STRING);
$vars['uuid'] = filter_var($_GET['uuid'], FILTER_SANITIZE_STRING);
$vars['collection'] = filter_var($_GET['collection'], FILTER_SANITIZE_NUMBER_INT);
$vars['community'] = filter_var($_GET['community'], FILTER_SANITIZE_NUMBER_INT);

$item = new Item();

if (!isset($_SESSION['user']) || !$_SESSION['user']->collections[$vars['collection']]) {
    exit();
}

$collection = $_SESSION['user']->collections[$vars['collection']];

$item->getFromCollection($_SESSION['user']->id, $vars['collection'], $vars['uuid']);

if ($item->id) {
    $item->deleteItem();
}

$items = $item->checkRecord($_SESSION['user']->id, $vars['uuid']);

$_SESSION['user']->collections[$collection->id]->count--;

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
    'content' => 'Successfully removed the record from: ' . $collection->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

if ($redirect == 'true') {

    $previousPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $previousPage);
} else
    echo json_encode(array('item' => $item->id, 'num' => $collection->count, 'inColl' => count($items) > 0 ? 'true' : 'false'));

?>