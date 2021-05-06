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
    $loggedUsersRgihts = $loggedUser->getRights();

    if ($userEmail == $loggedUsersEmail) {
        header("location: ../mydata.php");
        exit();
    }

    setcookie('user_email', $userEmail, time() + 3600);
    try
    {
        $user = getUser($conn, $userEmail);
        $email = $user->getEmail();
        $firstName = $user->getFirstName();
        $givenName = $user->getGivenName();
        $phoneNumber = $user->getPhoneNumber();
        $streetName = $user->getStreetName();
        $streetNumber = $user->getStreetNumber();
        $postCode = $user->getPostCode();
        $city = $user->getCity();
    }
    catch (Exception $exception)
    {
        header("location: ../listpersons.php?error=stmtFailed");
        exit();
    }
}

if (isset($_POST['update'])) {
    $currentUserEmail = $_COOKIE['user_email'];
    $values = $_POST;
    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../details.php?email='.$currentUserEmail .'&error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $updatedValues = updateUserByEmail($conn, $currentUserEmail, $values);
        header("location: ../details.php?email=" . $currentUserEmail . "&error=updated".join(";;",$updatedValues));
        exit();
    } catch (Exception $e) {
        header("location: ../details.php?email=" . $currentUserEmail . "&error=stmtFailed");
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

