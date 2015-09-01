<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);

$community = new Community();
$community->getByID($cid);

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

foreach ($_POST as $key => $value) {
    $key = end(explode('-', $key));
    if ($key == 'content') {
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

foreach ($_FILES as $key => $array) {
    $splits = explode('-', $key);
    if ($splits[1] == 'file' && $array['name']!='') {
        $extension = end(explode(".", $_FILES[$key]["name"]));
        if ($_FILES[$key]["size"] < 30000000) {
            if ($_FILES[$key]["error"] > 0) {
                //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
                exit();
            } else {
                $vars2['extension'] = strtoupper($extension);
                $name = $community->portalName . '_data_' . rand(0, 1000000000) . '.' . $extension;
                file_put_contents('../../upload/extended-data/' . $name, file_get_contents($_FILES[$key]["tmp_name"]));
                @unlink($_FILES[$key]["tmp_name"]);
                $vars2['file'] = $name;
            }
        } else {
            //header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
            exit();
        }
    } else {
        if ($_FILES[$key] && $_FILES[$key]['error'] != 4) {
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $extension = end(explode(".", $_FILES[$key]["name"]));
            if (($_FILES[$key]["size"] < 5000000) && in_array($extension, $allowedExts)) {
                if ($_FILES[$key]["error"] > 0) {
                    //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
                    exit();
                } else {
                    $name = $community->portalName . '_data_' . rand(0, 1000000000) . '.' . $extension;
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
}

if (isset($vars['start']) && $vars['start'] != '') {
    $vars['start'] = strtotime($vars['start']);
}
if (isset($vars['end']) && $vars['end'] != '') {
    $vars['end'] = strtotime($vars['end']);
}

$data = new Component_Data();

$vars['uid'] = $_SESSION['user']->id;
$vars['cid'] = $cid;
$vars['component'] = $id;

$data->create($vars);
$data->insertDB();

$splits = explode(',', $vars['tags']);
$data->insertTags($splits);

if ($vars['tagger']) {
    $data->insertTags(array($vars['tagger']));
}

$vars2['data'] = $data->id;
$vars2['component'] = $id;
$vars2['cid'] = $cid;
$vars2['uid'] = $_SESSION['user']->id;
$vars2['name'] = $data->title;
$vars2['description'] = $data->description;

if (isset($vars2['file'])) {
    $extend = new Extended_Data();
    $extend->create($vars2);
    $extend->insertDB();
}

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed' => 0,
    'start' => time(),
    'end' => time(),
    'type' => 'add-container-content',
    'content' => 'Successfully added ' . $data->title
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

// If the component data was for "series1", then auto insert linked "challenge" component
$dataComp = new Component();
$dataComp->getByType($community->id, $vars2['component']);

if ($dataComp->icon1 == 'series1') {
	if (isset($_GET['series1_position']))
		$vars['series1_position'] = $_GET['series1_position'];

	include $_SERVER['DOCUMENT_ROOT'] . "/forms/component-forms/challenge-component-add.php";
}
	
$previousPage = $_SERVER['HTTP_REFERER'];
$splits = explode('?editmode=true', $previousPage);

if (count($splits) > 1) {
    header('location:' . $splits[0]);
} else {
    if ($community->id == 0)
        header('location:/account/scicrunch?tab=content');
    else
        header('location:/account/communities/' . $community->portalName . '?tab=content');
}

?>
