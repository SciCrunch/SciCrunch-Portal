<?php

include '../classes/classes.php';

$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

$data = new Component_Data();
$data->getByID($id);
$data->addView();

?>