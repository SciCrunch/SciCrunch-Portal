<?php

include '../classes/classes.php';

$term = filter_var($_GET['term'],FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

$holder = new User();
$users = $holder->findUser($term);

$community = new Community();
$community->getByID($cid);

$users2 = $community->getUsers();
foreach($users2 as $user){
    $commUser[$user['uid']] = true;
}

foreach($users as $user){
    if(!$commUser[$user->id])
        $autocomplete[] = array($user->id,$user->getFullName());
}

echo json_encode($autocomplete);

?>