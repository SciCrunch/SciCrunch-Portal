<?php
set_time_limit(0);
$holder = new Sources();
$sources = $holder->getAllSources();
$html = '';
foreach ($sources as $source) {
    $html .= '<tr values="'.strtolower($source->getTitle()).' '.$source->nif.'"><td>' . $source->getTitle() . '</td><td>' . $source->nif . '</td>';
    if ($source->description != '' && $source->description != null)
        $html .= '<td>Yes</td>';
    else
        $html .= '<td>No</td>';
    if ($source->image != '' && $source->image != null && strlen($source->image) > 20)
        $html .= '<td>Yes</td>';
    else
        $html .= '<td>No</td>';

    $html .= '<td>' . date('h:ia n/j', $source->created) . '</td>';
    if ($source->updated)
        $html .= '<td>' . date('h:ia n/j', $source->updated) . '</td>';
    else
        $html .= '<td>N/A</td>';
    $html .= '</tr>';
}

?>
<?php
echo Connection::createBreadCrumbs('Update Sources',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=information'),'Update Sources');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <?php echo Connection::createProfileTabs(0,$profileBase.'account/scicrunch',false); ?>

                <div class="pull-right" style="margin-bottom:20px;">
                    <a type="button" class="btn-u" href="/forms/updateSources.php">Update Sources</a>
                </div>
                <form method="get" class="source-form">
                    <div class="input-group margin-bottom-20">
                        <input type="text" class="form-control source-find" placeholder="Search for Sources"
                               value="<?php echo $query ?>">

                                    <span class="input-group-btn">
                                        <button class="btn-u" type="submit">Go</button>
                                    </span>
                    </div>
                </form>
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover source-table">
                            <thead>
                            <tr class="first">
                                <th>Name</th>
                                <th>View ID</th>
                                <th>Desc</th>
                                <th>Image</th>
                                <th>Insert</th>
                                <th>Update</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo $html;
                            ?>
                            </tbody>
                        </table>

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
                        for ($i = 0; $i < 3; $i++) {
                            if ($_SESSION['user']->role >= $i)
                                echo '<option value="' . $i . '">' . $levels[$i] . '</option>';
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