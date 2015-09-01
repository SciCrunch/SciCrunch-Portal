<?php
$tab = 2;
include 'classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$type = filter_var($_GET['type'],FILTER_SANITIZE_STRING);
$form = filter_var($_GET['form'],FILTER_SANITIZE_STRING);
$submit = filter_var($_GET['submit'],FILTER_SANITIZE_STRING);
$rid = filter_var($_GET['rid'],FILTER_SANITIZE_STRING);


$vars['editmode'] = filter_var($_GET['editmode'],FILTER_SANITIZE_STRING);
if($vars['editmode']){
    if(!isset($_SESSION['user']) || $_SESSION['user']->role<1)
        $vars['editmode'] = false;
}

$vars['errorID'] = filter_var($_GET['errorID'],FILTER_SANITIZE_NUMBER_INT);
if($vars['errorID']){
    $errorID = new Error();
    $errorID->getByID($vars['errorID']);
    if(!$errorID->id){
        $errorID = false;
    }
}

$holder = new Component();
$components = $holder->getByCommunity(0);
if($type=='community') {
    $locaPage = '/create/community';
    $title = 'Create Community';
} elseif($type=='resource'){
    if($form){
        $title = 'Resource Submission';
    }elseif($submit){
        $title = 'Successfully Submitted the Resource';
    }else {
        $title = 'Pick A Resource Type';
    }
    $locaPage = '/create/resource';
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>SciCrunch | <?php echo $title?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="/assets/css/pages/page_search_inner.css">
    <link href="/assets/css/pages/blog_masonry_3col.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/assets/plugins/sky-forms/version-2.0.1/css/sky-forms-ie8.css">
    <![endif]-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
<?php echo \helper\noscriptHTML(); ?>

<div class="wrapper">
<!-- Brand and toggle get grouped for better mobile display -->
<?php include 'ssi/header.php'?>
<!--=== Breadcrumbs v3 ===-->

    <?php
    if($type=='community'){
        include 'create-pages/communities.php';
    } elseif($type=='resource'){
        if($form){
            include 'create-pages/resource-form.php';
        } elseif($submit=='finish'){
            include 'create-pages/resource-finish.php';
        } else
        include 'create-pages/type-select.php';
    }
    ?>

<?php include 'ssi/footer.php'?>
    <div class="background"></div>
<!--=== End Copyright ===-->
</div><!--/End Wrapepr-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="/assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/assets/plugins/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/assets/plugins/masonry/jquery.masonry.min.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="/assets/plugins/back-to-top.js"></script>
<script src="/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- JS Page Level -->
<script type="text/javascript" src="/assets/js/app.js"></script>
<script type="text/javascript" src="/assets/js/pages/blog-masonry.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
        <?php if(isset($_SESSION['user'])){?>
        setTimeout(updateLogin,<?php if($_SESSION['user']->last_check > time()) echo 1000*($_SESSION['user']->last_check-time()); else echo 1000 ?>);
        <?php } ?>
    });
</script>
<script type="text/javascript">
    $('.portal').blur(function(){
        $('.default-logo').load('/php/gravatar.php?name='+$(this).val());
    });
</script>
<script>
    Validation.initValidation();
    jQuery.validator.addMethod("exists", function (value, element, param) {
        var status;
        $.ajax({
            url: param,
            data: 'name='+value,
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
    }, $.format("The string you have entered is invalid or not available."));
    jQuery.validator.addMethod("badname", function(value, element, param){
        var status = true;
        if(param.test(value)) status = false;
        return status;
    }, $.format("The string you have entered contains invalid characters"));
    jQuery.validator.addMethod("accept", function (value, element, param) {
        return value.match(new RegExp(param));
    }, $.format("You have used an invalid character for this type."));

    jQuery.validator.addClassRules('portal', {
        required: false,
        accept: "[0-9a-fA-F\-\.]*",
        exists: "/validation/community-name.php",
        badname: /[^0-9a-zA-Z\-]/
    });
    jQuery.validator.addClassRules('required', {
        required: true
    });
    jQuery.validator.addClassRules('Resource_Name', {
        required: false,
        accept: "[0-9a-fA-F\-\.]*",
        exists: "/validation/resource-name.php"
    });
    jQuery.validator.addClassRules('color-input', {
        maxlength: 6,
        minlength: 6,
        required: false,
        accept: "[0-9a-fA-F]*"
    });
</script>
<!--[if lt IE 9]>
<script src="/assets/plugins/respond.js"></script>
<script src="/assets/plugins/html5shiv.js"></script>
<script src="assets/plugins/sky-forms/version-2.0.1/js/sky-forms-ie8.js"></script>
<![endif]-->

</body>
</html> 
