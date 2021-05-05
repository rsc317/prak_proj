<?php
require_once 'functions.inc.php';
require_once 'connect.php';

if(isset($_POST['signup'])){
    $formInputValues = $_POST;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat_password'];
    $firstName = $_POST['first_name'];
    $givenName = $_POST['given_name'];
    $streetName =  $_POST['street_name'];
    $streetNumber = $_POST['street_number'];
    $postCode = $_POST['post_code'];
    $city = $_POST['city'];
    $phoneNumber = $_POST['phone_number'];

    $values = ['email' => $email, 'first_name' => $firstName,'given_name' => $givenName, 'street_name' => $streetName,
        'street_number' => $streetNumber, 'post_code' => $postCode,'city' => $city, 'phone_number' => $phoneNumber, 'password' => $password, 'repeat_password' => $repeatPassword];

    try{
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../signup.php?error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $values['password'] = hashPassword($password);
        insertUser($conn, $values);
        header("location: ../signup.php?error=registered");
        exit();
    }
    catch(Exception $exception)
    {
        header('location: ../signup.php?error=stmtFailed');
        exit();
    }
}

