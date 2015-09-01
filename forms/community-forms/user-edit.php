<?php

include '../../classes/classes.php';
session_start();

$level = filter_var($_POST['level'],FILTER_SANITIZE_NUMBER_INT);
$uid = filter_var($_POST['uid'],FILTER_SANITIZE_NUMBER_INT);
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user'])||($_SESSION['user']->levels[$cid]<$level && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);
$community->updateUser($uid,$level);

$levels[] = array('','User','Moderator','Administrator','Owner');

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
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
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'edited-in-community',
    'content' => 'You were update to '.$levels[$level].' in '.$community->shortName
));
$notification->insertDB();

$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName);


?>