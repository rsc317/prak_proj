<?php
require_once 'functions.inc.php';
require_once 'connect.php';

if (isset($_SESSION['loggedUser'])) {
    header("location: ../mydata.php");
    exit();
}

if(isset($_POST['signup'])){

    $values = setValues($_POST);

    try{
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../signup.php?error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $values['password'] = hashPassword($values['password']);
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

