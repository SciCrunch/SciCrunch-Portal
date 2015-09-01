
<?php
echo Connection::createBreadCrumbs('My Communities',array('Home','Account'),array($profileBase,$profileBase.'account'),'My Communities');
?>

<div class="profile container content">
<div class="row">
<!--Left Sidebar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/profile/left-column.php'; ?>
<!--End Left Sidebar-->

<div class="col-md-9">
<!--Profile Body-->
<div class="profile-body">
<!--Service Block v3-->


<!--Table Search v2-->
<div class="table-search-v2 margin-bottom-20">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Logo</th>
                <th class="hidden-sm">Community</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $levels = array('','User','Moderator','Administrator','Owner');
            $level_class = array('','label-success','label-info','label-warning','label-danger');
            foreach($_SESSION['user']->levels as $cid=>$level){
                if($level==0)
                    continue;
                $community = new Community();
                $community->getByID($cid);
                echo '<tr>';
                echo '<td><img class="rounded-x" src="/upload/community-logo/'.$community->logo.'"/></td>';
                echo '<td class="td-width">';
                echo '<h3><a href="/'.$community->portalName.'">'.$community->name.'</a></h3>';
                echo '<p>'.$community->description.'</p>';
                echo '</td>';
                echo '<td><span class="label '.$level_class[$level].'">'.$levels[$level].'</span></td>';
                echo '<td><a href="/'.$community->portalName.'"><i class="fa fa-external-link" style="font-size: 16px;margin-right: 10px"></i></a><a href="'.$profileBase.'account/communities/'.$community->portalName.'"><i class="fa fa-cog" style="font-size: 20px;margin-right: 10px"></i></a></td>';
                echo '</tr>';
            }

            ?>

            </tbody>
        </table>
    </div>
</div>
<!--End Table Search v2-->
</div>
<!--End Profile Body-->
</div>
</div><!--/end row-->
</div><!--/container-->
<!--=== End Profile ===-->