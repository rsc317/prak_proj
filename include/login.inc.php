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
    $email_exists = emailIsUsed($conn,$email);

    if($email_exists === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }

    $hashed_password = $email_exists['password'];
    $check_password = password_verify($password,$hashed_password);

    if($check_password === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }
    else if($check_password === true) {
        session_start();
        $_SESSION["id"] = $email_exists["id"];
        header("location: ../index.php");
        exit();
    }
}