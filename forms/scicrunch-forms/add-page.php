<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

foreach ($_POST as $key => $value) {
    if ($key == 'content'){
        $vars[$key] = $value;
    } else
        $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$page = new Page();
$pages = $page->getPages(0);

$vars['uid'] = $_SESSION['user']->id;
$vars['cid'] = 0;
$vars['position'] = count($pages);

$page->create($vars);
$page->insertDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'add-scicrunch-page',
    'content' => 'Successfully added the page ' . $page->title
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/scicrunch');

?>