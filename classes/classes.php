<?php

/*
 * Does the aggregation of all the classes and sets the environment variables
 */

$serverSplit = explode('.', $_SERVER['SERVER_NAME']);
if ($serverSplit[0] == 'dev') {
    define("APIURL",'scigraph_endpoint');
    define("ENVIRONMENT", 'nif_services_endpoint');
    define("GACODE",'your_ga_code');
    define("VERSION", 'your_version_number');
} else {
    define("ENVIRONMENT", 'nif_services_endpoint');
    define("APIURL",'scigraph_endpoint');
    define("GACODE",'your_ga_code');
    define("VERSION", 'your_version_number');
}

if(preg_match('/^localhost.*/', $_SERVER['HTTP_HOST'])){
    define('HOSTNAME', 'localhost');
    define('USERNAME', 'username');
    define('PASSWORD', 'password');
    define('DATABASE_NAME', 'dbname');
} else {
    define('HOSTNAME', 'dbhost');
    define('USERNAME', 'username');
    define('PASSWORD', 'password');
    define('DATABASE_NAME', 'dbname');
}

include $_SERVER['DOCUMENT_ROOT'] . '/classes/connection.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/user.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/collection.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/community.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/search.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/snippet.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/component.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/component.data.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/component.extras.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/notification.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/page.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/resource.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/source.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/saved.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/custom.view.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/error.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/challenge.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/template-controller.class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/classes/base_search.class.php';

include $_SERVER['DOCUMENT_ROOT'] . '/classes/helper.namespace.php';
?>
