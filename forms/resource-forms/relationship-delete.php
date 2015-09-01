<?php

include '../../classes/classes.php';
session_start();

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
$relationship = new Form_Relationship();
$relationship->getByID($id);

if(!isset($_SESSION['user'])||$_SESSION['user']->levels[$relationship->cid]<2){
    header('location:/');
    exit();
}
$relationship->deleteDB();

$community = new Community();
$community->getByID($id);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'relationship-delete',
    'content' => 'Successfully removed form '.$type->name
));
$notification->insertDB();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>