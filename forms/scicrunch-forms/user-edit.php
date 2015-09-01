<?php

include '../../classes/classes.php';
session_start();

$level = filter_var($_POST['level'],FILTER_SANITIZE_NUMBER_INT);
$uid = filter_var($_POST['uid'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user'])|| $_SESSION['user']->role<$level){
    header('location:/');
    exit();
}

$levels = array('User','Curator','Moderator','Administrator','Owner');
$user = new User();
$user->getByID($uid);
$user->updateField('level',$level);

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
    'content' => 'Successfully updated the user to '.$levels[$level]
));
$notification->insertDB();

$notification = new Notification();
$notification->create(array(
    'sender' => $_SESSION['user']->id,
    'receiver' => $uid,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'edited-in-scicrunch',
    'content' => 'You were update to '.$levels[$level].' across SciCrunch'
));
$notification->insertDB();

$_SESSION['user']->last_check = time();

header('location:/account/scicrunch');


?>