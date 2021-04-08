<?php
    require_once '../include/dbc.inc.php';
    require_once '../include/function.inc.php';

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

        if (emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) !== false) {
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

        if(invalidInputStringLen($first_name,$given_name,$street_name) !== false) {
            header('location: ../signup.php?error=invalidStringLen');
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
    else {
        header("location: ../signup.php");
    }