<?php
include_once "classes/classes.php";

try{
    $result = Array();
    if(isset($_GET['version']) $version = filter_var($_GET['version'], FILTER_SANITIZE_STRING);
    if(isset($_GET['type']) $args['type'] = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
    if(isset($_GET['arg1']) $args['arg1'] = filter_var($_GET['arg1'], FILTER_SANITIZE_STRING);
    if(isset($_GET['arg2']) $args['arg2'] = filter_var($_GET['arg2'], FILTER_SANITIZE_STRING);
    if(isset($_GET['arg3']) $args['arg3'] = filter_var($_GET['arg3'], FILTER_SANITIZE_STRING);
    
    switch($version){
        case 1:
            $controller = new APIController($args);
            $result['data'] = $controller->execute();
            $result['success'] = true;
            break;
        default:
            throw new Exception("invalid version");
    }
}catch (Exception $e){
    $result = Array();
    $result['success'] = false;
    $result['errormsg'] = $e->getMessage();
}

echo json_encode($result);
exit;

?>
