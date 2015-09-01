<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);


foreach($_POST as $key => $value){
    $vars2[$key] = filter_var($value,FILTER_SANITIZE_STRING);
}

if(isset($vars2['facet-column'])&&$vars2['facet-column']!='')
    $vars['facet'] = '&facet='.rawurlencode($vars2['facet-column']).':'.rawurlencode($vars2['facet-value']);

if(isset($vars2['filter-column'])&&$vars2['filter-column']!='')
    $vars['filter'] = '&filter='.rawurlencode($vars2['filter-column']).':'.rawurlencode($vars2['filter-value']);

$category = new Category();
$category->getByID($id);
$category->source = $vars2['source'];
$category->facet = $vars['facet'];
$category->filter = $vars['filter'];
$category->updateDB();

$community = new Community();
$community->getByID($category->cid);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-source-edit',
    'content' => 'Successfully updated the source from : ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName.'/sources');

?>
