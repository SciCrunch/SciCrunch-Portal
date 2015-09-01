<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$comp = filter_var($_GET['component'], FILTER_SANITIZE_NUMBER_INT);
$direction = filter_var($_GET['direction'],FILTER_SANITIZE_STRING);

if (!isset($_SESSION['user']) || $_SESSION['user']->levels[$cid] < 2) {
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);

$data = new Component_Data();
$data->getByID($comp);
if ($data->cid == $cid) {
    $data->swap($direction);

    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $community->id,
        'timed'=>0,
        'start'=>time(),
        'end'=>time(),
        'type' => 'shift-body-data',
        'content' => 'Successfully moved ' . $data->getTitle() . ' in ' . $community->shortName
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>