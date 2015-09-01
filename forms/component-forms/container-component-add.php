<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);

if (!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid] < 2 && $_SESSION['user']->role < 1)) {
    header('location:/');
    exit();
}

$community = new Community();
$community->getByID($cid);

foreach ($_POST as $key => $value) {
    $splits = explode('-', $key);
    $vars[$splits[1]] = $value;
}

if ($type == 'contact1') {
    $url2 = 'https://maps.google.com/maps/api/geocode/xml?address=' . $vars['color1'] . '&sensor=false';
    $xml2 = simplexml_load_file($url2);
    if ($xml2) {
        $lat = $xml2->result->geometry->location->lat;
        $lng = $xml2->result->geometry->location->lng;
        $vars['image'] = $lat . ':' . $lng;
    }
}

$component = new Component();
$vars['uid'] = $_SESSION['user']->id;
$vars['cid'] = $cid;
$vars['component'] = $component->getMaxComponentID() + 1;
$vars['icon1'] = $type;
if (isset($vars['position'])) {
    $component->shiftAllPages($vars['position'], $cid, 1);
    $vars['position'] += 1;
}
$component->create($vars);
$component->insertDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed' => 0,
    'start' => time(),
    'end' => time(),
    'type' => 'add-container-component',
    'content' => 'Successfully added ' . $component->text1 . ' for ' . $community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

if ($community->id == 0)
    header('location:/page/' . $component->text2);
else
    header('location:/' . $community->portalName . '/about/' . $component->text2);

?>