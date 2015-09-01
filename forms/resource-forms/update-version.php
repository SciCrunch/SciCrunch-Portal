<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if(!isset($_SESSION['user'])){

    $previousPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $previousPage);
    exit();
}

$rid = filter_var($_GET['rid'],FILTER_SANITIZE_STRING);
$version = filter_var($_GET['version'],FILTER_SANITIZE_NUMBER_INT);
$status = filter_var($_GET['status'],FILTER_SANITIZE_STRING);

$resource = new Resource();
$resource->getByID($rid);

if($_SESSION['user']->role<1 && $_SESSION['user']->levels[$resource->cid]<2){

    $previousPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $previousPage);
    exit();
}

$ver = $resource->getVersionInfo($version);
if(!$ver['id']){

    $previousPage = $_SERVER['HTTP_REFERER'];
    header('location:' . $previousPage);
    exit();
}

$resource->updateVersion($version);
$resource->updateStatus($status);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $resource->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'resource-version',
    'content' => 'Successfully updated the resource: ' . $resource->rid
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);
?>