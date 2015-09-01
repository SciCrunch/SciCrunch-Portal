<?php

include '../classes/classes.php';

$parent = filter_var($_GET['parent'],FILTER_SANITIZE_STRING);
$name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'],FILTER_SANITIZE_NUMBER_INT);

$invalidCategories = array(
    'data','literature','about','pages','any','register'
);

$category = new Category();
if($category->checkName($name,$parent,$cid) || in_array($name,$invalidCategories)){
    echo '0';
} else {
    echo '1';
}
?>