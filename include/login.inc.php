<?php

use JetBrains\PhpStorm\NoReturn;

require_once 'connect.php';
require_once 'functions.inc.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    loginUser($conn, $email, $password);
}

/**
 * @param PDO $conn
 * @param string $email
 * @param string $password
 */
#[NoReturn] function loginUser(PDO $conn, string $email, string $password) {
    try{
        $loggedUser = getUser($conn,$email);
    }
    catch (Exception $exception)
    {
        header('location: ../login.php?error=stmtFailed');
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
