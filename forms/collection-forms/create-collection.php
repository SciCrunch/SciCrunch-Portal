<?php

include '../../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$transfer = filter_var($_POST['transfer'], FILTER_SANITIZE_NUMBER_INT);
$redirect = filter_var($_POST['redirect'], FILTER_SANITIZE_STRING);

$vars['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$vars['uid'] = $_SESSION['user']->id;
$vars['count'] = 0;

$collection = new Collection();
$collection->create($vars);
$collection->insertDB();

if ($transfer == 1) {
    $collection->moveFromDefault();
    $_SESSION['user']->collections[0]->count = 0;
}

$_SESSION['user']->collections[$collection->id] = $collection;

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'collection-create',
    'content' => 'Successfully created the collection : ' . $collection->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

if ($redirect == 'off') {
    echo json_encode(array('name'=>$collection->name,'id'=>$collection->id));
} else {
    $previousPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $previousPage);
}

?>