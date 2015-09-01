<?php

include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);
if (!isset($_SESSION['user']) || $_SESSION['user']->levels[$cid] < 2) {
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);

$id = filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);

$type = new Resource_Type();
$type->getByID($id);

if ($type->id) {
    $relationship = new Form_Relationship();
    $vars['uid'] = $_SESSION['user']->id;
    $vars['cid'] = $cid;
    $vars['rid'] = $id;
    $vars['type'] = 'resource';
    $vars['query'] = '';
    $relationship->create($vars);
    $relationship->insertDB();

    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $community->id,
        'timed'=>0,
        'start'=>time(),
        'end'=>time(),
        'type' => 'add-type-rel',
        'content' => 'Successfully added ' . $type->name . ' to ' . $community->shortName
    ));
    $notification->insertDB();
} else {
    $notification = new Notification();
    $notification->create(array(
        'uid' => $_SESSION['user']->id,
        'cid' => 0,
        'type' => 'add-type-rel-error',
        'content' => 'Type does not exist'
    ));
    $notification->insertDB();
}

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);


?>