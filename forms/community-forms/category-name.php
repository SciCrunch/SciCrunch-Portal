<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);
$type = filter_var($_GET['type'],FILTER_SANITIZE_STRING);
$pastCat = filter_var($_POST['past-category'],FILTER_SANITIZE_STRING);
$pastSub = filter_var($_POST['past-subcategory'],FILTER_SANITIZE_STRING);
$cat = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
$sub = filter_var($_POST['subcategory'],FILTER_SANITIZE_STRING);

$category = new Category();
$category->updateName($cid,$type,$pastCat,$pastSub,$cat,$sub);

$community = new Community();
$community->getByID($cid);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-name-update',
    'content' => 'Successfully updated the name from : ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName.'/sources');

?>