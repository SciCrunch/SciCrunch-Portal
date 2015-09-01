<?php

include '/vars/dataSource.php';

if (!$community) {
    $community = new Community();
    $community->getByPortalName($arg1);
    $community->getCategories();
}

$holder = new Component();
$components = $holder->getByCommunity($community->id);

//print_r($community);

?>
<style>
    .servive-block-default {
        cursor: pointer;
    }

    .panel-dark .panel-heading {
        background: #555;
        color: #fff;
    }
</style>
<?php
if ($community->id == 0)
    echo Connection::createBreadCrumbs('Body Components', array('Home', 'Account', 'Manage SciCrunch', 'Components'), array($profileBase, $profileBase . 'account', $profileBase . 'account/scicrunch?tab=appearance', $profileBase . 'account/scicrunch/components'), 'Body');
else
    echo Connection::createBreadCrumbs('Body Components', array('Home', 'Account', 'Communities', $community->shortName, 'Components'), array($profileBase, $profileBase . 'account', $profileBase . 'account/communities', $profileBase . 'account/communities/' . $community->portalName . '?tab=appearance', $profileBase . 'account/communities/' . $community->portalName . '/components'), 'Body');
?>

<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <?php
            if ($community->id == 0)
                echo Connection::createProfileTabs(2, $profileBase . 'account/scicrunch', null);
            else
                echo Connection::createProfileTabs(2, $profileBase . 'account/communities/' . $community->portalName, $profileBase);
            ?>

            <!--Profile Body-->
            <div class="pull-right" style="margin-bottom:20px;">
                <a class="btn-u btn-u-purple" href="/faq/tutorials/11">View Tutorial</a>
                <button type="button" class="btn-u component-add">Add New Component</button>
            </div>
            <div style="height:60px;">* Images shown here do not reflect changes you have made to the components</div>
            <?php
            $count = 0;
            $total = count($components['body']);
            foreach ($components['body'] as $component) {
                echo '<div class="body-component"><img src="/images/components/component-' . $component->component . '.jpg"/>';
                echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
                echo '<div class="pull-right">';
                if ($count > 0)
                    echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=up"><i class="fa fa-angle-up"></i><span class="button-text"> Shift Up</span></a>';
                if ($count != $total - 1)
                    echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=down"><i class="fa fa-angle-down"></i><span class="button-text"> Shift Down</span></a>';
                echo '<button class="btn-u btn-u-default"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="/forms/component-forms/body-component-delete.php?component=' . $component->id . '&cid=' . $component->cid . '" class="btn-u btn-u-red"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
                echo '</div></div><hr style="margin:10px 0"/>';
                $count++;
            }
            ?>
            <form method="post" action="/forms/component-forms/body-components.php?cid=<?php echo $community->id ?>"
                  id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10" style="margin:0">
                    <?php

                    $total = count($components['body']);
                    $count = 0;
                    foreach ($components['body'] as $component) {
                        echo $component->bodyComponentHTML($total, $count, true, false);
                        $count++;
                    }

                    ?>
                </div>
                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>

            <!--End Profile Body-->
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->

<div class="background"></div>
<div class="component-select-container back-hide">
    <div class="close dark">X</div>
    <div class="selection">
        <h2 align="center">Select a Component to Add</h2>

        <div class="components-select">
            <?php
            $holder = new Component();
            echo $holder->getComponentSelectHTML($community->id);
            ?>
        </div>
    </div>
</div>
<div class="component-add-load back-hide"></div>

<!--=== End Profile ===-->