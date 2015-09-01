<?php

include '../classes/classes.php';

$name = filter_var($_GET['name'],FILTER_SANITIZE_EMAIL);
$user = new User();
$user->getByEmail($name);

if($user->id){
    echo '0';
} else {
    echo '1';
}

?>