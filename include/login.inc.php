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
    $user_data = getUserData($conn,$email);

    if($user_data === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }

    $rights_id = $user_data['rights'];
    $rights = getRights($conn, $rights_id);

    $hashed_password = $user_data['password'];
    $check_password = password_verify($password,$hashed_password);
    $is_user_active = $user_data['active'];

    if(!$is_user_active || $check_password === false) {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }
    session_start();
    setSessionData($user_data);
    setRights($rights);
    header("location: ../index.php");
    exit();
}

function setRights($rights) {
    if ($rights['admin'] == true) {
        $_SESSION['admin'] = $rights['admin'];
    } elseif ($rights['super_user'] == true) {
        $_SESSION['super_user'] = $rights['super_user'];
    }elseif ($rights['basic_user'] == true) {
        $_SESSION['basic_user'] = $rights['basic_user'];
    }else {
        header("location: ../login.php?error=invalidLogin");
        exit();
    }

}

function setSessionData($user_data) {
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