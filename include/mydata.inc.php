<?php
require_once 'dbc.inc.php';
require_once 'functions.inc.php';

if(isset($_POST['update'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name =  $_POST['street_name'];
    $street_number = $_POST['street_number'];
    $post_code = $_POST['post_code'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];

    if ("" != trim($first_name) && invalidName($first_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if ("" != trim($given_name) && invalidName($given_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if ("" != trim($street_name) && invalidName($street_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if ("" != trim(post_code) && invalidNumber($post_code) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if ("" != trim($phone_number) && invalidNumber($phone_number) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if ("" != trim($email) && invalidEmail($email) !== false) {
        header('location: ../mydata.php?error=invalidEmail');
        exit();
    }

    if ("" != trim($email) && emailIsUsed($conn, $email) !== false) {
        header('location: ../mydata.php?error=emailAlreadyExists');
        exit();
    }

    if ("" != trim($password) && passwordMatch($password, $repeat_password) !== false) {
        header('location: ../mydata.php?error=passwordDontMatch');
        exit();
    }

    if("" != trim($password) && invalidPassword($password) !== false) {
        header('location: ../mydata.php?error=invalidPassword');
        exit();
    }
    updateUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_number);
}

function updateUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_number) {
    $sql_array = array();
    $params = array();
    $type = "";
    if("" != trim($email)){
        array_push($sql_array,"email = ?,");
        array_push($params, $email);
        $type .= "s";

    }
    if("" != trim($first_name)){
        array_push($sql_array,"first_name=?");
        array_push($params, $first_name);
        $type .= "s";
    }
    if("" != trim($given_name)){
        array_push($sql_array,"first_name=?");
        array_push($params, $given_name);
        $type .= "s";
    }
    if("" != trim($street_name)){
        array_push($sql_array,"first_name=?");
        array_push($params, $street_name);
        $type .= "s";
    }
    if("" != trim($street_number)){
        array_push($sql_array,"first_name=?");
        array_push($params, $street_number);
        $type .= "i";
    }
    if("" != trim($post_code)){
        array_push($sql_array,"first_name=?");
        array_push($params, $post_code);
        $type .= "i";
    }
    if("" != trim($city)){
        array_push($sql_array,"first_name=?");
        array_push($params, $city);
        $type .= "s";
    }
    if("" != trim($phone_number)){
        array_push($sql_array,"first_name=?");
        array_push($params, $phone_number);
        $type .= "i";
    }
    if("" != trim($password)){
        array_push($sql_array,"first_name=?");
        array_push($params, $password);
        $type .= "s";
    }

    $sql = "UPDATE user SET " . join(" ,", $sql_array) . "WHERE email=?";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../mydata.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, $type,$email, $params);
    if(mysqli_stmt_execute($stmt)) {
        header("location: ../mydata.php?error=none");
        exit();
    }
    mysqli_stmt_close($stmt);
}

function verifyPassword($password){
    $hashed_password = $password;
    return password_verify($password,$hashed_password);
}