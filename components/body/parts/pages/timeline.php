
<?php
$holder = new Component_Data();
if (($thisComp->icon1 == 'event1') || ($thisComp->icon1 == 'series1') || ($thisComp->icon1 == 'challenge1')) {
    $datas = $holder->orderTime($thisComp->component,$community->id);
} elseif($thisComp->icon1 == "files1"){
    $datas = $holder->getByComponentNewest($thisComp->component, $community->id);
} else {
    $datas = $holder->getByComponentNewest($thisComp->component, $community->id, 0, 10);
}
$count = $holder->getCount($thisComp->component, $community->id);

$searchURL = '/'.$community->portalName.'/about/search';
if ($thisComp->icon1 == 'timeline1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/timeline1.php';
} elseif ($thisComp->icon1 == 'timeline2') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/timeline2.php';
} elseif ($thisComp->icon1 == 'static') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/static.php';
} elseif ($thisComp->icon1 == 'files1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/table.php';
} elseif ($thisComp->icon1 == 'blog1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/blog-view.php';
} elseif ($thisComp->icon1 == 'gallery1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/gallery-view.php';
} elseif ($thisComp->icon1 == 'slideshow1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/slide.share.gallery.php';
} elseif ($thisComp->icon1 == 'contact1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/contact-form.php';
} elseif ($thisComp->icon1 == 'event1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/event-page.php';
} elseif ($thisComp->icon1 == 'table1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/dynamic-table.php';
} elseif ($thisComp->icon1 == 'series1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/series1.php';
} elseif ($thisComp->icon1 == 'challenge1') {
    $baseURL = '/'.$community->portalName.'/about/';
    include $_SERVER['DOCUMENT_ROOT'] .'/components/body/parts/pages/challenge1.php';
}

?>
