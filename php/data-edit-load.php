<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../classes/classes.php';
session_start();

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$data = new Component_Data();
$data->getByID($id);

if(!isset($_SESSION['user']) || ($_SESSION['user']->levels[$cid]<2 && $_SESSION['user']->role>1)){
    exit();
}
?>

<div class="close light">X</div>
<form method="post" action="/forms/component-forms/body-data-edit.php?id=<?php echo $id ?>"
      id="header-component-form" class="sky-form" enctype="multipart/form-data">
    <input type="hidden" name="0-position" value="<?php echo $data->position?>"/>
    <?php echo $data->getDataForm(false); ?>
    <footer>
        <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
    </footer>
</form>



<script type="text/javascript">
    Validation.initValidation();
    jQuery.validator.addMethod("accept", function(value, element, param) {
        return value.match(new RegExp(param));
    }, $.format("Acceptable characters are: A-F, a-f, and 0-9"));
    jQuery.validator.addClassRules('color-input', {
        maxlength: 6,
        minlength:6,
        required: false,
        accept: "[0-9a-fA-F]*"
    });
    $('.summer-text').summernote({
        height: 200,                 // set editor height

        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor

        focus: false,                 // set focus to editable area after initializing summernote
        toolbar: [
            //[groupname, [button list]]

            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'hr', 'picture']],
            ['misc',['fullscreen','codeview']],
            ['help',['help']]
        ]
    });
</script>