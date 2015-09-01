<?php
include ('../classes/classes.php');
session_start();

$previousPage = $_SERVER['HTTP_REFERER'];

$_SESSION['user']->log('logout');

session_unset();
session_destroy();

header('location:'.$previousPage);
?>
