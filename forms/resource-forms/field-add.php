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

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['type'],FILTER_SANITIZE_STRING);

$type = new Resource_Type();
$type->getByID($id);

$vars['cid'] = $cid;
$vars['uid'] = $_SESSION['user']->id;
$vars['tid'] = $type->id;

$splits = explode('|',$vars['position']);
$vars['page'] = $splits[0];
$vars['position'] = $splits[1];

$field = new Resource_Fields();
$field->create($vars);
$field->shiftAll(1);
$field->insertDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'field-add',
    'content' => 'Successfully added the field: ' . $field->name
));
$notification->insertDB();


$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);


?>