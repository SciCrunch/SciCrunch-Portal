<?php

include '../../classes/classes.php';
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['user'])) {
    header('location:/');
    exit();
}

$type = filter_var($_GET['type'],FILTER_SANITIZE_STRING);

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);
$community = new Community();
$community->getByID($cid);

$vars['uid'] = $_SESSION['user']->id;
$vars['cid'] = $cid;

foreach($_POST as $key => $value){
    $vars[$key] = filter_var($value,FILTER_SANITIZE_STRING);
}

if(isset($vars['facet-column'])&&$vars['facet-column']!='')
    $vars['facet'] = '&facet='.rawurlencode($vars['facet-column']).':'.rawurlencode($vars['facet-value']);

if(isset($vars['filter-column'])&&$vars['filter-column']!='')
    $vars['filter'] = '&facet='.rawurlencode($vars['filter-column']).':'.rawurlencode($vars['filter-value']);

$category = new Category();
$category->create($vars);

if($type=='category')
    $category->shiftAll('x',1,true);
elseif($type == 'subcategory')
    $category->shiftAll('y',1,true);
elseif($type == 'source')
    $category->shiftAll('z',1,true);

$category->insertDB();


$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'community-'.$type.'-add',
    'content' => 'Successfully added the '.$type.' to : ' . $community->name
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:/account/communities/' . $community->portalName.'/sources');

?>