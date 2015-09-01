<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left"><?php echo $data->title ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/page/<?php echo $component->text1?>"><?php echo $component->text1?></a></li>
            <li class="active"><?php echo $data->title ?></li>
        </ul>
    </div>
</div>
<?php

$thisComp = $component;
$baseURL = '/page/';
$searchURL = '/browse/content';

switch($thisComp->icon1){
    case "files1":
        include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/table-display.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'] . '/components/body/parts/pages/article-view.php';
        break;
}

?>