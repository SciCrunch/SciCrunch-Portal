<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

$component = new Component();
$component->getByID($id);

$cid = $component->cid;

if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}

foreach($_POST as $key=>$value){
    $splits = explode('-',$key);
    $vars[end($splits)] = $value;
}

if($vars['headerSelect']=='boxed'){
    $component->component = 1;
} elseif($vars['headerSelect']=='float'){
    $component->component = 2;
} elseif($vars['headerSelect']=='flat'){
    $component->component = 3;
} elseif($vars['headerSelect']) {
    $component->component = 0;
}

if ($vars['footerSelect'] == 'normal') {
    $component->component = 92;
} elseif ($vars['footerSelect'] == 'light') {
    $component->component = 91;
} elseif ($vars['footerSelect'] == 'dark') {
    $component->component = 90;
}

if($vars['toggle']){
    $component->disabled = 0;
} else {
    $component->disabled = 1;
}

$component->updateData($vars);
$component->updateDB();

$community = new Community();
if($cid==0){
    $community->shortName = 'SciCrunch';
} else {
    $community->getByID($cid);
}

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type'=>'update-other-components',
    'content'=>'Successfully updated the component for '.$community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>