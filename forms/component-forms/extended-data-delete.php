<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$id = filter_var($_GET['data'], FILTER_SANITIZE_NUMBER_INT);

$extend = new Extended_Data();
$extend->getByID($id);

if (!isset($_SESSION['user']) || ($_SESSION['user']->levels[$extend->cid]<2 && $_SESSION['user']->role<1)) {
    header('location:/');
    exit();
}

$extend->removeDB();

$community = new Community();
$community->getByID($extend->cid);

$path_plus_file = $_SERVER['DOCUMENT_ROOT'] . "/upload/extended-data/" . $extend->file;
if (file_exists ($path_plus_file)) {
	@unlink($path_plus_file);
}

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $extend->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'delete-extended-data',
    'content' => 'Successfully deleted '.$extend->file.' for ' . $community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>
