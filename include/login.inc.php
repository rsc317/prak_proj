<?php
require_once 'dbc.inc.php';
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
    $user_data = emailIsUsed($conn,$email);

    if($user_data === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }

    $hashed_password = $user_data['password'];
    $check_password = password_verify($password,$hashed_password);

    if($check_password === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }
    else if($check_password === true) {
        session_start();
        startSession($user_data);
        header("location: ../index.php");
        exit();
    }
}

function startSession($user_data) {
    session_start();
    $_SESSION['email'] = $user_data["email"];
    $_SESSION['first_name'] = $user_data['first_name'];
    $_SESSION['given_name'] = $user_data['given_name'];
    $_SESSION['street_name'] = $user_data['street_name'];
    $_SESSION['street_number'] = $user_data['street_number'];
    $_SESSION['post_code'] = $user_data['post_code'];
    $_SESSION['city'] = $user_data['city'];
    $_SESSION['phone_number'] = $user_data['phone_number'];
    $_SESSION['password'] = $user_data['password'];
}