<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

$loggedUser = unserialize($_SESSION['loggedUser']);
$email = $loggedUser->getEmail();
$firstName = $loggedUser->getFirstName();
$givenName = $loggedUser->getGivenName();
$phoneNumber = $loggedUser->getPhoneNumber();
$streetName = $loggedUser->getStreetName();
$streetNumber = $loggedUser->getStreetNumber();
$postCode = $loggedUser->getPostCode();
$city = $loggedUser->getCity();

if (isset($_POST['update'])) {
    $formInputValues = $_POST;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];
    $firstName = $_POST['first_name'];
    $givenName = $_POST['given_name'];
    $streetName =  $_POST['street_name'];
    $streetNumber = $_POST['street_number'];
    $postCode = $_POST['post_code'];
    $city = $_POST['city'];
    $phoneNumber = $_POST['phone_number'];

    $values = ['email' => $email, 'first_name' => $firstName,'given_name' => $givenName, 'street_name' => $streetName,
        'street_number' => $streetNumber, 'post_code' => $postCode,'city' => $city, 'phone_number' => $phoneNumber, 'password' => $password, 'repeat_password' => $repeatPassword];

    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../mydata.php?error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $values['password'] = hashPassword($password);
        $updatedValues = updateUserByEmail($conn, $loggedUser->getEmail(), $values);
        $loggedUser = updateUserSession($loggedUser, $updatedValues);
        $_SESSION['loggedUser'] = serialize($loggedUser);
        header("location: ../mydata.php?error=updated");
        exit();
    } catch (Exception $e) {
        header('location: ../mydata.php?error=stmtFailed');
        exit();
    }
}
