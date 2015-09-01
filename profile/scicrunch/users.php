<?php

if(!$query)
    $query = '';

if(!$currPage)
    $currPage = 1;

$holder = new User();
$users = $holder->getUsersQuery($query, ($currPage - 1) * 20, 20);

?>
<?php
    echo Connection::createBreadCrumbs('SciCrunch Users',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=information'),'SciCrunch Users');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <?php echo Connection::createProfileTabs(0,$profileBase.'account/scicrunch'); ?>
                <form method="get" action="<?php echo $profileBase?>account/scicrunch/users" _lpchecked="1">
                    <div class="input-group margin-bottom-20">
                        <input type="text" class="form-control user-find" name="query" placeholder="Search for Users" value="<?php echo $query?>">
                        <div class="autocomplete_append auto" style="z-index:10"></div>
                                    <span class="input-group-btn">
                                        <button class="btn-u" type="submit">Go</button>
                                    </span>
                    </div>
                </form>
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="hidden-sm">Email</th>
                                <th>Join Date</th>
                                <th>Level</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $levels = array('User', 'Curator', 'Moderator', 'Administrator');
                            $level_class = array('label-success', 'label-info', 'label-warning', 'label-danger');
                            foreach ($users['results'] as $user) {
                                echo '<td>' . $user->getFullName() . '</td>';
                                echo '<td>' . $user->email . '</td>';
                                echo '<td>'.date('h:ia F j, Y', $user->created).'</td>';
                                echo '<td><span class="label ' . $level_class[$user->role] . '">' . $levels[$user->role] . '</span></td>';
                                echo '<td>';
                                if ($_SESSION['user']->role > $user->role) {
                                    ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn-u btn-u-purple dropdown-toggle"
                                                data-toggle="dropdown">
                                            Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="left:auto;right:0">
                                            <li><a href="javascript:void(0)" level="<?php echo $user->role ?>"
                                                   class="user-edit" uid="<?php echo $user->id ?>"
                                                   user="<?php echo $user->getFullName(); ?>"><i
                                                        class="fa fa-wrench"></i> Edit
                                                    Permissions</a></li>
                                            <li>
                                                <a href="/forms/scicrunch-forms/user-delete.php?uid=<?php echo $user->id ?>"><i
                                                        class="fa fa-times"></i> Remove User</a></li>
                                        </ul>
                                    </div>
                                <?php
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="text-left">
                            <?php
                            echo '<ul class="pagination">';

                            $params = 'query=' . $query;
                            $max = ceil($users['count'] / 20);

                            if ($currPage > 1)
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=' . ($currPage - 1) . '&' . $params . '">«</a></li>';
                            else
                                echo '<li><a href="javascript:void(0)">«</a></li>';

                            if ($currPage - 3 > 0) {
                                $start = $currPage - 3;
                            } else
                                $start = 1;
                            if ($currPage + 3 < $max) {
                                $end = $currPage + 3;
                            } else
                                $end = $max;

                            if ($start > 2) {
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=1&' . $params . '">1</a></li>';
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=2&' . $params . '">2</a></li>';
                                echo '<li><a href="javascript:void(0)">..</a></li>';
                            }

                            for ($i = $start; $i <= $end; $i++) {
                                if ($i == $currPage) {
                                    echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
                                } else {
                                    echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=' . $i . '&' . $params . '">' . number_format($i) . '</a></li>';
                                }
                            }

                            if ($end < $max - 3) {
                                echo '<li><a href="javascript:void(0)">..</a></li>';
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=' . ($max - 1) . '&' . $params . '">' . number_format($max - 1) . '</a></li>';
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=' . $max . '&' . $params . '">' . number_format($max) . '</a></li>';
                            }

                            if ($currPage < $max)
                                echo '<li><a href="'.$profileBase.'account/scicrunch/users?currPage=' . ($currPage + 1) . '&' . $params . '">»</a></li>';
                            else
                                echo '<li><a href="javascript:void(0)">»</a></li>';


                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Table Search v2-->
    </div>
    <!--End Profile Body-->
</div>
<!--=== End Profile ===-->
<div class="background"></div>
<div class="back-hide user-edit-container no-padding">
    <div class="close dark less-right">X</div>
    <form action="/forms/scicrunch-forms/user-edit.php" method="post"
          class="sky-form create-form" enctype="multipart/form-data">

        <fieldset>
            <section>
                <label class="label">User</label>
                <div class="theName"></div>
                <input name="uid" type="hidden" class="uid"/>
            </section>
            <section>
                <label class="label">User Level</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="level" class="edit-level">
                        <?php
                        for($i=0;$i<3;$i++){
                            if($_SESSION['user']->role>=$i)
                                echo '<option value="'.$i.'">'.$levels[$i].'</option>';
                        }
                        ?>
                    </select>
                </label>
            </section>
        </fieldset>
        <footer>
            <button class="btn-u btn-u-default" type="submit">Edit User</button>
        </footer>
    </form>
</div>