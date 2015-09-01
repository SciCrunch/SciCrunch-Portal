<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

if (!isset($_SESSION['user'])) {
    $varsR['uid'] = 0;
} else {
    $varsR['uid'] = $_SESSION['user']->id;
}

$typeID = filter_var($_GET['typeID'], FILTER_SANITIZE_NUMBER_INT);
$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'], FILTER_SANITIZE_STRING);

$community = new Community();
$community->getByID($cid);

foreach ($_POST as $key => $value) {
    //echo $key.':'.$value."\n";
    if ($key == 'g-recaptcha-response') {
        $capcha = $value;
    } elseif ($key == 'email') {
        $varsR['email'] = filter_var($value, FILTER_SANITIZE_EMAIL);
    } else {
        $splits = explode('-', $key);
        if (count($splits) > 1) {
            $vars[str_replace('_', ' ', $splits[0])][1] = filter_var($value, FILTER_SANITIZE_STRING);
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
                    if($counter > 10000000) throw new Exception("error creating image file");
                    $name = rand(0,10000000) .  '.png';
                    $counter += 1;
                }
                file_put_contents('../../upload/resource-images/'.$name, file_get_contents($_FILES[$file_key]["tmp_name"]));
                @unlink($_FILES[$key]["tmp_name"]);
                $vars['image'] = Array($name, '');
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
        echo('Please insert captcha!');
        if ($cid == 0)
            header('location:/create/resource?form=' . $type . '&section=1');
        else
            header('location:/' . $community->portalName . '/about/resource?form=' . $type . '&section=1');
        exit();
    }
}

$varsR['type'] = $type;
$varsR['typeID'] = $typeID;
$varsR['cid'] = $cid;

$holder = new Resource_Fields();
if($typeID!=0) {
    $fields = $holder->getPage2($cid, $typeID);

    foreach ($fields as $field) {
        $vars[$field->name] = array('', '');
    }
}


$resource = new Resource();
$resource->create($varsR);
$resource->insertDB();

$vars['original_id'] = array($resource->original_id, NULL);
$vars['rid'] = array($resource->rid, NULL);
$resource->columns = $vars;
//print_r($resource->columns);
$resource->insertColumns2();

if (isset($_SESSION['user'])) {
    $notification = new Notification();
    $notification->create(array(
        'sender' => 0,
        'receiver' => $_SESSION['user']->id,
        'view' => 0,
        'cid' => $resource->cid,
        'timed' => 0,
        'start' => time(),
        'end' => time(),
        'type' => 'resource-submit',
        'content' => 'Successfully submitted resource: ' . $resource->rid
    ));
    $notification->insertDB();
    $_SESSION['user']->last_check = time();
}

if ($cid == 0)
    header('location:/create/resource?form=' . $type . '&rid=' . $resource->rid . '&section=2');
else
    header('location:/' . $community->portalName . '/about/resource?form=' . $type . '&rid=' . $resource->rid . '&section=2');

?>
