<?php

include '../../classes/classes.php';
session_start();
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);
$view = filter_var($_GET['view'],FILTER_SANITIZE_STRING);

if(!isset($_SESSION['user']) || $_SESSION['user']->levels[$cid]<2){
    header('location:/');
    exit();
}


$snippet = new Snippet();
$snippet->getCommunityVersion($cid,$view);


foreach($_POST as $key=>$value){
    $vars[$key] = $value;
}

//print_r($vars);
//print_r($snippet);

if(!$snippet->id){
    $snippet->cid = $cid;
    $snippet->view = $view;
    $snippet->setSnippet($vars);
    $snippet->insertDB();
} else {
    $snippet->setSnippet($vars);
    $snippet->updateDB();
}

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
    'type' => 'snippet-update',
    'content' => 'Successfully updated the snippet for: '.$community->portalName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);
?>