<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// code to autoinsert a "Challenge" component after the challenge container is created ...

$component = new Component();

$challenge_vars['uid'] = $_SESSION['user']->id;
$challenge_vars['cid'] = $cid;

$challenge_vars['component'] = $component->getMaxComponentID() + 1;
$challenge_vars['icon1'] = 'challenge1';
$challenge_vars['position'] = -1;
$component->shiftAllPages($challenge_vars['position'], $cid, 1);
$challenge_vars['position'] += 1;

$challenge_vars['text1'] = $vars['title'];
$challenge_vars['text2'] = $vars['link'];
$challenge_vars['text3'] = $vars['content'];

$component->create($challenge_vars);
$component->insertDB();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $cid,
    'timed' => 0,
    'start' => time(),
    'end' => time(),
    'type' => 'add-container-content',
    'content' => 'Successfully added ' . $vars['title']
));

$notification->insertDB();
$_SESSION['user']->last_check = time();

?>