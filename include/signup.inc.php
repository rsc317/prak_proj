<?php
    require_once '../include/dbc.inc.php';
    require_once '../include/function.inc.php';

    if(isset($_POST['submit'])){

        submit($_POST['email'],$_POST['password'],$_POST['repeat_password'],$_POST['first_name'],$_POST['given_name'],$_POST['street_name'],$_POST['street_number'],$_POST['post_code'],$_POST['city'],$_POST['phone_number']);
    }
    else {
        header("location: ../signup.php");
    }


    //@submit(...) will check the given Data and enter it into the database if conditions are passed @TODO implement better Error Messages
   function submit($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer){
        if(emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) !== false){
            header('location: ../signup.php?error=emptyinput');
            exit();
        }

        if(invalidName($first_name) !== false){
            header('location: ../signup.php?error=invalidName');
            exit();
        }

       if(invalidName($given_name) !== false){
           header('location: ../signup.php?error=invalidName');
           exit();
       }

       if(invalidName($street_name) !== false){
           header('location: ../signup.php?error=invalidName');
           exit();
       }

       if(invalidEmail($email) !== false){
           header('location: ../signup.php?error=invalidemail');
           exit();
       }

       if(emailIsUsed($conn, $email) !==false) {
           header('location: ../signup.php?error=emailalreadyexists');
           exit();
       }

       if(passwordMatch($password, $repeat_password) !== false){
           header('location: ../signup.php?error=passworddontmatch');
           exit();
       }

       insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer);
    }