<?php

require_once 'connect.php';
require_once 'functions.inc.php';

if (isset($_SESSION['loggedUser'])) {
    header("location: ../mydata.php");
    exit();
}

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        loginUser($conn, $email, $password);
    } catch (Exception $e) {
        header('location: ../login.php?error=stmtFailed');
        exit();
    }
}

/**
 * @param PDO $conn
 * @param string $email
 * @param string $password
 * @throws Exception
 */
function loginUser(PDO $conn, string $email, string $password) {
    if (!$loggedUser = getUser($conn, $email)) {
        header('location: ../login.php?error=invalidLogin');
        exit();
    }

    $hashed_password = $loggedUser->getPassword();
    $check_password = password_verify($password,$hashed_password);
    $is_user_active = $loggedUser->isActive();

    if(!$is_user_active || $check_password === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }
    $_SESSION['loggedUser'] = serialize($loggedUser);
    header("location: ../index.php");
    exit();
}
