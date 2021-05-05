<?php
//@TODO have to fix the issue with redirecting with values
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

if(isset($_POST['search'])) {

    $email = $_POST['email'];
    $firstName = $_POST['first_name'];
    $givenName = $_POST['given_name'];
    $streetName = $_POST['street_name'];
    $city = $_POST['city'];
    $phoneNumber = $_POST['phone_number'];

    $values = ['email' => $email, 'first_name' => $firstName,'given_name' => $givenName, 'street_name' => $streetName,
        'city' => $city, 'phone_number' => $phoneNumber];

    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../search.php?error=' . $error);
            exit();
        }

        $users = getUsersBySearch($conn, $values);
        header('location: ../search.php');
        exit();
    }

    catch (Exception $e) {
        header('location: ../search.php?error=stmtFailed');
        exit();
    }
}