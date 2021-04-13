<?php
require_once 'functions.inc.php';
require_once 'dbc.inc.php';

if(isset($_POST['signup'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name =  $_POST['street_name'];
    $street_number = $_POST['street_number'];
    $post_code = $_POST['post_code'];
    $city = $_POST['city'];
    $phone_numer = $_POST['phone_number'];

    if (emptyInput($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) !== false) {
        header('location: ../signup.php?error=emptyInput');
        exit();
    }

    if (invalidName($first_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($given_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($street_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidNumber($post_code) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidNumber($phone_numer) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidEmail($email) !== false) {
        header('location: ../signup.php?error=invalidEmail');
        exit();
    }

    if (emailIsUsed($conn, $email) !== false) {
        header('location: ../signup.php?error=emailAlreadyExists');
        exit();
    }

    if (passwordMatch($password, $repeat_password) !== false) {
        header('location: ../signup.php?error=passwordDontMatch');
        exit();
    }

    if(invalidPassword($password) !== false) {
        header('location: ../signup.php?error=invalidPassword');
        exit();
    }

    insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer);
}

//@insertUser(...) inserts a user into the database
function insertUser($conn,$email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    $id = createUniqueID();
    $rights_id = insertRights($conn);
    $active = 0;
    $vkey = createVkey($email);
    $hash_password = hashPassword($password);
    $sql = "INSERT INTO user(id, email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, rights, active, vkey) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssiisissis",$id,$email, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer, $hash_password, $rights_id, $active, $vkey);
    if(mysqli_stmt_execute($stmt)) {
        emailVkey($email,$vkey);
        header("location: ../signup.php?error=none");
        exit();
    }
    mysqli_stmt_close($stmt);
}

//@insertRights($conn) inserts rights into the databse
function insertRights($conn) {
    $admin = 0;
    $su = 0;
    $bu = 1;
    $id = createUniqueID();

    $sql = "INSERT INTO rights(id, admin, super_user, basic_user) VALUES(?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siii",$id,$admin,$su,$bu);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

//@createUniqueID creates an unique id and returns the id as a string @TODO research for better method
function createUniqueID(){
    //return md5(time());
    $bytes = random_bytes(16);
    return bin2hex($bytes);
}
