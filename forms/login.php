<?php

include('../classes/classes.php');
session_start();
$join = $_GET['join'];
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$cid = $_GET['cid'];


if (!$_SESSION['user']) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $user = new User();
    $user->login($email, $password);
    if ($user->id && $user->verified == 0){
        $_SESSION['nonuser'] = $user;
        header("location:/verification?type=sent");
        exit;
    }
    elseif ($user->id) {
        $_SESSION['user'] = $user;
        $_SESSION['user']->last_check = $_SESSION['user']->updateOnline();
        $_SESSION['user']->last_check = time();
        $_SESSION['user']->onlineUsers = $user->getOnlineUsers();
    } else {
        $error = new Error();
        $error->create(array(
            'type' => 'login-fail',
            'message' => 'That email/password combination does not exist, please try again.'
        ));
        $error->insertDB();

        $previousPage = $_SERVER['HTTP_REFERER'];
        $ques = explode('?',$previousPage);
        if(count($ques)>1){
            header('location:' . $previousPage.'&errorID='.$error->id);
        } else {
            header('location:' . $previousPage.'?errorID='.$error->id);
        }
        exit();
    }
}

if ($join && (!$_SESSION['user']->levels[$cid] || $_SESSION['user']->levels[$cid] == 0)) {
    $community = new Community();
    $community->getByID($cid);
    if ($community->id) {
        $community->join($_SESSION['user']->id, $_SESSION['user']->getFullName(), 1);
        $_SESSION['user']->levels[$community->id] = 1;
        $notification = new Notification();
        $notification->create(array(
            'sender' => 0,
            'receiver' => $_SESSION['user']->id,
            'view' => 0,
            'cid' => $community->id,
            'timed'=>0,
            'start'=>time(),
            'end'=>time(),
            'type' => 'join-community',
            'content' => 'Successfully joined the community: ' . $community->portalName
        ));
        $notification->insertDB();
        $_SESSION['user']->last_check = time();
    }
}

//print_r($user);
$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);
?>
