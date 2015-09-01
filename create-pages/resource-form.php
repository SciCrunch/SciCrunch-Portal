<?php
$type = new Resource_Type();
if ($form == 'resource') {
    $type->id = 0;
    $type->name = 'Resource';
    $type->cid = 0;

} else
    $type->getByName($form, 0);


$holder = new Resource_Fields();
$section = filter_var($_GET['section'], FILTER_SANITIZE_NUMBER_INT);

if (!$section) {
    $section = 1;
}

if ($section == 1) {
    $fields = $holder->getPage1();
} elseif ($section == 2) {
    $resource = new Resource();
    $resource->getByRID($rid);
    $fields = $holder->getPage2(0, $resource->typeID);
} else {
    $resource = new Resource();
    $resource->getByRID($rid);
    $resource->getColumns();

    $fields = $holder->getByType($resource->typeID, 0);
}

?>

<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left"><?php echo $type->name ?> Submission</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/create/resource">Resource Select</a></li>
            <li class="active"><?php echo $type->name ?> Submission</li>
        </ul>
    </div>
</div>
<style>
    .our-step a.active {
        color: #fff;
        background: #18ba9b;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .our-step a.active i {
        border-color: #fff;
        color: #fff;
    }

    .our-step a.active h2, .our-step a.active p {
        color: #fff;
    }

    .our-step a i {
        top: 15px;
        right: 35px;
        width: 40px;
        height: 40px;
        padding: 8px;
        color: #c4c4c4;
        font-size: 20px;
        text-align: center;
        position: absolute;
        display: inline-block;
        border: 2px dashed #e0e0e0;
    }

    .our-step a {
        width: auto;
        padding: 15px;
        display: block;
        text-decoration: none;
        color: #fff;
        cursor: default;
        background: inherit;
        border: 1px solid #eee;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .our-step a .number {
        float: left;
        font-size: 36px;
        margin-right: 15px;
        color: #18ba9b;
    }

    .our-step a.active .number {
        color: #fff;
    }

    .our-step a p {
        opacity: .6;
        font-size: 16px;
    }
</style>
<div class="container content <?php if ($vars['editmode']) echo "editmode" ?>">
    <div class="row">
        <div class="col-md-12">
            <!-- Tabs -->
            <div class="row margin-bottom-30">
                <div class="col-md-4 our-step">
                    <a id="steps-uid-0-t-0" href="#steps-uid-0-h-0" <?php if ($section == 1) echo 'class="active"' ?>
                       aria-controls="steps-uid-0-p-0">
                        <span class="number">1.</span>

                        <div class="overflow-h">
                            <h2>Basic Information</h2>

                            <p>Enter in the required information</p>
                            <i class="rounded-x fa fa-info"></i>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 our-step">
                    <a id="steps-uid-0-t-1" href="#steps-uid-0-h-1" <?php if ($section == 2) echo 'class="active"' ?>
                       aria-controls="steps-uid-0-p-1">
                        <span class="number">2.</span>

                        <div class="overflow-h">
                            <h2>Additional Information</h2>

                            <p>Extra information about this resource</p>
                            <i class="rounded-x fa fa-tasks"></i>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 our-step">
                    <a id="steps-uid-0-t-2" href="#steps-uid-0-h-2" <?php if ($section == 3) echo 'class="active"' ?>
                       aria-controls="steps-uid-0-p-2">
                        <span class="number">3.</span>

                        <div class="overflow-h">
                            <h2>Review</h2>

                            <p>Review Submitted Information</p>
                            <i class="rounded-x fa fa-check"></i>
                        </div>
                    </a>
                </div>
            </div>

            <?php if ($section == 1) { ?>

                <?php if (!isset($_SESSION['user'])) { ?>
                    <form method="post"
                        action="/forms/resource-forms/resource-submission.php?cid=<?php echo $community->id ?>&typeID=<?php echo $type->id ?>&type=<?php echo $type->name ?>"
                    id="sky-form" class="sky-form resource-form-validate captcha-form" enctype="multipart/form-data" addr="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
                <?php } else { ?>
                        <form
                            action="/forms/resource-forms/resource-submission.php?cid=<?php echo $community->id ?>&typeID=<?php echo $type->id ?>&type=<?php echo $type->name ?>"
                            method="post" id="sky-form" enctype="multipart/form-data" class="sky-form resource-form-validate">
                <?php } ?>
                <div class="tab-content">
                    <!-- Datepicker Forms -->
                    <div class="tab-pane fade in active" id="page1">
                        <?php if (!isset($_SESSION['user'])) { ?>
                            <fieldset>
                                <section>
                                    <p>
                                        You are currently not logged in to SciCrunch. We ask that you either log
                                        in or provide your below so that we can contact you if we have
                                        questions or updates about your resource.
                                    </p>
                                <section>
                                    <label type="label">Your Email <span style="color:#bb0000">*</span></label>
                                    <label class="input">
                                        <i class="icon-append fa fa-question-circle"></i>
                                        <input type="text" class="resource-field" name="email"
                                               placeholder="Focus to view the tooltip" required="required">
                                        <b class="tooltip tooltip-top-right">Your Email address for contacting
                                            you
                                            about this resource since you are not logged in</b>
                                    </label>
                                </section>
                            </fieldset>
                        <?php } ?>
                        <fieldset>
                            <?php
                            foreach ($fields as $field) {
                                if(isset($_SESSION['user']) && $_SESSION['user']->role>0)
                                    echo $field->getFormHTML('', '', $type,1);
                                else
                                    echo $field->getFormHTML('', '', $type,0);
                            }
                            ?>
                            <!--<label type="label">Resource Image</label>
                            <label class="input">
                                <input type="file" name="resource-image" class="file-form" />
                            </label>-->
                        </fieldset>
                        <?php if (!isset($_SESSION['user'])) { ?>
                            <fieldset>

                                <section>
                                    <div class="g-recaptcha"
                                         data-sitekey="recaptcha_site_key"></div>
                                </section>
                            </fieldset>
                        <?php } ?>
                        <footer>
                            <button type="submit" class="btn-u btn-u-default">Submit</button>
                        </footer>
                    </div>


                </div>
                </form>
            <?php
            } elseif ($section == 2) {
                if ($resource->id) {
                    ?>
                    <div class="alert alert-warning fade in margin-bottom-40" style="font-size: 16px">
                        <h2 style="color:#72c02c">Successfully Submitted</h2>
                        Your Resource has successfully been submitted and has the Resource ID:
                        <b><?php echo $resource->rid ?></b>
                        <br/><br/>
                        You may close the tab and not fill in any further fields if you wish, but the additional fields
                        help define the resource and make it more desirable in the registry.
                    </div>
                    <form
                        action="/forms/resource-forms/resource-additional.php?rid=<?php echo $resource->rid ?>"
                        method="post" id="sky-form" class="sky-form">
                        <div class="tab-content">
                            <!-- Datepicker Forms -->
                            <div class="tab-pane fade in active" id="page1">

                                <fieldset>
                                    <?php
                                    foreach ($fields as $field) {
                                        echo $field->getFormHTML('', '', $type);
                                    }
                                    ?>
                                </fieldset>

                                <footer>
                                    <button type="submit" class="btn-u btn-u-default">Submit</button>
                                </footer>
                            </div>


                        </div>
                    </form>
                <?php
                } else {

                }
            } else {
                ?>
                <div class="alert alert-success fade in margin-bottom-40" style="font-size: 16px">
                    <h2 style="color:#72c02c">Successfully Submitted</h2>
                    Your Resource has successfully been submitted and has the Resource ID:
                    <b><a href="/browse/resources/<?php echo $resource->rid ?>"><?php echo $resource->rid?></a></b>
                    <br/><br/>

                </div>
            <?php } ?>
        </div>
    </div>

    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $type->name . ' Form</h3>';
        echo '<div class="pull-right">';
        echo '<a class="btn-u btn-u-default" href="/account/scicrunch/form/edit/' . $type->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Manage</span></button></div>';
        echo '</div>';
    } ?>
</div>
</div>
