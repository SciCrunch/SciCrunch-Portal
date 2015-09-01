<?php
$resource = new Resource();
if(isset($vars['use']) && $vars['use']=='original_id') {
    $resource->getByOriginal($id);
    if(!$resource->id)
        $resource->getByName(str_replace('_',' ',$id));
} else
    $resource->getByRID($id);
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

$baseURL = '/browse/resources/';

include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/resource-view.php';

