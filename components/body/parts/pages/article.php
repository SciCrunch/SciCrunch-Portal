<?php


$baseURL = '/'.$community->portalName.'/about/';
$searchURL = '/'.$community->portalName.'/about/search';
switch($thisComp->icon1){
    case "files1":
        include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/table-display.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/article-view.php';
        break;
}

?>
