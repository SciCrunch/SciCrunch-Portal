<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if (!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid] < 2 && $_SESSION['user']->role < 1)) {
    header('location:/');
    exit();
}

$community = new Community();
if ($cid == 0)
    $community->shortName = 'SciCrunch';
else
    $community->getByID($cid);

foreach ($_POST as $key => $value) {
    $splits = explode('-',$key);
    $vars[$splits[1]] = $value;
}
$component = new Component();
$component->getByID($id);
$preserve_link = $component->text2;
$vars['icon1'] = $component->icon1;
$component->updateData($vars);

$component->updateDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'update-container-component',
    'content' => 'Successfully updated the container component for ' . $community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();


if ($component->icon1 == 'challenge1') {
	$dataComp = new Component_Data();
	$data = $dataComp->getByLink($cid, $preserve_link);
	$dataComp = $data[0];

	$vars['title'] = $vars['text1'];
	$vars['link'] = $vars['text2'];
	$vars['content'] = $vars['text3'];
	$vars['icon'] = $vars['visibility'];
	$vars['color'] = $vars['rules'];
	$vars['image'] = $dataComp->image;

	if (isset($vars['start']) && $vars['start'] != '') {
		$vars['start'] = strtotime($vars['start']);
	}
	if (isset($vars['end']) && $vars['end'] != '') {
		$vars['end'] = strtotime($vars['end']);
	}

	foreach ($_FILES as $key => $array) {
		if ($_FILES[$key] && $_FILES[$key]['error'] != 4) {
			$allowedExts = array("jpg", "jpeg", "gif", "png");
			$extension = end(explode(".", $_FILES[$key]["name"]));
			if (($_FILES[$key]["size"] < 5000000) && in_array($extension, $allowedExts)) {
				if ($_FILES[$key]["error"] > 0) {
					//header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
					exit();
				} else {
					$name = $community->portalName . '_data_' . rand(0, 1000000000) . '.' .$extension;
					file_put_contents('../../upload/community-components/' . $name, file_get_contents($_FILES[$key]["tmp_name"]));
					@unlink($_FILES[$key]["tmp_name"]);
					$vars['image'] = $name;
				}
			} else {
				//header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
				exit();
			}
		}
	}

	$dataComp->updateData($vars);
	$dataComp->updateDB();
	
	$notification = new Notification();
	$notification->create(array(
		'sender' => 0,
		'receiver' => $_SESSION['user']->id,
		'view' => 0,
		'cid' => $community->id,
		'timed'=>0,
		'start'=>time(),
		'end'=>time(),
		'type' => 'update-container-component',
		'content' => 'Successfully updated the container component for ' . $community->shortName
	));
	$notification->insertDB();

}

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>