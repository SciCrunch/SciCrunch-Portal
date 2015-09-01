<?php
include '../../classes/classes.php';

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);

$community = new Community();
$community->getByID($cid);

$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

$db = new Connection();
$db->connect();
$return = $db->select('community_access as a join users as b on a.uid=b.guid', array('a.uid', 'b.email, a.level'), 'i', array($cid), 'where a.level>1 and a.cid=? order by a.level desc');
$db->close();

foreach($return as $row){
    $emails[] = $row['email'];
}

$to = $return[0]['email'];
$subject = "SciCrunch Message on ".$community->shortName;
$intro_message = "<strong>This email is being sent from SciCrunch because a contact request was sent from <u>" . $email . "</u> in regards to the community <u>".$community->name."</u>.<br/><br/>User Message:</strong>";
$message = array($intro_message, $message);

\helper\sendEmail(array($to), $message, $subject, $email);

header('location:/'.$community->portalName);

?>
