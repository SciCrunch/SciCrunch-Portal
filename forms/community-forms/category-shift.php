<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$community = new Community();
$community->getByID($cid);

if (!isset($_GET['x']))
    $x = -10;
else
    $x = filter_var($_GET['x'], FILTER_SANITIZE_NUMBER_INT);
if (!isset($_GET['y']))
    $y = -10;
else
    $y = filter_var($_GET['y'], FILTER_SANITIZE_NUMBER_INT);
if (!isset($_GET['z']))
    $z = -10;
else
    $z = filter_var($_GET['z'], FILTER_SANITIZE_NUMBER_INT);
$direction = filter_var($_GET['direction'], FILTER_SANITIZE_STRING);


//echo $x . ':' . $y . ':' . $z;

$category = new Category();
$return = $category->swap($x,$y,$z,$direction,$cid);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-' . $return . '-shift',
    'content' => 'Successfully shifted the ' . $return . ' in : ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName.'/sources');

?>