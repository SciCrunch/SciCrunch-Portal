<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);


if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}



foreach ($_POST as $key => $value) {
    if ($key == 'footer-text1' || $key == 'footer-text2'){
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}


$community = new Community();
$community->getByID($cid);

$holder = new Component();
$components = $holder->getByCommunity($cid);

$footer = $components['footer'][0];

// Header Update

if ($vars['footer-select'] == 'normal') {
    $footer->component = 92;
} elseif ($vars['footer-select'] == 'light') {
    $footer->component = 91;
} elseif ($vars['footer-select'] == 'dark') {
    $footer->component = 90;
}

$footer->color1 = $vars['footer-color1'];
$footer->color2 = $vars['footer-color2'];
$footer->color3 = $vars['footer-color3'];

$footer->text1 = $vars['footer-text1'];
$footer->text2 = $vars['footer-text2'];

// untrusted input HTML

$footer->updateDB();


$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'update-footer-components',
    'content' => 'Successfully updated the footer components for ' . $community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>