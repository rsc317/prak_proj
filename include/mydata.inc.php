<?php
require_once 'connect.php';
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

    if (!(empty($first_name)) && invalidName($first_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($given_name)) && invalidName($given_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($street_name)) && invalidName($street_name) !== false) {
        header('location: ../mydata.php?error=invalidName');
        exit();
    }

    if (!(empty($post_code)) && invalidNumber($post_code) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if (!(empty($phone_number)) && invalidNumber($phone_number) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if (!(empty($email)) && invalidEmail($email) !== false) {
        header('location: ../mydata.php?error=invalidEmail');
        exit();
    }

    if (!(empty($email)) && validateEmail($conn, $email) !== false) {
        header('location: ../mydata.php?error=emailAlreadyExists');
        exit();
    }

    if (!(empty($password)) && passwordMatch($password, $repeat_password) !== false) {
        header('location: ../mydata.php?error=passwordDontMatch');
        exit();
    }

    if(!(empty($password)) && invalidPassword($password) !== false) {
        header('location: ../mydata.php?error=invalidPassword');
        exit();
    }

    $values = ['first_name' => $first_name,'given_name' => $given_name, 'street_name' => $street_name,'street_number' => $street_number, 'post_code' => $post_code,'city' => $city, 'phone_number' => $phone_number,'password' => $password];

    try{
        updateUser($conn, $_SESSION['email'], $values);
        header("location: ../mydata.php?error=none");
        exit();
    }
    catch(Exception $exception)
    {
        echo 'Exception caught: ', $exception->getMessage(), "\n";
        exit();
    }
}
