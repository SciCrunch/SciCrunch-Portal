<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$comp = filter_var($_GET['component'], FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);

$component = new Component();
$found = false;
$components = $component->getByCommunity($cid);
foreach ($components['body'] as $compo) {
    if ($compo->id == $comp) {
        $component = $compo;
        $found = true;
    }
}
if ($found) {
    $component->shiftAll($component->position, $cid, -1);
    $component->removeDB();

    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $community->id,
        'timed'=>0,
        'start'=>time(),
        'end'=>time(),
        'type' => 'delete-body-component',
        'content' => 'Successfully removed ' . $component->getTitle() . ' from ' . $community->shortName
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>