<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if(count($_POST)==0){
    $previousPage = $_SERVER['HTTP_REFERER'];
    $splits = explode('/edit', $previousPage);
    if (count($splits) > 1) {
        $edit = explode('/edit', $previousPage);
        header('location:' . $edit[0]);
    } else {
        header('location:' . $previousPage);
    }
    exit();
}

$rid = filter_var($_GET['rid'], FILTER_SANITIZE_STRING);
$var['cid'] = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);

foreach ($_POST as $key => $value) {
    if ($key == 'g-recaptcha-response') {
        $capcha = $value;
    } elseif($key=='email'){
        $ver['email'] = filter_var($value,FILTER_SANITIZE_EMAIL);
    } elseif($key=='index_status'){
        $status = filter_var($value,FILTER_SANITIZE_STRING);
    } else {
        $splits = explode('-', $key);
        if (count($splits) > 1) {
            $vars[str_replace('_', ' ', $splits[0])][1] = $value;
        } else {
            $vars[str_replace('_', ' ', $key)][0] = filter_var($value, FILTER_SANITIZE_STRING);
        }
    }
}

$file_key = 'resource-image';
if(isset($_FILES[$file_key])){
    if ($_FILES[$file_key] && $_FILES[$file_key]['error'] != 4) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES[$file_key]["name"]));
        if (($_FILES[$file_key]["size"] < 5000000)&& in_array(strtolower($extension), $allowedExts)) {
            if ($_FILES[$file_key]["error"] > 0) {
                //header('location:http://scicrunch.com/finish?status=fileerror&type=community&title=' . $name . '&community=' . $portalName);
                exit();
            } else {
                $name = rand(0,1000000).'.png';
                $counter = 0;
                while(file_exists("../../upload/resource-images/" . $name)){
                    if($counter > 10000000) throw new Exception("unable to save file");
                    $name = rand(0,10000000) . '.png';
                    $counter += 1;
                }
                file_put_contents('../../upload/resource-images/'.$name, file_get_contents($_FILES[$file_key]["tmp_name"]));
                @unlink($_FILES[$key]["tmp_name"]);
                $vars['image'] = Array($name, "");
            }
        } else {
            //header('location:http://scicrunch.com/finish?status=filetype&type=community&title=' . $name . '&community=' . $portalName);
            exit();
        }
    }
}

if (isset($capcha)) {
    $file = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=recaptcha_secret_key&response=' . $capcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
    $json = json_decode($file);
    //print_r($json);
    if ($json->success == false) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        $splits = explode('/about/registry', $previousPage);
        if (count($splits) > 1) {
            $edit = explode('/edit', $previousPage);
            header('location:' . $edit[0]);
        } else {
            header('location:' . $previousPage);
        }
        exit();
    }
}

$resource = new Resource();
$resource->getByRID($rid);

if(isset($vars['image'])){
    $old_image = '../../upload/resource-images/' . $resource->columns['image'];
    if(file_exists($old_image)) unlink($old_image);
}

if (!isset($_SESSION['user'])) {
    $ver['uid'] = 0;
} else {
    $ver['uid'] = $_SESSION['user']->id;
}


$resource->createVersion($ver);
$resource->columns = $vars;
$resource->insertColumns2();

if (isset($_SESSION['user'])) {
    if($_SESSION['user']->role>0 || ($resource->cid!=0 && $_SESSION['user']->levels[$resource->cid]>1)){
        $newVer = $resource->getLatestVersionNum();
        $resource->updateVersion($newVer);
        $resource->updateStatus($status);
    }
    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $resource->cid,
        'timed' => 0,
        'start' => time(),
        'end' => time(),
        'type' => 'resource-update',
        'content' => 'Successfully updated resource: ' . $resource->rid
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

$previousPage = $_SERVER['HTTP_REFERER'];
$splits = explode('/edit', $previousPage);
if (count($splits) > 1) {
    $edit = explode('/edit', $previousPage);
    header('location:' . $edit[0]);
} else {
    header('location:' . $previousPage);
}

?>
