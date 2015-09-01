<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include '../classes/classes.php';
session_start();

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$component = new Component();
$component->getByID($id);
?>

<div class="close light">X</div>
<form method="post" action="/forms/component-forms/other-single-components.php?id=<?php echo $component->id ?>"
      id="header-component-form" class="sky-form" enctype="multipart/form-data">
    <?php
    if ($component->type == 'header') {
        ?>
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Header
                </h3>
                <label style="padding-right:30px" class="pull-right">Type:
                    <select name="-headerSelect" class="header-select" style="color:#000;">
                        <option
                            value="normal" <?php if ($component->component == 0) echo 'selected' ?>>
                            Normal
                        </option>
                        <option
                            value="boxed" <?php if ($component->component == 1) echo 'selected' ?>>
                            Boxed
                        </option>
                        <option
                            value="float" <?php if ($component->component == 2) echo 'selected' ?>>
                            Float
                        </option>
                        <option
                            value="flat" <?php if ($component->component == 3) echo 'selected' ?>>
                            Flat
                        </option>
                    </select>
                </label>
            </div>
            <div class="panel-body">
                <?php
                if ($component->component == 0)
                    $image = 'header-normal';
                elseif ($component->component == 1)
                    $image = 'header-boxed';
                elseif ($component->component == 2)
                    $image = 'header-float';
                elseif ($component->component == 3)
                    $image = 'header-flat';
                ?>

                <fieldset>
                    <section>
                        <label class="label">Template</label>
                        <img class="img-responsive header-image"
                             src="/images/components/<?php echo $image ?>.png"
                             style="border: 1px solid #888"/>
                    </section>
                    <?php echo $component->formObjects('color','color1','Highlight Color',
                        'The Hover color of Links, and underline color')?>
                </fieldset>
            </div>
        </div>
        <script>
            $('.header-select').change(function () {
                $('.header-image').attr('src', '/images/components/header-' + $(this).val() + '.png');
            });
        </script>
    <?php
    } elseif($component->type=='breadcrumbs'){
    ?>
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i>
                    Breadcrumbs</h3>
                <label class="pull-right toggle"><input type="checkbox"
                                                        name="breadcrumbs-toggle" <?php if ($component->disabled == 0) echo 'checked' ?>><i
                        class="rounded-4x"></i></label>
            </div>
            <div class="panel-body">
                <fieldset>
                    <section>
                        <label class="label">Template</label>
                        <img class="img-responsive" src="/images/components/breadcrumbs.png"
                             style="border: 1px solid #888"/>
                    </section>

                    <?php
                    echo $component->formObjects('image','image','Background Image','The Hover color of Links, and underline color');
                    echo $component->formObjects('color','color3','Background Color (Overrides Image)',
                        'The Background Color of the breadcrumbs section. Will override the image, leave empty if you want an image.');
                    echo $component->formObjects('color','color1','Text Color','The general text color of the breadcrumbs section');
                    echo $component->formObjects('color','color2','Highlight Color','The color of the text for your current page');
                    ?>
                </fieldset>
            </div>
        </div>
    <?php } elseif($component->type=='search'){ ?>
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Search
                    Box
                </h3>
                <label class="pull-right toggle"><input type="checkbox"
                                                        name="search-toggle" <?php if ($component->disabled == 0) echo 'checked' ?>><i
                        class="rounded-4x"></i></label>
            </div>
            <div class="panel-body">
                <fieldset>
                    <section>
                        <label class="label">Template</label>
                        <img class="img-responsive" src="/images/components/search-block.png"
                             style="border: 1px solid #888"/>
                    </section>
                    <?php
                    echo $component->formObjects('text','text1','Search Box Text','The Text shown above the search bar');
                    echo $component->formObjects('text','text2','Search Tips','The search tips below the search box');
                    echo $component->formObjects('color','color1','Text Color','Color of the text in the section');
                    echo $component->formObjects('color','color2','Icon Background Color','The background color of the search icon');
                    ?>
                </fieldset>
            </div>
        </div>
    <?php } elseif($component->type=='footer'){ ?>
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Footer
                </h3>
                <label class="pull-right">Type:
                    <select name="-footerSelect" class="footer-select" style="color:#000;">
                        <option value="normal" <?php if($component->component==92) echo 'selected'?>>Normal</option>
                        <option value="dark" <?php if($component->component==91) echo 'selected'?>>Dark</option>
                        <option value="light" <?php if($component->component==90) echo 'selected'?>>Light</option>
                    </select>
                </label>
            </div>
            <div class="panel-body">
                <?php
                if($component->component==90)
                    $image = 'footer-dark';
                elseif($component->component==91)
                    $image = 'footer-light';
                elseif($component->component==92)
                    $image = 'footer-normal';
                ?>

                <fieldset>
                    <section>
                        <label class="label">Template</label>
                        <img class="img-responsive footer-image" src="/images/components/<?php echo $image ?>.jpg"
                             style="border: 1px solid #888"/>
                    </section>
                    <?php
                    if($component->component==92) {
                        echo $component->formObjects('textarea', 'text2', 'About Text', 'A short description of your community');
                        echo $component->formObjects('textarea', 'text1', 'Contact Text', 'The Contact information for your community');
                        echo $component->formObjects('text', 'text3', 'Social Handles', 'Type in your urls for social media in a comma separated list');
                        echo $component->formObjects('color', 'color1', 'Link and Header Color', 'The hover color of links and underline color');
                        echo $component->formObjects('color', 'color2', 'Footer Background Color', 'The background color of the top half of the footer');
                        echo $component->formObjects('color', 'color3', 'Copyright Background Color', 'The background color of the bottom half of the footer');
                    }
                    if($component->component==91){
                        echo $component->formObjects('text', 'text2', 'Link Names', 'Type in your link names in a comma separated list');
                        echo $component->formObjects('text', 'text3', 'Link Urls', 'Type in your link urls in a comma separated list');
                        echo $component->formObjects('text', 'text1', 'Social Handles', 'Type in your urls for social media in a comma separated list');
                        echo $component->formObjects('color', 'color1', 'Link and Header Color', 'The hover color of links and underline color');
                        echo $component->formObjects('color', 'color2', 'Footer Background Color', 'The background color of the top half of the footer');
                        echo $component->formObjects('color', 'color3', 'Copyright Background Color', 'The background color of the bottom half of the footer');
                    }
                    else{
                        echo $component->formObjects('text', 'text2', 'Link Names', 'Type in your link names in a comma separated list');
                        echo $component->formObjects('text', 'text3', 'Link Urls', 'Type in your link urls in a comma separated list');
                        echo $component->formObjects('color', 'color1', 'Link and Header Color', 'The hover color of links and underline color');
                        echo $component->formObjects('color', 'color2', 'Footer Background Color', 'The background color of the top half of the footer');
                        echo $component->formObjects('color', 'color3', 'Copyright Background Color', 'The background color of the bottom half of the footer');
                    }?>
                </fieldset>
            </div>
        </div>
    <?php } ?>
    <footer>
        <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
    </footer>
</form>


<script type="text/javascript">
    Validation.initValidation();
    jQuery.validator.addMethod("accept", function (value, element, param) {
        return value.match(new RegExp(param));
    }, $.format("Acceptable characters are: A-F, a-f, and 0-9"));
    jQuery.validator.addClassRules('color-input', {
        maxlength: 6,
        minlength: 6,
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