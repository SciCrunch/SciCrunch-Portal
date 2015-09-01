<?php
if(count($components['footer'])==1){
    $component = $components['footer'][0];
    if($component->component==92)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/footer/footer-normal.php';
    elseif($component->component==91)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/footer/footer-light.php';
    elseif($component->component==90)
        include $_SERVER['DOCUMENT_ROOT'] . '/ssi/footer/footer-dark.php';
} else
    include $_SERVER['DOCUMENT_ROOT'] . '/ssi/footer/footer-normal.php';
?>
