
<?php
if(count($components['header'])==1){
    $component2 = $components['header'][0];
    if($component2->component==0)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/header/header-normal.php';
    elseif($component2->component==1)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/header/header-boxed.php';
    elseif($component2->component==2)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/header/header-float.php';
} else
    include $_SERVER['DOCUMENT_ROOT'] . '/ssi/header/header-normal.php';
?>