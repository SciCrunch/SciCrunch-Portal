<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../../classes/classes.php';
session_start();

	if (isset($_POST['isAnonymous']))
		$anonymous = 1;
	else 
		$anonymous = 0;
		
	$challenge = new Challenge;
	$vars['anonymous'] = $anonymous;
	$vars['uid'] = $_POST['uid'];
	$vars['component'] = $_POST['component'];
	$vars['date'] = time();

	$challenge->create($vars);

 	$challenge->insertChallengeDB();
 	
echo "Your registration data has been received.";
?>
