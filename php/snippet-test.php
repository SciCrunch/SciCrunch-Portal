<?php

include '../classes/classes.php';

$view = $_GET['view'];
$vars['title'] = $_GET['title'];
$vars['description'] = $_GET['desc'];
$vars['url'] = $_GET['url'];

$snippet = new Snippet();
$snippet->view = $view;
$snippet->setSnippet($vars);

$url = ENVIRONMENT . '/v1/federation/data/' . $view . '.xml?count=10&exportType=all';
$xml = simplexml_load_file($url);

if ($xml) {
    foreach ($xml->result->results->row as $row) {
        $snippet->resetter();
        foreach ($row->data as $data) {
            $snippet->replace((string)$data->name, (string)$data->value);
        }
        $snippet->splitParts();
        $array[] = $snippet->snippet;
    }

    foreach ($array as $snip) {
        echo '<div class="inner-results">';
        echo '<div class="the-title">';

        echo ' <h3 style="display:inline-block">' . $snip['title'] . '</h3>';


        echo '</div>';
        echo '<div class="overflow-h">';
        echo '<div class="overflow-a">';
        echo '<p>' . $snip['description'] . '</p>';
        echo '<p><a href="'.$snip['url'].'">Go To Resource</a></p>';
        echo '</div></div></div>';
        echo '<hr/>';
    }
}

?>