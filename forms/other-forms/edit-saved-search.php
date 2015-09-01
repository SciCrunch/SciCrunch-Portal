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
$vars['uid'] = $_SESSION['user']->id;

foreach($_POST as $key => $value){
    $vars[$key] = filter_var($value,FILTER_SANITIZE_STRING);
}

if(!isset($vars['id'])){
    header('location:'.$previousPage);
    exit();
}

$saved = new Saved();
$saved->getByID($vars['id']);

if(!$saved->id || $saved->uid != $vars['uid']){
    header('location:'.$previousPage);
    exit();
}

$saved->updateName($vars['name']);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $saved->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'edit-search',
    'content' => 'Successfully updated your saved search'
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>