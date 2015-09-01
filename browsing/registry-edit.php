<?php
$resource = new Resource();
$resource->getByRID($id);
if ($vars['article']) {
    $version = $vars['article'];
} else {
    $version = $resource->getLatestVersionNum();
}
$resource->getVersionColumns($version);

$columns = $resource->columns;

$type = new Resource_Type();
$type->getByID($resource->typeID);

$holder = new Resource_Fields();
$fields = $holder->getByType($type->id, $resource->cid);

?>
<div class="container margin-bottom-50" style="margin-top: 50px">
    <form action="/forms/resource-forms/resource-edit.php?rid=<?php echo $resource->rid ?>&cid=0" method="post" id="sky-form"
          class="sky-form" enctype="multipart/form-data">
        <!-- Datepicker Forms -->
        <header>Edit Resource</header>

        <?php if (!isset($_SESSION['user'])) { ?>
            <fieldset>
                <section>
                    <p>
                        You are currently not logged in to SciCrunch. We ask that you either log
                        in, or provide your email below so that we can contact you if we have
                        questions or updates about your resource.
                    </p>
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
                    echo $field->getFormHTML($resource->columns[$field->name], '', '',1);
                else
                    echo $field->getFormHTML($resource->columns[$field->name], '', '',0);
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
        <?php } elseif($_SESSION['user']->role>0){ ?>
            <fieldset>

                <section>
                    <label class="label">Index Status</label>
                    <label class="select">
                        <i class="icon-append fa fa-question-circle"></i>
                        <select name="index_status">
                            <option value="Curated">Curated</option>
                            <option value="Pending">Pending</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </label>
                </section>
            </fieldset>
        <?php } ?>
        <footer>
            <button type="submit" class="btn-u btn-u-default">Submit
            </button>
        </footer>
    </form>
</div>
