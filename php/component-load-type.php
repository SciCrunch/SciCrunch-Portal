<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../classes/classes.php';
session_start();

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$component = new Component();

$components = $component->getByCommunity($cid);

if($id){
    $component->getByID($id);
    if ($component->icon1 == 'challenge1') {
    	$compData = new Component_Data();
    	$compData = $compData->getByLink($cid, $component->text2);
    	$component->rules = $compData[0]->color;
    	$component->visibility = $compData[0]->icon;
    	$component->description = $compData[0]->description;
    	$component->url = $compData[0]->link;
		$component->image = $compData[0]->image;
		$component->start = $compData[0]->start;
		$component->end = $compData[0]->end;
    }
    
    $action = '/forms/component-forms/container-component-edit.php?cid='.$cid.'&id='.$id;
} else {
    $component->id = 0;
    $component->type='page';
    $component->icon1 = $type;
    $action = '/forms/component-forms/container-component-add.php?cid='.$cid.'&type='.$type;
}

?>

<div class="close light">X</div>
<form method="post" action="<?php echo $action?>"
      id="header-component-form" class="sky-form" enctype="multipart/form-data">
    <?php echo $component->bodyComponentHTML(0, 0, false,$components['page']); ?>
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
    jQuery.validator.addMethod("exists", function (value, element, param) {
        var status;
        var params = 'name='+value+'&cid='+$(element).attr('cid');
        if($(element).attr('currName')){
            params += '&currName='+$(element).attr('currName');
        }
        $.ajax({
            url: param,
            data: params,
            async: false,
            dataType: 'json',
            success: function (j) {
                if (j != '0') {
                    status = true;
                } else
                    status = false;
            }
        });
        return status;
    }, $.format("That is not available."));
    jQuery.validator.addClassRules('cont-name', {
        required: false,
        accept: "[0-9a-fA-F\-\.]*",
        exists: "/validation/container-name.php"
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
</script>