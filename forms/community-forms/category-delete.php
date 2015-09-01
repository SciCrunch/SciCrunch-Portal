<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$community = new Community();
$community->getByID($cid);

$x = filter_var($_GET['x'],FILTER_SANITIZE_NUMBER_INT);
$y = filter_var($_GET['y'],FILTER_SANITIZE_NUMBER_INT);
$z = filter_var($_GET['z'],FILTER_SANITIZE_NUMBER_INT);
$type = filter_var($_GET['type'],FILTER_SANITIZE_STRING);

$category = new Category();
$category->x = $x;$category->y = $y;$category->z = $z;$category->cid = $cid;
$category->deleteType($type);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-' . $return . '-delete',
    'content' => 'Successfully deleted the ' . $return . ' in : ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName.'/sources');

?>