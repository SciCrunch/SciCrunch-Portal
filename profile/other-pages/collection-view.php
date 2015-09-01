<?php

$collection = $_SESSION['user']->collections[$arg1];

$holder = new Sources();
$sources = $holder->getAllSources();

echo Connection::createBreadCrumbs($collection->name,array('Home','Account','My Collections'),array($profileBase,$profileBase.'account',$profileBase.'account/collections'),$collection->name);
?>

<style>
    .collection-view-table td p {
        margin-left:10px;
    }
    .record-load, .snippet-load, .saved-this-search {
        position: fixed;
        left:50%;
        margin-left:-400px;
        top:20px;
        width:800px;
        padding:20px;
        border: 1px solid #666;
        z-index: 991;
        display: none;
        background:#fff;
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
                    <a href="/forms/collection-forms/collection.csv.php?collection=<?php echo $collection->id ?>" class="btn-u btn-u-purple">Download CSV</a>
                </div>
                <!--Service Block v3-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover collection-view-table">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Community</th>
                                <th>View</th>
                                <th>Insert Time</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $commArray = array();
                            $holder = new Item();
                            $items = $holder->getByCollection($collection->id, $_SESSION['user']->id);
                            foreach($items as $item){
                                if(!isset($commArray[$item->community])){
                                    $comm = new Community();
                                    $comm->getByID($item->community);
                                    $commArray[$item->community] = $comm;
                                } else {
                                    $comm = $commArray[$item->community];
                                }
                                echo '<tr>';
                                echo '<td>';
                                $xml = simplexml_load_string($item->snippet);
                                echo '<h3>'.$xml->title.'</h3>';
                                echo '<p>'.$xml->description.'</p>';
                                echo '<p style="margin-top:10px;"><b>URL:</b> <a href="'.$xml->url.'">'.$xml->url.'</a></p>';
                                echo '<p style="margin-top:5px;"><b>Citation:</b> '.$xml->citation.'</p>';
                                echo '</td>';
                                echo '<td>'.$comm->name.'</td>';
                                echo '<td>'.$sources[$item->view]->getTitle().'</td>';
                                echo '<td>'.date('h:ia F j, Y', $item->time).'</td>';
                                echo '<td>';
                                echo '<div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
                                echo '<li><a href="/forms/collection-forms/remove-item.php?community='.$item->community.'&uuid='.$item->uuid.'&view='.$item->view.'&collection='.$item->collection.'&redirect=true"><i class="fa fa-times"></i> Remove</a></li>
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
<div class="record-load back-hide"></div>
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
