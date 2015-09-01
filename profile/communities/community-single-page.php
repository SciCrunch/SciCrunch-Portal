<?php

$holder = new Sources();
$sources = $holder->getAllSources();

$community = new Community();
$community->getByPortalName($arg1);
$community->getCategories();

if(!$section){
    $section = 'information';
}

$holder = new Component();
$components = $holder->getByCommunity($community->id);


$holder = new Component_Data();
$releases = $holder->getByComponent(102, $community->id, 0, 5);
$blogs = $holder->getByComponent(103, $community->id, 0, 5);
$questions = $holder->getByComponentNewest(104, $community->id, 0, 5);
$tutorials = $holder->getByComponentNewest(105, $community->id, 0, 5);

//print_r($community);

?>
<?php
echo Connection::createBreadCrumbs($community->name,array('Home','Account','Communities'),array($profileBase,$profileBase.'account',$profileBase.'account/communities'),$community->shortName);
?>

<div class="profile container content">
<div class="row">
<!--Left Sidebar-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
<!--End Left Sidebar-->

<div class="col-md-9">
<!--Profile Body-->
<div class="profile-body">
<!--Service Block v3-->

<div class="tab-v1">
<ul class="nav nav-tabs margin-bottom-20 tut-nav">
    <li class="page1-tab <?php if($section=='information') echo 'active'?> tut-info"><a href="#information" data-toggle="tab">Information</a></li>
    <li class="page2-tab <?php if($section=='content') echo 'active'?> tut-content"><a href="#content" data-toggle="tab">Content</a></li>
    <li class="page2-tab <?php if($section=='appearance') echo 'active'?> tut-appear"><a href="#appearance" data-toggle="tab">Appearance</a></li>
    <li class="final-tab <?php if($section=='resources') echo 'active'?> tut-resource"><a href="#resources" data-toggle="tab">Resources</a></li>
    <li class="pull-right"><a href="/<?php echo $community->portalName?>"><i class="fa fa-share"></i> Goto Community</a></li>
</ul>
<div class="tab-content">
<!-- Datepicker Forms -->
<?php include 'tabs/information.php';?>

<?php include 'tabs/appearance.php';?>

<?php include 'tabs/content.php';?>
    <?php include 'tabs/resources.php';?>
<!--End Table Search v2-->
</div>
</div>
</div>
</div>
<!--End Profile Body-->
</div>
<!--/end row-->
</div>
<!--/container-->
<!--=== End Profile ===-->

<ol id="joyRideTipContent">
    <li data-class="tut-title" data-text="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2><?php echo $community->name?> Admin Page</h2>
        <p>
            Welcome to your community administration page. From here you'll update all your community information,
            the look, and what sources you search through. If you want to view your community <a href="/<?php echo $community->portalName?>">click here</a>.
            Else click next to learn more about the admin page.
        </p>
    </li>
    <li data-class="tut-myaccount" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Getting Here</h2>
        <p>
            When you are logged in, you can get here from under this tab. The Communities Tab contains all your
            community admin pages, while being on your community you will get an option to come straight here
            for that community.
        </p>
    </li>
    <li data-class="tut-nav" data-button="Next" data-options="tipLocation:left;tipAnimation:fade">
        <h2>Admin Tabs</h2>
        <p>
            In your community administration page the options you have are organized under 4 tabs to keep everything
            organized. Clicking on a tab will switch to the appropriate content.
        </p>
    </li>
    <li data-class="tut-info" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Information</h2>
        <p>
            Under the information tab you'll have the options to change the basic information like the name or logo and
            be able to change the sources you search through in your community. User management also happens here.
        </p>
    </li>
    <li data-class="tut-content" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Content</h2>
        <p>
            Content is your manager for adding new pages to your community. You'll add tutorials, news, static pages
            and manage questions from here.
        </p>
    </li>
    <li data-class="tut-appear" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Appearance</h2>
        <p>
            Appearance is where you'll manage the look of your community from the header to the homepage body. Here you
            can change the look of the components as well as add data to the homepage components.
        </p>
    </li>
    <li data-class="tut-resource" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Resources</h2>
        <p>
            Resources is the management of adding resources from your community. You have complete control over the
            forms that your user uses to submit the resources and editing the resources that come from your community.
        </p>
    </li>
    <li data-class="tut-cog" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Editing</h2>
        <p>
            Clicking on these cogs will initiate editing of that section. Clicking here will change the basic information
            of your community <b>including making it public.</b>
        </p>
    </li>
    <li data-class="tut-title" data-button="Done" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Thank you</h2>
        <p>
            Thank you for creating a SciCrunch Community, if you have any further questions please check out our
            <a href="/faq">FAQs Page</a> to ask questions and see our tutorials.
        </p>
    </li>
</ol>