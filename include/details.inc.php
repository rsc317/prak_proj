<?php
require_once 'dbc.inc.php';
require_once 'functions.inc.php';

if (!isset($_GET['email'])) {
    header("location: ../listpersons.php?error=invalidEmail");
    exit();
}

$email = $_GET['email'];
if($user_data = getUserData($conn, $email)){
    $user_email = $user_data['email'];
    $user_first_name = $user_data['first_name'];
    $user_given_name = $user_data['given_name'];
    $user_street_name = $user_data['street_name'];
    $user_street_number = $user_data['street_number'];
    $user_post_code = $user_data['post_code'];
    $user_city = $user_data['city'];
    $user_phone_number= $user_data['phone_number'];
}

