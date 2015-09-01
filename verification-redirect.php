<?php
include 'classes/classes.php';
session_start();

if($_SESSION['user']){
    header("Location:/");
    exit;
}

$vars = array();
foreach($_GET as $key => $value){
    $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

if($vars['verstring']){
    $user = new User();
    $user->verifyUser($vars['verstring']);
    $print_message = "Congratulations.  You have verified your account and can now log in.";	// does not doublecheck for success, don't give extra information
}elseif(!isset($_SESSION['nonuser'])){
    $print_message = "If you need to resend your verification email, please log in.";
}elseif($vars['type'] == "new"){
    $print_message = 'A verification email has been sent.  If you did not receive the email please check your spam folder or click <a href="/verification?type=resend">here</a> to resend it.';
}elseif($vars['type'] == "sent"){
    $print_message = 'We cannot log you in until your email has been verified.  Click <a href="/verification?type=resend">here</a> to resend the verification email.</a>';
}elseif($vars['type'] == "resend"){
    $_SESSION['nonuser']->sendVerifyEmail();
    $print_message = "A verification email has been sent.  Please check your inbox (or spam folder).";
}


$tab = 0; $hl_sub = 0; $ol_sub = -1;

$holder = new Component();
$components = $holder->getByCommunity(0);

$community = new Community();
$community->id = 0;

$vars['editmode'] = filter_var($_GET['editmode'],FILTER_SANITIZE_STRING);
if($vars['editmode']){
    if(!isset($_SESSION['user']) || $_SESSION['user']->role<1)
        $vars['editmode'] = false;
}

$vars['errorID'] = filter_var($_GET['errorID'],FILTER_SANITIZE_NUMBER_INT);
if($vars['errorID']){
    $errorID = new Error();                                                                                                                                                                                 
    $errorID->getByID($vars['errorID']);
    if(!$errorID->id){
        $errorID = false;
    }
}

$locationPage = '/';

include $_SERVER['DOCUMENT_ROOT'] . '/verification/verification.php';
?>
