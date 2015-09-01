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

foreach ($_POST as $key => $value) {
    if ($key == 'content'){
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$data = new Component_Data();
$data->getByID($id);

$data->title = $vars['title'];
$data->color = 0000;
$data->description = $vars['description'];
$data->content = $vars['content'];

$data->updateDB();

$splits = explode(',',$vars['tags']);
$data->wipeTags();
$data->insertTags($splits);

$community = new Community();
$community->getByID($data->cid);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'update-scicrunch-content',
    'content' => 'Successfully updated ' . $data->title
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/'.$community->portalName);

?>