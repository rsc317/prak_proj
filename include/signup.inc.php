<?php
require_once 'functions.inc.php';
require_once 'connect.php';

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
    $phone_number = $_POST['phone_number'];

    if (emptyInput($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_number) !== false) {
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

    if (invalidEmail($email) !== false) {
        header('location: ../signup.php?error=invalidEmail');
        exit();
    }

    if (validateEmail($conn, $email) !== false) {
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

    $hashed_password = hashPassword($password);
    $values = ['email' => $email, 'first_name' => $first_name,'given_name' => $given_name, 'street_name' => $street_name,'street_number' => $street_number, 'post_code' => $post_code,'city' => $city, 'phone_number' => $phone_number, 'password' => $hashed_password];

    try{
        insertUser($conn, $values);
        header("location: ../mydata.php?error=none");
        exit();
    }
    catch(Exception $exception)
    {
        echo 'Exception caught: ', $exception->getMessage(), "\n";
        exit();
    }
}

