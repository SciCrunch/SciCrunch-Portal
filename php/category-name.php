<?php
include '../classes/classes.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);


$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$category = filter_var(rawurldecode($_GET['category']), FILTER_SANITIZE_STRING);
$subcategory = filter_var(rawurldecode($_GET['subcategory']), FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);

$holder = new Category();


?>
<div class="close dark less-right">X</div>
<form method="post" id="name-form"
      action="/forms/community-forms/category-name.php?type=<?php echo $type ?>&cid=<?php echo $cid ?>"
      id="header-component-form" class="sky-form" enctype="multipart/form-data">
    <input type="hidden" name="past-category" value="<?php echo $category ?>"/>
    <input type="hidden" name="past-subcategory" value="<?php echo $subcategory ?>"/>
    <header>Change Name</header>
    <fieldset>
        <section>
            <label class="label">Category</label>
            <label class="input">
                <?php if ($type == 'subcategory-name') { ?>
                    <input type="hidden" class="category-check" name="category" placeholder="Focus to view the tooltip"
                           value="<?php echo $category ?>">
                    <?php
                    echo $category;
                } else {
                    ?>
                    <i class="icon-prepend fa fa-asterisk"></i>
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" class="category-check cat-name" cid="<?php echo $cid ?>" name="category" placeholder="Focus to view the tooltip"
                           value="<?php echo $category ?>" required>
                    <b class="tooltip tooltip-top-right">The Category Name shown to the users</b>
                <?php } ?>
            </label>
        </section>
        <?php if ($type == 'subcategory-name') { ?>
            <section>
                <label class="label">Subcategory</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" class="subcategory-check cat-name" cid="<?php echo $cid ?>" name="subcategory" placeholder="Focus to view the tooltip"
                           value="<?php echo $subcategory ?>" required>
                    <b class="tooltip tooltip-top-right">The Subcategory Name shown to the users</b>
                </label>
            </section>
        <?php } ?>
    </fieldset>

    <footer>
        <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
    </footer>
</form>
<script type="text/javascript">
    var Validation = function () {

        return {

            //Validation
            initValidation: function () {
                $("#name-form").validate({
                    // Rules for form validation
                    rules: {
                        required: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        date: {
                            required: true,
                            date: true
                        },
                        min: {
                            required: true,
                            minlength: 5
                        },
                        range: {
                            required: true,
                            rangelength: [5, 10]
                        },
                        digits: {
                            required: true,
                            digits: true
                        },
                        number: {
                            required: true,
                            number: true
                        },
                        minVal: {
                            required: true,
                            min: 5
                        },
                        maxVal: {
                            required: true,
                            max: 100
                        },
                        rangeVal: {
                            required: true,
                            range: [5, 100]
                        },
                        url: {
                            url: true
                        }
                    },

                    // Messages for form validation
                    messages: {
                        required: {
                            required: 'Please enter something'
                        },
                        email: {
                            required: 'Please enter your email address'
                        },
                        date: {
                            required: 'Please enter some date'
                        },
                        min: {
                            required: 'Please enter some text'
                        },
                        max: {
                            required: 'Please enter some text'
                        },
                        range: {
                            required: 'Please enter some text'
                        },
                        digits: {
                            required: 'Please enter some digits'
                        },
                        number: {
                            required: 'Please enter some number'
                        },
                        minVal: {
                            required: 'Please enter some value'
                        },
                        maxVal: {
                            required: 'Please enter some value'
                        },
                        rangeVal: {
                            required: 'Please enter some value'
                        },
                        url: {
                            url: 'Please enter a valid URL'
                        }
                    },

                    // Do not change code below
                    errorPlacement: function (error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            }

        };
    }();

    $(document).ready(function () {
        Validation.initValidation();
        jQuery.validator.addMethod("exists", function (value, element, param) {
            var status;
            var params = 'name='+value+'&cid='+$(element).attr('cid');
            if($(element).hasClass('subcategory-check')){
                params += '&parent='+$('.category-check').val();
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
        jQuery.validator.addClassRules('cat-name', {
            required: false,
            accept: "[0-9a-fA-F\-\.]*",
            exists: "/validation/category-name.php"
        });
    });
</script>