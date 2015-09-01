<?php

include 'vars/dataSource.php';

$community = new Community();
$community->getByPortalName($arg1);
$community->getCategories();

$holder = new Component();
$components = $holder->getByCommunity($community->id);

//print_r($community);

?>
<style>
    .service-block-default {
        cursor: pointer;
    }
</style>

<?php
if($community->id==0)
    echo Connection::createBreadCrumbs('Component Select',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=appearance'),'Components');
else
    echo Connection::createBreadCrumbs('Component Select',array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=appearance'),'Components');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <?php
            if($community->id==0)
                echo Connection::createProfileTabs(2,$profileBase.'account/scicrunch',null);
            else
                echo Connection::createProfileTabs(2,$profileBase.'account/communities/'.$community->portalName,$profileBase);
            ?>

            <div class="row margin-bottom-10">
                <div class="col-md-12">
                    <h1>Select Section</h1>

                    <p>
                        From here you can edit the components used in your community. You can select, reorder, and style
                        the
                        components used on your community home page.
                    </p>
                </div>
            </div>

            <div class="row margin-bottom-10">
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/components/header">
                        <div class="service-block service-block-default">
                            <i class="icon-custom icon-color-dark rounded-x fa fa-archive"></i>

                            <h2 class="heading-md">Header</h2>

                            <p>The Navigation, breadcrumbs, and search bar on the search page.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/components/body">
                        <div class="service-block service-block-default">
                            <i class="icon-custom icon-color-dark rounded-x fa fa-list-alt"></i>

                            <h2 class="heading-md">Body</h2>

                            <p>Selecting, reordering, and styling the sections on the home page.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-12">
                    <a href="<?php echo $profileBase?>account/communities/<?php echo $community->portalName ?>/components/footer">
                        <div class="service-block service-block-default">
                            <i class="icon-custom icon-color-dark rounded-x fa fa-sort-amount-asc"></i>

                            <h2 class="heading-md">Footer</h2>

                            <p>Selecting, editing, and styling the footer across all pages.</p>
                        </div>
                    </a>
                </div>
            </div>

            <!--End Profile Body-->
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->
<!--=== End Profile ===-->