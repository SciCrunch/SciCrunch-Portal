<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role<1)){
    header('location:/');
    exit();
}

foreach($_POST as $key=>$value){
    $vars[$key] = filter_var($value,FILTER_SANITIZE_STRING);
}

$community = new Community();
$community->getByID($cid);

$holder = new Component();
$components = $holder->getByCommunity($cid);

$header = $components['header'][0];
$search = $components['search'][0];
$breadcrumbs = $components['breadcrumbs'][0];

// Header Update

if($vars['header-select']=='boxed'){
    $header->component = 1;
} elseif($vars['header-select']=='float'){
    $header->component = 2;
} elseif($vars['header-select']=='flat'){
    $header->component = 3;
} else {
    $header->component = 0;
}
$header->color1 = $vars['header-color1'];

if($vars['logosize'] == 'on'){	// logo size style is stored in header->icon1
    $header->icon1 = 'large';
} else{
    $header->icon1 = 'normal';
}

$header->updateDB();

// Search Update

if($vars['search-toggle']){
    $search->disabled = 0;
} else {
    $search->disabled = 1;
}

$search->text1 = $vars['search-text1'];
$search->text2 = $vars['search-text2'];
$search->color1 = $vars['search-color1'];
$search->color2 = $vars['search-color2'];

$search->updateDB();

// Breadcrumbs

if($vars['breadcrumbs-toggle']){
    $breadcrumbs->disabled = 0;
} else {
    $breadcrumbs->disabled = 1;
}

if ($_FILES['breadcrumbs-image'] && $_FILES['breadcrumbs-image']['error']!=4) {
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $extension = end(explode(".", $_FILES["breadcrumbs-image"]["name"]));
    if ((($_FILES["breadcrumbs-image"]["type"] == "image/gif")
            || ($_FILES["breadcrumbs-image"]["type"] == "image/jpeg")
            || ($_FILES["breadcrumbs-image"]["type"] == "image/png")
            || ($_FILES["breadcrumbs-image"]["type"] == "image/pjpeg"))
        && ($_FILES["breadcrumbs-image"]["size"] < 500000)
        && in_array($extension, $allowedExts)) {
        if ($_FILES["breadcrumbs-image"]["error"] > 0) {
            //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
            exit();
        } else {
            move_uploaded_file($_FILES["breadcrumbs-image"]["tmp_name"], "../../upload/community_components/" . $community->portalName."_".$breadcrumbs->id . ".png");
            $breadcrumbs->image = $community->portalName."_".$breadcrumbs->id . '.png';
        }
    } else {
        //header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
        exit();
    }
}


$breadcrumbs->color3 = $vars['breadcrumbs-color3'];
$breadcrumbs->color1 = $vars['breadcrumbs-color1'];
$breadcrumbs->color2 = $vars['breadcrumbs-color2'];

$breadcrumbs->updateDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $community->id,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type'=>'update-header-components',
    'content'=>'Successfully updated the header components for '.$community->shortName
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>
