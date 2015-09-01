<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

foreach ($_POST as $key => $value) {
    $key = end(explode('-',$key));
    if ($key == 'content'){
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$data = new Component_Data();
$data->getByID($id);
$preserve_old_link = $data->link;

$community = new Community();
$community->getByID($data->cid);

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

$data->title = $vars['title'];
$data->description = $vars['description'];
$data->content = $vars['content'];
$data->color = $vars['color'];
$data->icon = $vars['icon'];
if (isset($vars['start']) && $vars['start'] != '') {
    $vars['start'] = strtotime($vars['start']);
	$data->start = $vars['start'];
}
if (isset($vars['end']) && $vars['end'] != '') {
    $vars['end'] = strtotime($vars['end']);
	$data->end = $vars['end'];
}
if(isset($vars['image'])){
    $old_image = '../../upload/community-components/' . $data->image;
    if(file_exists($old_image)) unlink($old_image);	// delete the old file
    $data->image = $vars['image'];
}

if (isset($vars['link']))
    $data->link = $vars['link'];

$data->updateDB();

$splits = explode(',',$vars['tags']);
$data->wipeTags();
$data->insertTags($splits);
if($vars['tagger']){
    $data->insertTags(array($vars['tagger']));
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
    'type' => 'update-scicrunch-content',
    'content' => 'Successfully updated ' . $data->title
));
$notification->insertDB();

// If challenge is being updated, also need to update "community_components" table
$comp = new Component;
$comp->getPageByType($community->id, $preserve_old_link);

if (($comp->icon1 == 'challenge1') || ($comp->icon1 == 'series1')) {
	$comp->text1 = $vars['title'];
	$comp->text2 = $vars['link'];
	$comp->text3 = $vars['content'];
	
	$comp->updateDB();

	$notification = new Notification();
	$notification->create(array(
		'sender' => 0,
		'receiver' => $_SESSION['user']->id,
		'view' => 0,
		'cid' => $community->id,
		'timed'=>0,
		'start'=>time(),
		'end'=>time(),
		'type' => 'update-scicrunch-content',
		'content' => 'Successfully updated ' . $data->title
	));
	$notification->insertDB();
}

$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];

// if edit started on the content page, send them back to content page with new link
$splits = explode('?editmode=true', $previousPage);
if (count($splits) > 1) {
	header('location:' . str_replace($preserve_old_link, $vars['link'],  $splits[0]));
} else {
    header('location:'.$previousPage);
}


?>
