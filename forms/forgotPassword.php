<?php

include '../classes/classes.php';
session_start();

if (isset($_SESSION['user'])) {
    exit();
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

$user = new User();
$user->getByEmail($email);
if ($user->id) {
    $user->resetPassword();
    $results['status'] = 1;
    $results['message'] = "Your password has been reset and an email was sent to your account email.";
} else {
    $results['status'] = 0;
    $results['message'] = "We did not find that email in our system.";
}

echo json_encode($results);

?>