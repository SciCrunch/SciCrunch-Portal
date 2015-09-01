<?php

include '../../classes/classes.php';
session_start();

if(!isset($_SESSION['user'])){
    header('location:/');
    exit();
}

foreach($_POST as $key=>$value){
    $vars[$key] = filter_var($value,FILTER_SANITIZE_STRING);
}

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
$type = new Resource_Type();
$type->getByID($id);

$type->name = $vars['name'];
$type->description = $vars['description'];
$type->facet = $vars['facet'];
$type->url = $vars['url'];
$type->parent = $vars['parent'];

$type->updateDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $type->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'type-edit',
    'content' => 'Successfully updated the resource type: ' . $type->name
));
$notification->insertDB();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>