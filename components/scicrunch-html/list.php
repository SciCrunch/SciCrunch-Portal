<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left"><?php echo $component->text1 ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><?php echo $component->text1 ?></li>
        </ul>
    </div>
</div>
<!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->


<?php

$holder = new Component_Data();
$datas = $holder->getByComponentNewest($component->component, 0, 0, 10);
$count = $holder->getCount($component->component, 0);

$community = new Community();
$community->id = 0;

$thisComp = $component;
if ($component->icon1 == 'timeline1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/timeline1.php';
} elseif ($component->icon1 == 'timeline2') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/timeline2.php';
} elseif ($component->icon1 == 'static') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/static.php';
} elseif ($component->icon1 == 'files1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/table.php';
} elseif ($thisComp->icon1 == 'blog1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/blog-view.php';
} elseif ($thisComp->icon1 == 'gallery1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/gallery-view.php';
} elseif ($thisComp->icon1 == 'slideshow1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/slide.share.gallery.php';
} elseif ($thisComp->icon1 == 'contact1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/contact-form.php';
} elseif ($thisComp->icon1 == 'event1') {
    $baseURL = '/page/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/event-page.php';
}
?>