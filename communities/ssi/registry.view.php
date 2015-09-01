<?php
$resource = new Resource();
$resource->getByRID($vars['id']);
if ($vars['article']) {
    $version = $vars['article'];
} else {
    $version = $resource->getLatestVersionNum();
}
$resource->getVersionColumns($version);

$columns = $resource->columns;

$type = new Resource_Type();
$type->getByID($resource->typeID);

$holder = new Resource_Fields();
$fields = $holder->getByType($type->id, $resource->cid);

$baseURL = '/'.$community->portalName.'/about/registry/';

echo '<div class="container s-results margin-bottom-50">
        <div class="row">';

include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/resource-view.php';
echo '</div></div>';

