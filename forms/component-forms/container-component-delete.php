<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}

$community = new Community();
if($cid==0)
    $community->shortName = 'SciCrunch';
else
    $community->getByID($cid);

$component = new Component();
$found = false;
$components = $component->getByCommunity($cid);
foreach ($components['page'] as $compo) {
    if ($compo->id == $id) {
        $component = $compo;
        $found = true;
    }
}
if ($found) {
	$preserve_link = $component->text2;
	$preserve_icon1 = $component->icon1;
    $component->shiftAllPages($component->position, $cid, -1);
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
        'type' => 'delete-container-component',
        'content' => 'Successfully removed ' . $component->text1 . ' from ' . $community->shortName
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}
$component->connect();
$component->delete('component_data','i',array($component->component),'where component=?');

if ($component->icon1 == 'challenge1') {
	$dataComp = new Component_Data();
	$data = $dataComp->getByLink($cid, $preserve_link);

	$dataComp->getByID($data[0]->id);
	$dataComp->shiftAll($dataComp->position,$cid,-1, $dataComp->component);
	$dataComp->removeDB();

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
		'content' => 'Successfully removed ' . $dataComp->getTitle() . ' from ' . $community->shortName
	));
	$notification->insertDB();
}
$component->close();

$previousPage = $_SERVER['HTTP_REFERER'];
$splits = explode('/about/',$previousPage);
if(count($splits)>1){
    header('location:/'.$community->portalName);
} else {

header('location:' . $previousPage);
}

?>