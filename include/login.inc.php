<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (emptyInputLogin($email, $password) !== false) {
        header('location: ../login.php?error=emptyInput');
        exit();
    }

    loginUser($conn, $email, $password);
}
else {
    header("location: ../login.php");
    exit();
}

//@emptyInputSignUp checks if the input values are empty
function emptyInputLogin($email, $password) {
    if(empty($email) || empty($password)) {
        return true;
    }
    return false;
}

function loginUser($conn, $email, $password) {
    $loggedUser = getUser($conn,$email);

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
