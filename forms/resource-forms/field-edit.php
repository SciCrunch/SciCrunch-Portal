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

$id = filter_var($_GET['id'],FILTER_SANITIZE_STRING);


$field = new Resource_Fields();
$field->getByID($id);
$field->updateData($vars);
$field->updateDB();
$type = new Resource_Type();
$type->getByID($field->tid);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $field->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'field-edit',
    'content' => 'Successfully updated the field: ' . $field->name
));
$notification->insertDB();


$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>