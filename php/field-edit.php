<?php
include '../classes/classes.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
$id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

$field = new Resource_Fields();
$field->getByID($id);

?>
<div class="close dark less-right">X</div>
<form method="post" action="/forms/resource-forms/field-edit.php?id=<?php echo $id?>"
      id="header-component-form" class="sky-form" enctype="multipart/form-data">
    <header>Edit Field</header>
    <fieldset>
        <section>
            <label class="label">Field Name</label>
            <label class="input">
                <i class="icon-append fa fa-question-circle"></i>
                <input type="text" name="name" placeholder="Focus to view the tooltip" value="<?php echo $field->name?>">
                <b class="tooltip tooltip-top-right">The Label of the field shown to users</b>
            </label>
        </section>
        <section>
            <label class="label">Field Type</label>
            <label class="select">
                <i class="icon-append fa fa-question-circle"></i>
                <select name="type">
                    <option value="text" <?php if($field->type=='text') echo 'selected'?>>Text Input</option>
                    <option value="textarea" <?php if($field->type=='textarea') echo 'selected'?>>Text Area</option>
                    <option value="file" <?php if($field->type=='file') echo 'selected'?>>File Input</option>
                </select>
            </label>
        </section>
        <section>
            <label class="label">Display Type</label>
            <label class="select">
                <i class="icon-append fa fa-question-circle"></i>
                <select name="display">
                    <option value="text">Text</option>
                    <option value="literature-text">Comma Separated PMIDs</option>
                    <option value="map-text">Map based on place</option>
                    <option value="resource">Resource</option>
                </select>
            </label>
        </section>
        <section>
            <label class="label">Autocomplete Category</label>
            <label class="select">
                <i class="icon-append fa fa-question-circle"></i>
                <select name="autocomplete">
                    <option value="">-- None --</option>
                    <?php
                    $url = 'scigraph_vocab_category_service';
                    $xml = simplexml_load_file($url);
                    if ($xml) {
                        foreach ($xml->category as $category) {
                            $categories[] = $category;
                        }
                        natcasesort($categories);
                        foreach ($categories as $category) {
                            if($field->autocomplete==$category)
                                echo '<option value="' . $category . '" selected>' . $category . '</option>';
                            else
                                echo '<option value="' . $category . '">' . $category . '</option>';
                        }
                    }
                    ?>
                </select>
            </label>
        </section>
        <section>
            <label class="label">Tooltip</label>
            <label class="input">
                <i class="icon-append fa fa-question-circle"></i>
                <input type="text" name="alt" placeholder="Focus to view the tooltip" value="<?php echo $field->alt ?>">
                <b class="tooltip tooltip-top-right">The tooltip shown on select</b>
            </label>
        </section>
        <section>
            <label class="label">Required</label>
            <label class="select">
                <i class="icon-append fa fa-question-circle"></i>
                <select name="required">
                    <option value="0" <?php if($field->required==0) echo 'selected'?>>No</option>
                    <option value="1" <?php if($field->required==1) echo 'selected'?>>Yes</option>
                </select>
            </label>
        </section>
    </fieldset>
    <footer>
        <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
    </footer>
</form>
