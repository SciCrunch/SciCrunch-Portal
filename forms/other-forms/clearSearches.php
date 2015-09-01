<?php

include '../../classes/classes.php';
session_start();

if(!isset($_SESSION['user'])|| $_SESSION['user']->role<1){
    header('location:/');
    exit();
}

$search = new Search();
$search->clearLocalStore();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'user-edit',
    'content' => 'Successfully cleared the search Cache'
));
$notification->insertDB();

$_SESSION['user']->last_check = time();

header('location:/account/scicrunch');

?>