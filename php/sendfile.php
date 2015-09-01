<?php

session_start();
if (!isset($_SESSION['user'])) {
    exit();
}

if ($_FILES['file']['name']) {
	if (!$_FILES['file']['error']) {
		$name = md5(rand(100, 200));
		$ext = explode('.', $_FILES['file']['name']);
		$filename = $ext[0] . "_" . substr($name, 0, 16) . '.' . $ext[1];
		$destination = getcwd() . '/../upload/community-components/' . $filename; //change this directory
		$location = $_FILES["file"]["tmp_name"];
		move_uploaded_file($location, $destination);
		echo '/upload/community-components/' . $filename;//change this URL
	}
	else
	{
	  echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
	}
}
?>        
