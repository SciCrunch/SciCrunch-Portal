<?php

include '../../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);
$community = new Community();
$community->getByID($cid);

$vars['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$vars['description'] = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
$vars['shortName'] = filter_var($_POST['short'], FILTER_SANITIZE_STRING);
$vars['url'] = filter_var($_POST['url'], FILTER_SANITIZE_URL);
$vars['private'] = filter_var($_POST['private'],FILTER_SANITIZE_NUMBER_INT);
$vars['access'] = filter_var($_POST['join'], FILTER_SANITIZE_STRING);

$resource = filter_var($_POST['resource'], FILTER_SANITIZE_STRING);
$data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
$lit = filter_var($_POST['lit'], FILTER_SANITIZE_STRING);
$about_home_view = filter_var($_POST["about_home_view"], FILTER_SANITIZE_STRING);
$about_sources_view = filter_var($_POST["about_sources_view"], FILTER_SANITIZE_STRING);

if ($resource == 'on')
    $vars['resourceView'] = 1;
else
    $vars['resourceView'] = 0;

if ($data == 'on')
    $vars['dataView'] = 1;
else
    $vars['dataView'] = 0;

if ($lit == 'on')
    $vars['literatureView'] = 1;
else
    $vars['literatureView'] = 0;

if($about_home_view == 'on')
    $vars['about_home_view'] = 1;
else
    $vars['about_home_view'] = 0;

if($about_sources_view == 'on')
    $vars['about_sources_view'] = 1;
else
    $vars['about_sources_view'] = 0;

//print_r($_FILES);

$key = 'file';
if ($_FILES[$key] && $_FILES[$key]['error'] != 4) {
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $extension = end(explode(".", $_FILES[$key]["name"]));
    if ((($_FILES[$key]["type"] == "image/gif")
            || ($_FILES[$key]["type"] == "image/jpeg")
            || ($_FILES[$key]["type"] == "image/png")
            || ($_FILES[$key]["type"] == "image/pjpeg"))
        && ($_FILES[$key]["size"] < 5000000)
        && in_array(strtolower($extension), $allowedExts)
    ) {
        if ($_FILES[$key]["error"] > 0) {
            //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
            exit();
        } else {
            $name = $vars['portalName'] . '_' . rand(0, 1000000) . '.png';
            file_put_contents('../../upload/community-logo/' . $name, file_get_contents($_FILES[$key]["tmp_name"]));
            @unlink($_FILES[$key]["tmp_name"]);
            $vars['logo'] = $name;
        }
    } else {
        //header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
        exit();
    }
} else {
    $vars['logo'] = $community->logo;
}

$community->edit($vars);
$community->updateDB();


$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-edit',
    'content' => 'Successfully updated the community: ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName);

?>
