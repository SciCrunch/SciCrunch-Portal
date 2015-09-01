<?php
 include '../../classes/classes.php';
session_start();

foreach($_POST as $key=>$value){
    $vars[filter_var($key,FILTER_SANITIZE_NUMBER_INT)] = filter_var($value,FILTER_SANITIZE_NUMBER_INT);
}

$db = new Connection();
$db->connect();
foreach($vars as $id=>$weight){
    if($weight){
        $db->update('resource_fields','ii',array('weight'),array($weight,$id),'where id=?');
    }
}
$db->close();

$notification = new Notification();
$notification->create(array(
    'sender' => 0,
    'receiver' => $_SESSION['user']->id,
    'view' => 0,
    'cid' => $resource->cid,
    'timed'=>0,
    'start'=>time(),
    'end'=>time(),
    'type' => 'resource-weight',
    'content' => 'Successfully updated the weightings'
));
$notification->insertDB();
$_SESSION['user']->last_check = time();

$previousPage = $_SERVER['HTTP_REFERER'];
header('location:' . $previousPage);

?>