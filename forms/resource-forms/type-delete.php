<?php

include '../../classes/classes.php';
session_start();

if(!isset($_SESSION['user'])||$_SESSION['user']->role<1){
    header('location:/');
    exit();
}

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
$type = new Resource_Type();
$type->getByID($id);
$type->deleteDB();


$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $type->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'type-delete',
    'content' => 'Successfully deleted '.$type->name
));
$notification->insertDB();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>