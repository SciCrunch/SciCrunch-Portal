<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$comp = filter_var($_GET['component'], FILTER_SANITIZE_NUMBER_INT);

if (!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)) {
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);

$data = new Component_Data();
$data->getByID($comp);
$preserve_link = $data->link;

if($data->cid == $cid){
    $data->shiftAll($data->position,$cid,-1,$data->component);
    $data->removeDB();

    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $community->id,
        'timed'=>0,
        'start'=>time(),
        'end'=>time(),
        'type' => 'delete-body-data',
        'content' => 'Successfully removed ' . $data->getTitle() . ' from ' . $community->shortName
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

// If deletion is for challenge, need to also remove data from community_components
$link0 = new Component;
$link0->getPageByType($cid, $preserve_link);

if (($link0->icon1 == 'challenge1') || ($link0->icon1 == 'series1')) {
	$link0->shiftAllPages($link0->position,$cid,-1);
	$link0->removeDB();

	$notification = new Notification();
	$notification->create(array(
		'sender' => 0,
		'receiver' => $_SESSION['user']->id,
		'view' => 0,
		'cid' => $community->id,
		'timed'=>0,
		'start'=>time(),
		'end'=>time(),
		'type' => 'delete-body-data',
		'content' => 'Successfully removed ' . $data->getTitle() . ' from ' . $community->shortName
	));
	$notification->insertDB();
}	

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>