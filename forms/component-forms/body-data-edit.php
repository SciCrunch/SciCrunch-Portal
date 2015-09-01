<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);



$data = new Component_Data();
$data->getByID($id);

if (!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role>1)) {
    header('location:/');
    exit();
}
$community = new Community();
$community->getByID($data->cid);

foreach ($_POST as $key => $value) {
    $splits = explode('-', $key);
    $vars[$splits[1]] = $value;
}
foreach ($_FILES as $key => $array) {
    $splits = explode('-', $key);
    if ($_FILES[$key] && $_FILES[$key]['error'] != 4) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES[$key]["name"]));
        if (($_FILES[$key]["size"] < 5000000)&& in_array(strtolower($extension), $allowedExts)) {
            if ($_FILES[$key]["error"] > 0) {
                //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
                exit();
            } else {
                if($data->image)
                    $name = $data->image;
                else
                    $name = $community->portalName.'_data_'.rand(0,1000000).'.png';
                file_put_contents('../../upload/community-components/'.$name, file_get_contents($_FILES[$key]["tmp_name"]));
                @unlink($_FILES[$key]["tmp_name"]);
                $vars['image'] = $name;
            }
        } else {
            //header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
            exit();
        }
    }
}

if(!$vars['image'])
    $vars['image'] = $data->image;

if (isset($vars['start']) && $vars['start'] != '') {
    $vars['start'] = strtotime($vars['start']);
}
if (isset($vars['end']) && $vars['end'] != '') {
    $vars['end'] = strtotime($vars['end']);
}	
	
$data->updateData($vars);
$data->updateDB();

//print_r($data);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'edit-body-data',
    'content' => 'Successfully updated '.$data->getTitle().' for ' . $community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>
