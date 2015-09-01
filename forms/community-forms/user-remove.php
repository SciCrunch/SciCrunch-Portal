<?php

include '../../classes/classes.php';
session_start();

$uid = filter_var($_GET['uid'],FILTER_SANITIZE_NUMBER_INT);
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user'])||($_SESSION['user']->levels[$cid]<$level && $_SESSION['role']<1)){
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);
$community->removeUser($uid);

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
    'type' => 'user-add',
    'content' => 'Successfully removed the user'
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
    'type' => 'removed-from-community',
    'content' => 'You were removed from '.$community->shortName
));
$notification->insertDB();

$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName);


?>