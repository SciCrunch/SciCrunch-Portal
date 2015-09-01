<?php

include '../../classes/classes.php';
session_start();

$uid = filter_var($_POST['uid'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user'])|| $_SESSION['user']->role<$level){
    header('location:/');
    exit();
}

$user = new User();
$user->getByID($uid);

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
    'content' => 'Successfully deleted the user '
));
$notification->insertDB();

$_SESSION['user']->last_check = time();

header('location:/account/scicrunch');


?>