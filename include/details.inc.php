<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

if (isset($_GET['email'])) {
    $userEmail = $_GET['email'];
    $loggedUser = unserialize($_SESSION['loggedUser']);
    $loggedUsersEmail = $loggedUser->getEmail();

    if ($userEmail == $loggedUsersEmail) {
        header("location: ../mydata.php");
        exit();
    }

    setcookie('user_email', $userEmail, time() + 3600);
    $user = getUser($conn, $userEmail);
}

if (isset($_POST['update'])) {
    $current_email = $_COOKIE['user_email'];
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
        $updatedValues = updateUserByEmail($conn, $current_email, $values);
        header("location: ../details.php?email=".$current_email."?error=none");
        exit();
    } catch (Exception $e) {
        header("location: ../details.php?email=".$current_email."?error=stmtFailed");
        exit();
    }
}

if (isset($_POST['delete'])) {

    if (isset($_COOKIE['user_email'])) {
        deleteUser($conn, $_COOKIE['user_email']);
        unset($_COOKIE['user_email']);
        header("location: ../listpersons.php?error=none");
        exit();
    }
    header("location: ../listpersons.php?error=invalidEmail");
    exit();
}

function deleteUser($conn, $email) {
    $sql = "DELETE FROM user WHERE email =:email;";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

    } catch (PDOException $exception) {
        throw $exception;
    }
}

