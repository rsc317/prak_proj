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
    try
    {
        $user = getUser($conn, $userEmail);
    }
    catch (Exception $exception)
    {
        header("location: ../listpersons.php?error=stmtFailed");
        exit();
    }
}

if (isset($_POST['update'])) {
    $currentUserEmail = $_COOKIE['user_email'];
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
            header('location: ../details.php?email='.$currentUserEmail .'&error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $values['password'] = hashPassword($password);
        $updatedValues = updateUserByEmail($conn, $currentUserEmail, $values);
        header("location: ../details.php?email=" . $currentUserEmail . "&error=none");
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

function deleteUser($conn, $email)
{
    $sql = "DELETE FROM user WHERE email =:email;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

