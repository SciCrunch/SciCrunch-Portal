<?php

include '../classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if(!isset($_SESSION['user'])){
    header('location:/');
    exit();
}

$original = filter_var($_POST['original'],FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
$password2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);

//echo print_r($_SESSION['user']->checkPassword($original));

$notification_str = "Password change was unsuccessful";
if($_SESSION['user']->checkPassword($original)){
    //echo $password.'='.$password2;
    if($password==$password2 && strlen($password) >= 6){
        //echo 'hi';
        $_SESSION['user']->updateField('password',$password);
        $notification_str =  'Successfully updated your password';
    }
}

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'user-password-update',
    'content' => $notification_str
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>
