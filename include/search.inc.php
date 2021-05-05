<?php
//@TODO have to fix the issue with redirecting with values
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

if(isset($_POST['search'])) {

    $values = setValues($_POST);

    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../search.php?error=' . $error);
            exit();
        }

        $users = getUsersBySearch($conn, $values);
        header('location: ../search.php');
        exit();
    }

    catch (Exception $e) {
        header('location: ../search.php?error=stmtFailed');
        exit();
    }
}