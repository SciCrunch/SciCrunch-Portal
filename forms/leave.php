<?php


include('../classes/classes.php');
session_start();

$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

if(isset($_SESSION['user'])){
    $_SESSION['user']->levels[$cid] = 0;
}


$previousPage = $_SERVER['HTTP_REFERER'];
header('location:'.$previousPage);

?>