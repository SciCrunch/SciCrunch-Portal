<?php

$resource = new Resource();
$resource->getByID($arg2);
$resource->getColumns();

$holder = new Resource_Fields();
$fields = $holder->getByType($resource->typeID, $resource->cid);

?>
<?php
echo Connection::createBreadCrumbs('Edit '.$resource->columns['Resource_Name'],array('Home','Account','My Resources'),array($profileBase,$profileBase.'account',$profileBase.'account/resources'),'Edit '.$resource->columns['Resource_Name']);
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
                        <li class="page1-tab active"><a href="#page1" data-toggle="tab">Basic Information</a></li>
                        <?php if (count($fields['page'][1]) > 0) { ?>
                            <li class="page2-tab"><a href="#page2" data-toggle="tab">Additional Information</a></li>
                        <?php } ?>
                        <li class="final-tab"><a href="#final" data-toggle="tab" onclick="updateReview()">Review and
                                Submit</a></li>
                    </ul>
                    <form action="/forms/resource-forms/resource-edit.php?rid=<?php echo $resource->rid?>" method="post" id="sky-form" class="sky-form">
                        <div class="tab-content">
                            <!-- Datepicker Forms -->
                            <div class="tab-pane fade in active" id="page1">
                                <header>Basic Information</header>

                                <fieldset>
                                    <?php
                                    foreach ($fields as $field) {
                                        echo $field->getFormHTML($resource->columns[$field->name], '');
                                    }
                                    ?>
                                </fieldset>

                                <footer>
                                    <?php if (count($fields['page'][1]) > 0) { ?>
                                        <button type="submit" href="#page2"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.page2-tab').addClass('active');"
                                                data-toggle="tab" class="btn-u btn-u-default">Next
                                        </button>
                                    <?php } else { ?>
                                        <button type="submit" href="#final"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.final-tab').addClass('active');updateReview();"
                                                data-toggle="tab" class="btn-u btn-u-default">Review
                                        </button>
                                    <?php } ?>
                                </footer>
                            </div>
                            <?php if (count($fields['page'][1]) > 0) { ?>
                                <div class="tab-pane fade" id="page2">
                                    <header>Additional Information</header>

                                    <fieldset>
                                        <?php
                                        foreach ($fields['page'][1] as $field) {
                                            echo $field->getFormHTML($resource->columns[str_replace(' ','_',$field->name)], '');
                                        }
                                        ?>
                                    </fieldset>

                                    <footer>
                                        <button type="submit" href="#page1"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.page1-tab').addClass('active');"
                                                data-toggle="tab" class="btn-u btn-u-default">Previous
                                        </button>
                                        <button href="#final"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.final-tab').addClass('active');updateReview();"
                                                data-toggle="tab" class="btn-u btn-u-default">Review
                                        </button>
                                    </footer>
                                </div>
                            <?php } ?>
                            <div class="tab-pane fade" id="final">
                                <header>Review and Submit</header>

                                <fieldset>
                                    <?php
                                    foreach ($fields['page'] as $i => $array) {
                                        foreach ($array as $field) {
                                            echo $field->getFormHTML('', 'readonly');
                                        }
                                    }
                                    ?>
                                </fieldset>


                                <footer>
                                    <?php if (count($fields['page'][1]) > 0) { ?>
                                        <button href="#page2"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.page2-tab').addClass('active');"
                                                data-toggle="tab" class="btn-u btn-u-default">Previous
                                        </button>
                                    <?php } else { ?>
                                        <button href="#page1"
                                                onclick="$('.nav-tabs li').removeClass('active');$('.page1-tab').addClass('active');"
                                                data-toggle="tab" class="btn-u btn-u-default">Previous
                                        </button>
                                    <?php } ?>
                                    <input type="submit" class="btn-u"/>
                                </footer>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>