<?php

include('../classes/classes.php');
session_start();

error_reporting(0);
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$join = $_GET['join'];

foreach ($_POST as $key => $value) {
    $vars[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$cid = $_GET['cid'];

$user_check = new User();

if ($vars['password'] == $vars['password2'] && strlen($vars['password']) >= 6 && !$user_check->emailExists($vars['email'])) {
    $user = new User();
    $user->create($vars);
    $user->insertIntoDB();
    $_SESSION['nonuser'] = $user;

    $previousPage = $_SERVER['HTTP_REFERER'];
    if ($join) {
        $community = new Community();
        $community->getByID($cid);
        if ($community->id) {
            $community->join($user->id, $user->getFullName(), 1);
            $user->levels[$community->id] = 1;
            $notification = new Notification();
            $notification->create(array(
                'sender' => 0,
                'receiver' => $user->id,
                'view' => 0,
                'cid' => $community->id,
                'timed'=>0,
                'start'=>time(),
                'end'=>time(),
                'type' => 'join-community',
                'content' => 'Successfully joined the community: '.$community->portalName
            ));
            $notification->insertDB();
            // $_SESSION['user']->last_check = time();
        }
    }

    $user->sendVerifyEmail();
}

//print_r($user);
//if ($cid && $join)
//    header('location:/' . $community->portalName);
//else
//    header('location:/');
header('location:/verification?type=new');
?>
