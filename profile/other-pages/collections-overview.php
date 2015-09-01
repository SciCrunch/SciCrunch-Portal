<?php
echo Connection::createBreadCrumbs('My Collections', array('Home', 'Account'), array($profileBase, $profileBase . 'account'), 'My Collections');
?>
<style>
    .new-collection, .rename-collection,.delete-collection,.transfer-collection {
        position: fixed;
        left: 50%;
        margin-left: -400px;
        top: 20px;
        width: 800px;
        padding: 20px;
        border: 1px solid #666;
        z-index: 991;
        display: none;
        background: #fff;
        max-height: 90%;
        overflow: auto;
    }
</style>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <div class="pull-right" style="margin-bottom:20px;">
                    <a href="javascript:void(0)" class="btn-u btn-u-purple simple-toggle" modal=".new-collection">New
                        Collection</a>
                </div>
                <!--Service Block v3-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Records</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($_SESSION['user']->collections as $id => $collection) {

                                echo '<tr>';
                                echo '<td><a href="' . $profileBase . 'account/collections/' . $id . '">' . $collection->name . '</></td>';
                                echo '<td>' . $collection->count . '</td>';
                                echo '<td>' . date('h:ia F j, Y', $collection->time) . '</td>';
                                echo '<td>';
                                echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                if ($id != 0)
                                    echo '<li><a href="javascript:void(0)" class="rename-coll" collection="' . $collection->id . '" name="' . $collection->name . '"><i class="fa fa-pencil"></i> Rename</a></li>';
                                echo '<li><a href="' . $profileBase . 'account/collections/' . $id . '"><i class="fa fa-table"></i> View Records</a></li>';
                                echo '<li><a href="/forms/collection-forms/collection.csv.php?collection=' . $id . '"><i class="fa fa-file-excel-o"></i> Download CSV</a></li>';
                                if ($id == 0)
                                    echo '<li><a href="javascript:void(0)" class="simple-toggle" modal=".transfer-collection"><i class="fa fa-share-square-o"></i> Transfer Records</a></li>';
                                if ($id != 0)
                                    echo '<li><a href="javascript:void(0)" class="delete-coll" collection="'.$id.'"><i class="fa fa-times"></i> Delete</a></li>';
                                echo '</ul>
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
<div class="transfer-collection back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post" id="name-form"
          action="/forms/collection-forms/transfer-items.php" class="sky-form" enctype="multipart/form-data">
        <header>Transfer Items</header>
        <fieldset>
            <section>
                <label class="label">Which Collection</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="collection">
                        <?php
                        foreach ($_SESSION['user']->collections as $id => $collection) {
                            if($id==0)
                                continue;
                            echo '<option value="' . $id . '">' . $collection->name . '</option>';
                        }
                        ?>
                    </select>
                    <b class="tooltip tooltip-top-right">The name of your collection</b>
                </label>
            </section>
        </fieldset>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
        </footer>
    </form>
</div>
<div class="new-collection back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post" id="name-form"
          action="/forms/collection-forms/create-collection.php" class="sky-form" enctype="multipart/form-data">
        <header>Create New Collection</header>
        <fieldset>
            <section>
                <label class="label">Collection Name</label>
                <label class="input">
                    <i class="icon-prepend fa fa-asterisk"></i>
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="name" placeholder="Focus to view the tooltip"
                           required>
                    <b class="tooltip tooltip-top-right">The name of your collection</b>
                </label>
            </section>
            <section>
                <label class="label">Transfer Records from Default Collection?</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="transfer">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <b class="tooltip tooltip-top-right">The name of your collection</b>
                </label>
            </section>
        </fieldset>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
        </footer>
    </form>
</div>
<div class="delete-collection back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post" id="name-form"
          action="/forms/collection-forms/delete-collection.php" class="sky-form" enctype="multipart/form-data">
        <header>Delete this Collection</header>
        <input name="collection" type="hidden" class="delete-coll-id"/>
        <fieldset>
            <section>
                <label class="label">Transfer Records to Default Collection?</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="transfer">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <b class="tooltip tooltip-top-right">The name of your collection</b>
                </label>
            </section>
        </fieldset>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Delete</button>
        </footer>
    </form>
</div>
<div class="rename-collection back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form method="post" id="name-form"
          action="/forms/collection-forms/rename-collection.php" class="sky-form" enctype="multipart/form-data">
        <header>Rename Collection</header>
        <input type="hidden" name="collection" class="collection-id"/>
        <fieldset>
            <section>
                <label class="label">Collection Name</label>
                <label class="input">
                    <i class="icon-prepend fa fa-asterisk"></i>
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="name" class="collection-rename" placeholder="Focus to view the tooltip"
                           required>
                    <b class="tooltip tooltip-top-right">The name of your collection</b>
                </label>
            </section>
        </fieldset>

        <footer>
            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
        </footer>
    </form>
</div>
