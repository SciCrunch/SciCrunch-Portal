<?php

$holder = new Saved();
$searches = $holder->getUserSearches($_SESSION['user']->id);

?>
<?php
echo Connection::createBreadCrumbs('My Saved Searches', array('Home', 'Account'), array($profileBase, $profileBase . 'account'), 'My Saved Searches');
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
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Community</th>
                                <th>Category</th>
                                <th>Query</th>
                                <th>Insert Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $commArray = array();
                            foreach ($searches as $saved) {
                                if (!isset($commArray[$saved->cid])) {
                                    $comm = new Community();
                                    $comm->getByID($saved->cid);
                                    $commArray[$saved->cid] = $comm;
                                } else {
                                    $comm = $commArray[$saved->cid];
                                }
                                echo '<tr>';
                                echo '<td><a href="' . $saved->returnURL() . '">' . $saved->name . '</></td>';
                                echo '<td>';
                                echo $comm->shortName;
                                echo '</td>';
                                echo '<td>' . $saved->category . '</td>';
                                if ($saved->display && $saved->display != '')
                                    echo '<td>' . $saved->display . '</td>';
                                else
                                    echo '<td>' . $saved->query . '</td>';
                                echo '<td>' . date('h:ia F j, Y', $saved->time) . '</td>';
                                echo '<td>';
                                echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                echo '<li><a href="' . $saved->returnURL() . '"><i class="fa fa-external-link"></i> Goto</a></li>';
                                echo '<li><a href="javascript:void(0)" saved="' . $saved->id . '" saveName="' . $saved->name . '" class="saved-edit"><i class="fa fa-cogs"></i> Rename</a></li>';
                                echo '<li><a href="/forms/other-forms/delete-saved-search.php?id=' . $saved->id . '"><i class="fa fa-times"></i> Delete</a></li>
                                        </ul>
                                    </div>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            ?>

                            </tbody>
                        </table>
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
<div class="background"></div>
<div class="saved-this-search back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post" action="/forms/other-forms/edit-saved-search.php"
          id="header-component-form" class="sky-form" enctype="multipart/form-data">
        <header>Rename This Saved Search</header>
        <fieldset>
            <section>
                <label class="label">Name</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="hidden" name="id" class="saved-id-input"/>
                    <input type="text" name="name" class="saved-name-input" placeholder="Focus to view the tooltip">
                    <b class="tooltip tooltip-top-right">The name of your saved search.</b>
                </label>
            </section>
        </fieldset>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Rename</button>
        </footer>
    </form>
</div>