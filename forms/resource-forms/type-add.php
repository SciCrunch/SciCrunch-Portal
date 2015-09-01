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

$type = new Resource_Type();
$vars['cid']= $cid;
$vars['uid'] = $_SESSION['user']->id;
$type->create($vars);
$type->insertDB();

if($type->id){
    $relationship = new Form_Relationship();
    $vars['uid'] = $_SESSION['user']->id;
    $vars['cid'] = $cid;
    $vars['rid'] = $type->id;
    $vars['type'] = 'resource';
    $vars['query'] = '';
    $relationship->create($vars);
    $relationship->insertDB();
}

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'type-add',
    'content' => 'Successfully added the resource type: ' . $type->name
));
$notification->insertDB();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>