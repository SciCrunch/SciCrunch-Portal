<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

$community = new Community();
$community->getByID($cid);

foreach ($_POST as $key => $value) {
    if ($key == 'content'){
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$data = new Component_Data();

$vars['uid'] = $_SESSION['user']->id;
$vars['cid'] = $cid;
$vars['component'] = $id;
$vars['color'] = '000000';

$data->create($vars);
$data->insertDB();

$splits = explode(',',$vars['tags']);
$data->insertTags($splits);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'add-community-content',
    'content' => 'Successfully added ' . $data->title
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/'.$community->portalName);

?>