<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$previousPage = $_SERVER['HTTP_REFERER'];
$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($id)){
    header('location:'.$previousPage);
    exit();
}

$saved = new Saved();
$saved->getByID($id);

if(!$saved->id || $saved->uid != $_SESSION['user']->id){
    header('location:'.$previousPage);
    exit();
}

$saved->deleteDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $saved->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'delete-search',
    'content' => 'Successfully deleted that saved search'
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>