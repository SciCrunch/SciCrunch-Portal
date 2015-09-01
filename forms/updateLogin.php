<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include('../classes/classes.php');
session_start();

if (!$_SESSION['user']) {
    exit();
}

$user = new User();
$user->getByID($_SESSION['user']->id);

$_SESSION['user']->last_check = $_SESSION['user']->updateOnline();
$_SESSION['user']->onlineUsers = $user->getOnlineUsers();

foreach ($_SESSION['communities'] as $key=>$community) {
    $holder = new Component();
    $components = $holder->getByCommunity($community->id);

    $community->getCategories();
    $community->components = $components;
    $_SESSION['communities'][$key] = $community;
}

$connection = new Connection();
$connection->connect();
$access = $connection->select('community_access', array('*'), 'i', array($_SESSION['user']->id), 'where uid=?');

if (count($access) > 0) {
    foreach ($access as $row) {
        $_SESSION['user']->levels[$row['cid']] = $row['level'];
    }
}

$connection->close();

$return['html'] = '';

$holder = new Notification();
$notifications = $holder->checkNotifications($_SESSION['user']->id, 0);
//print_r($notifications);
if (count($notifications) > 0) {
    foreach ($notifications as $notification) {
        $return['html'] .= $notification->HTML();
        $notification->setSeen();
    }
}


echo $return['html'];

?>