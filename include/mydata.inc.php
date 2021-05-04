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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $firstName = $_POST['firstName'];
    $givenName = $_POST['givenName'];
    $streetName = $_POST['streetName'];
    $streetNumber = $_POST['streetNumber'];
    $postCode = $_POST['postCode'];
    $city = $_POST['city'];
    $phoneNumber = $_POST['phoneNumber'];

    if (!(empty($firstName)) && invalidName($firstName) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($givenName)) && invalidName($givenName) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($streetName)) && invalidName($streetName) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($phoneNumber)) && invalidNumber($phoneNumber) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if (!(empty($email)) && invalidEmail($email) !== false) {
        header('location: ../mydata.php?error=invalidEmail');
        exit();
    }

    if (!(empty($email)) && validateEmail($conn, $email) !== false) {
        header('location: ../mydata.php?error=emailAlreadyExists');
        exit();
    }

    if (!(empty($password)) && passwordMatch($password, $repeatPassword) !== false) {
        header('location: ../mydata.php?error=passwordDontMatch');
        exit();
    }

    if (!(empty($password)) && invalidPassword($password) !== false) {
        header('location: ../mydata.php?error=invalidPassword');
        exit();
    }

    $values = ['email' => $email, 'first_name' => $firstName, 'given_name' => $givenName, 'street_name' => $streetName, 'street_number' => $streetNumber, 'post_code' => $postCode, 'city' => $city, 'phone_number' => $phoneNumber, 'password' => $password];

    try {
        $updatedValues = updateUserByEmail($conn, $loggedUser->getEmail(), $values);
        $loggedUser = updateUserSession($loggedUser, $updatedValues);
        $_SESSION['loggedUser'] = serialize($loggedUser);
        header("location: ../mydata.php?error=none");
        exit();
    } catch (Exception $e) {
        header('location: ../mydata.php?error=stmtFailed');
        exit();
    }
}
