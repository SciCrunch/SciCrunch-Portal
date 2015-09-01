<?php

include '../classes/classes.php';
session_start();
$previousPage = $_SERVER['HTTP_REFERER'];

if(!isset($_SESSION['user'])){
    header('location:/');
    exit();
}

$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
$firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_STRING);
$lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_STRING);
$organization = filter_var($_POST['organization'],FILTER_SANITIZE_STRING);

$user_check = new User();
if($user_check->emailExists($email) && $_SESSION['user']->email != $email){
    header('location:' . $previousPage);
    exit;
}

$_SESSION['user']->email = $email;
$_SESSION['user']->firstname = $firstname;
$_SESSION['user']->lastname = $lastname;
$_SESSION['user']->organization = $organization;

$_SESSION['user']->updateField('email',$email);
$_SESSION['user']->updateField('firstName',$firstname);
$_SESSION['user']->updateField('lastName',$lastname);
$_SESSION['user']->updateField('organization',$organization);

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => 0,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'user-info-update',
    'content' => 'Successfully updated your information'
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

header('location:' . $previousPage);

?>
