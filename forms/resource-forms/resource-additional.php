<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    $varsR['uid'] = 0;
    $ver['uid'] = 0;
} else {
    $varsR['uid'] = $_SESSION['user']->id;
    $ver['uid'] = $_SESSION['user']->id;
}

$rid = filter_var($_GET['rid'], FILTER_SANITIZE_STRING);

$resource = new Resource();
$resource->getByRID($rid);
$resource->getColumns2();

$community = new Community();
$community->getByID($resource->cid);

$ver['cid'] = $community->id;
$ver['email'] = $resource->email;

foreach ($_POST as $key => $value) {
    $splits = explode('-', $key);
    if (count($splits) > 1) {
        $resource->columns[str_replace('_', ' ', $splits[0])][1] = $value;
    } else {
        $resource->columns[str_replace('_', ' ', $key)][0] = filter_var($value, FILTER_SANITIZE_STRING);
    }
}

$resource->createVersion($ver);
$resource->updateVersion($resource->getLatestVersionNum());
$resource->insertColumns2();

if (isset($_SESSION['user'])) {
    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $resource->cid,
        'timed' => 0,
        'start' => time(),
        'end' => time(),
        'type' => 'resource-additional',
        'content' => 'Successfully added more information to resource: ' . $resource->rid
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

if ($resource->cid == 0)
    header('location:/create/resource?form=' . $resource->type . '&rid=' . $resource->rid . '&section=3');
else
    header('location:/' . $community->portalName . '/about/resource?form=' . $resource->type . '&rid=' . $resource->rid . '&section=3');

?>