<?php


//print_r($community);
if(!$section){
    $section = 'information';
}

$holder = new Component();
$components = $holder->getByCommunity(0);

$holder = new Component_Data();
$releases = $holder->getByComponentNewest(102, 0, 0, 5);
$blogs = $holder->getByComponentNewest(103, 0, 0, 5);
$questions = $holder->getByComponentNewest(104, 0, 0, 5);
$tutorials = $holder->getByComponentNewest(105, 0, 0, 5);


?>
<?php
echo Connection::createBreadCrumbs('Manage SciCrunch',array('Home','Account'),array($profileBase,$profileBase.'account'),'Manage SciCrunch');
?>
<div class="profile container content">
<div class="row">
<!--Left Sidebar-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
<!--End Left Sidebar-->

<div class="col-md-9">
<!--Profile Body-->
<div class="profile-body">
<div class="tab-v1">
<ul class="nav nav-tabs margin-bottom-20">
    <li class="page1-tab <?php if($section=='information') echo 'active'?>"><a href="#information" data-toggle="tab">Information</a></li>
    <li class="page2-tab <?php if($section=='content') echo 'active'?>"><a href="#content" data-toggle="tab">Content</a></li>
    <li class="page2-tab <?php if($section=='appearance') echo 'active'?>"><a href="#appearance" data-toggle="tab">Appearance</a></li>
    <li class="final-tab <?php if($section=='resources') echo 'active'?>"><a href="#resources" data-toggle="tab">Resources</a></li>
</ul>
<div class="tab-content">
<!-- Datepicker Forms -->

    <?php include 'tabs/information.php';?>
    <?php include 'tabs/content.php';?>
    <?php include 'tabs/resources.php';?>
    <?php include 'tabs/appearance.php';?>


</div>
</div>
</div>
<!--End Table Search v2-->
</div>
<!--End Profile Body-->
</div>
</div>
<!--/end row-->
</div><!--/container-->
<!--=== End Profile ===-->