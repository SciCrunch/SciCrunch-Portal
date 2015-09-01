<?php
include '../classes/classes.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$holder = new Sources();
$sources = $holder->getAllSources();

$type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
$category = filter_var($_GET['category'], FILTER_SANITIZE_STRING);
$subcategory = filter_var($_GET['subcategory'], FILTER_SANITIZE_STRING);
$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$x = filter_var($_GET['x'], FILTER_SANITIZE_NUMBER_INT);
$y = filter_var($_GET['y'], FILTER_SANITIZE_NUMBER_INT);

if ($category == 'undefined')
    $category = null;
if ($subcategory == 'undefined' || !$subcategory || $subcategory == null)
    $subcategory = null;

if ($type == 'add') {
    $action = '/forms/community-forms/category-add.php?cid=' . $cid;
    $title = 'Add Category';
    $action .= '&type=category';
} elseif ($type == 'add-sub') {
    $action = '/forms/community-forms/category-add.php?cid=' . $cid;
    $title = 'Add Subcategory';
    $action .= '&type=subcategory';
} elseif ($type == 'add-source') {
    $action = '/forms/community-forms/category-add.php?cid=' . $cid;
    $title = 'Add Source';
    $action .= '&type=source';
} elseif ($type == 'edit' && isset($id)) {
    $action = '/forms/community-forms/category-edit.php?id=' . $id;
    $title = 'Edit Source';
}

if ($id) {
    $cat = new Category();
    $cat->getByID($id);
}

$holder = new Category();
$categories = $holder->getCategories($cid);

if ($type == 'add') {
    foreach ($categories as $data) {
        $position[$data->x] = $data->category;
    }
    $use = 'x';
    $y = 0;
    $z = 0;
} elseif ($type == 'add-sub') {
    foreach ($categories as $data) {
        if ($data->category == $category) {
            if ($data->subcategory)
                $position[$data->y] = $data->subcategory;
            $x = $data->x;
            $z = 0;
        }
    }
    $use = 'y';
} elseif ($type == 'add-source') {
    foreach ($categories as $data) {
        if ($data->category == $category) {
            if (!$subcategory && !$data->subcategory) {
                if ($data->source) {
                    $position[$data->z] = $sources[$data->source]->getTitle();
                }
                $x = $data->x;
                $y = $data->y;
            } elseif ($subcategory == $data->subcategory) {
                if ($data->source) {
                    $position[$data->z] = $sources[$data->source]->getTitle();
                }
                $x = $data->x;
                $y = $data->y;
            }
        }
    }
    $use = 'z';
} elseif ($type == 'edit') {
    $title = 'Edit Source';
    $action = '/forms/community-forms/category-edit.php?id=' . $id;
}

?>
<div class="close dark less-right">X</div>
<form method="post" action="<?php echo $action ?>"
      id="header-component-form" class="create-cat-form sky-form" enctype="multipart/form-data">
    <header><?php echo $title ?></header>
    <fieldset>
        <section>
            <label class="label">Category</label>
            <label class="input">
                <?php if ($category) { ?>
                    <input type="hidden" name="category" class="category-check" placeholder="Focus to view the tooltip"
                           value="<?php echo $category ?>">
                    <?php
                    echo $category;
                } elseif ($cat) {
                    ?>
                    <input type="hidden" name="category" class="category-check" placeholder="Focus to view the tooltip"
                           value="<?php echo $cat->category ?>">
                    <?php
                    echo $cat->category;
                } else {
                    ?>
                    <i class="icon-prepend fa fa-asterisk"></i>
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="category" class="category-check cat-name" cid="<?php echo $cid ?>"
                           placeholder="Focus to view the tooltip" value="" required>
                    <b class="tooltip tooltip-top-right">The Category Name shown to the users</b>
                <?php } ?>
            </label>
        </section>
        <?php if ($type == 'add-sub' || $type == 'edit') { ?>
            <section>
                <label class="label">Subcategory</label>
                <label class="input">
                    <?php if ($subcategory) { ?>
                        <input type="hidden" name="subcategory" placeholder="Focus to view the tooltip"
                               value="<?php echo $subcategory ?>">
                        <?php
                        echo $subcategory;
                    } elseif ($cat) {
                        ?>
                        <input type="hidden" name="subcategory" placeholder="Focus to view the tooltip"
                               value="<?php echo $cat->subcategory ?>">
                        <?php
                        echo $cat->subcategory;
                    } elseif ($type != 'edit') {
                        ?>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" name="subcategory" class="cat-name" cid="<?php echo $cid ?>"
                               placeholder="Focus to view the tooltip" value="" required>
                        <b class="tooltip tooltip-top-right">The Subcategory Name shown to the users</b>
                    <?php } ?>
                </label>
            </section>
        <?php } elseif ($subcategory) { ?>
            <section>
                <label class="label">Subcategory</label>
                <label class="input">
                    <input type="hidden" name="subcategory" class="category-check" placeholder="Focus to view the tooltip"
                           value="<?php echo $subcategory ?>">
                    <?php
                    echo $subcategory;
                    ?>
                </label>
            </section>
        <?php } ?>
        <?php if (count($position) > 0) { ?>
            <section>
                <label class="label">Position</label>
                <label class="select">
                    <i class="icon-append fa fa-question-circle"></i>
                    <select name="<?php echo $use ?>">
                        <?php
                        $first = true;
                        foreach ($position as $pos => $name) {
                            if ($first) {
                                echo '<option value="' . ($pos - 1) . '">Before ' . $name . '</option>';
                                $first = false;
                            }
                            echo '<option value="' . ($pos) . '">After ' . $name . '</option>';
                        }
                        ?>
                    </select>
                </label>
            </section>
        <?php
        } else {
            echo '<input type="hidden" name="' . $use . '" value="0"/>';
        }

        if ($use == 'x') {
            echo '<input type="hidden" name="y" value="' . $y . '"/>';
            echo '<input type="hidden" name="z" value="' . $z . '"/>';
        } elseif ($use == 'y') {
            echo '<input type="hidden" name="x" value="' . $x . '"/>';
            echo '<input type="hidden" name="z" value="' . $z . '"/>';
        } else {
            echo '<input type="hidden" name="x" value="' . $x . '"/>';
            echo '<input type="hidden" name="y" value="' . $y . '"/>';
        }
        ?>
        <section>
            <label class="label">Source</label>
            <label class="select">
                <i class="icon-append fa fa-question-circle"></i>
                <select name="source">
                    <option value="">- None -</option>
                    <?php
                    foreach ($sources as $nif => $array) {
                        if ($cat) {
                            if ($cat->source == $nif)
                                echo '<option value="' . $nif . '" selected>' . $array->getTitle() . '</option>';
                            else
                                echo '<option value="' . $nif . '">' . $array->getTitle() . '</option>';
                        } else
                            echo '<option value="' . $nif . '">' . $array->getTitle() . '</option>';
                    }
                    ?>
                </select>
            </label>
        </section>

        <?php

        if ($cat) {
            if ($cat->facet && $cat->facet != '') {
                $splits = explode('&facet=', $cat->facet);
                $splits2 = explode(':', $splits[1]);
                $facetCol = $splits2[0];
                $facetVal = $splits2[1];
            } else {
                $facetCol = '';
                $facetVal = '';
            }
            if ($cat->filter && $cat->filter != '') {
                $splits = explode('&filter=', $cat->filter);
                $splits2 = explode(':', $splits[1]);
                $filterCol = $splits2[0];
                $filterVal = $splits2[1];
            } else {
                $filterCol = '';
                $filterVal = '';
            }
        }

        ?>

        <div class="row">
            <section class="col col-4">
                <label class="label">Facet (Optional)</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="facet-column"
                           placeholder="Focus to view the tooltip" <?php if ($cat) echo 'value="' . $facetCol . '"' ?>>
                    <b class="tooltip tooltip-top-right">The column in the source to facet on, not all columns are
                        facetable</b>
                </label>
            </section>
            <section class="col col-8">
                <label class="label">Value</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="facet-value"
                           placeholder="Focus to view the tooltip" <?php if ($cat) echo 'value="' . $facetVal . '"' ?>>
                    <b class="tooltip tooltip-top-right">The value to facet on in this column</b>
                </label>
            </section>
        </div>

        <div class="row">
            <section class="col col-4">
                <label class="label">Filter (Optional)</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="filter-column"
                           placeholder="Focus to view the tooltip" <?php if ($cat) echo 'value="' . $filterCol . '"' ?>>
                    <b class="tooltip tooltip-top-right">The column in the source to filter on</b>
                </label>
            </section>
            <section class="col col-8">
                <label class="label">Value</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" name="filter-value"
                           placeholder="Focus to view the tooltip" <?php if ($cat) echo 'value="' . $filterVal . '"' ?>>
                    <b class="tooltip tooltip-top-right">The value to filter on in this column</b>
                </label>
            </section>
        </div>
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
                $(".create-cat-form").validate({
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
            var params = 'name=' + value + '&cid=' + $(element).attr('cid');
            if ($(element).hasClass('subcategory-check')) {
                params += '&parent=' + $('.category-check').val();
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
