<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

$loggedUser = unserialize($_SESSION['loggedUser']);

if (isset($_POST['update'])) {
    $values = $_POST;
    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../mydata.php?error=' . $error);
            exit();
        }

        unset($values['repeat_password']);
        $updatedValues = updateUserByEmail($conn, $loggedUser->getEmail(), $values);
        $loggedUser = updateUserSession($loggedUser, $updatedValues);
        $_SESSION['loggedUser'] = serialize($loggedUser);
        header("location: ../mydata.php?error=updated");
        exit();
    } catch (Exception $e) {
        header('location: ../mydata.php?error=stmtFailed');
        exit();
    }
}
