<?php

include 'classes/classes.php';
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

foreach ($_GET as $key => $value) {
    if ($key == 'filter' || $key == 'facet') {
        $vars[$key] = filter_var_array($value);
    } else {
        $vars[$key] = filter_var(rawurldecode($value), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }
}

//print_r($vars);

if (isset($vars['errorID'])) {
    $errorID = new Error();
    $errorID->getByID($vars['errorID']);
}

if (!$vars['type'])
    $vars['type'] = 'home';
if (!$vars['page'] && $vars['type'] != 'account')
    $vars['page'] = 1;
if (!$vars['q'])
    $vars['q'] = '*';

if (!isset($_SESSION['communities']) || !isset($_SESSION['communities'][$vars['portalName']])) {
    $community = new Community();
    $community->getByPortalName($vars['portalName']);

    if (!$community->id && $community->id != 0) {
        header('location:/404/' . $vars['portalName']);
        exit();
    }

    $community->getCategories();
    $holder = new Component();
    $components = $holder->getByCommunity($community->id);

    $community->components = $components;
    $_SESSION['communities'][$vars['portalName']] = $community;
} else {
    $community = $_SESSION['communities'][$vars['portalName']];
}



if ($vars['editmode']) {
    if (!isset($_SESSION['user']) || $_SESSION['user']->levels[$community->id] < 2)
        $vars['editmode'] = false;
}

if ($community->private == 1 && (!isset($_SESSION['user']) || $_SESSION['user']->levels[$community->id] < 1)) {
    header('location:/private/' . $vars['portalName']);
    exit();
}


if ($vars['type'] == 'home')
    include 'communities/home.php';
elseif ($vars['type'] == 'account')
    include 'communities/profile.php';
elseif ($vars['type'] == 'search')
    include 'communities/search.php';
elseif ($vars['type'] == 'about') {
    if ($vars['title'] == 'resource')
        include 'communities/resource.php';
    elseif ($vars['title'] == 'faq')
        include 'communities/faqs.php';
    elseif ($vars['title'] == 'sources')
        include 'communities/pages.php';
    elseif ($vars['title'] == 'registry')
        include 'communities/registry.php';
    elseif ($vars['title'] == 'search')
        include 'communities/content-search.php';
    else
        include 'communities/component-data.php';
} elseif ($vars['type'] == 'join') {
    include 'communities/join.php';
}


?>
