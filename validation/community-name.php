<?php

include '../classes/classes.php';

$name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);
$community = new Community();

$invalidCommunities = array(
    'faq','account','browse','create','error','information','versions','news', 'page', 'resolver', 'api'
);
$splitcom = explode('/', $name);
if($community->getByPortalName($name) || in_array($name,$invalidCommunities) || count($splitcom) > 1){
    echo '0';
} else {
    echo '1';
}

?>