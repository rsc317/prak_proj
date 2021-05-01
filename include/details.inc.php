<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (isset($_GET['email'])) {
    $user_email = $_GET['email'];
    if ($user_email == $_SESSION['email']) {
        header("location: ../mydata.php");
        exit();
    }
    setcookie('user_email', $user_email, time() + 3600);

    if ($user_data = getUserData($conn, $user_email)) {
        $user_first_name = $user_data['first_name'];
        $user_given_name = $user_data['given_name'];
        $user_street_name = $user_data['street_name'];
        $user_street_number = $user_data['street_number'];
        $user_post_code = $user_data['post_code'];
        $user_city = $user_data['city'];
        $user_phone_number = $user_data['phone_number'];
        $user_rights = $user_data['rights'];
        $user_active = $user_data['active'];
    }
}

if (isset($_POST['delete'])) {

    if (isset($_COOKIE['user_email'])) {
        deleteUser($conn, $_COOKIE['user_email']);
        unset($_COOKIE['user_email']);
        header("location: ../listpersons.php?error=none");
        exit();
    }
    header("location: ../listpersons.php?error=invalidEmail");
    exit();
}

if (isset($_POST['update'])) {
    $current_email = $_COOKIE['user_email'];
    $new_email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name = $_POST['street_name'];
    $street_number = $_POST['street_number'];
    $post_code = $_POST['post_code'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];
    $rights = $_POST['rights'];

    if (!(empty($first_name)) && invalidName($first_name) !== false) {
        header('location: ../listpersons.php?error=invalidName');
        exit();
    }

    if (!(empty($given_name)) && invalidName($given_name) !== false) {
        header('location: ../listpersons.php?error=invalidName');
        exit();
    }

    if (!(empty($street_name)) && invalidName($street_name) !== false) {
        header('location: ../listpersons.php?error=invalidName');
        exit();
    }

    if (!(empty($post_code)) && invalidNumber($post_code) !== false) {
        header('location: ../listpersons.php?error=invalidNumber');
        exit();
    }

    if (!(empty($phone_number)) && invalidNumber($phone_number) !== false) {
        header('location: ../listpersons.php?error=invalidNumber');
        exit();
    }

    if (!(empty($new_email)) && invalidEmail($new_email) !== false) {
        header('location: ../listpersons.php?error=invalidEmail');
        exit();
    }

    if (!(empty($new_email)) && validateEmail($conn, $new_email) !== false) {
        header('location: ../listpersons.php?error=emailAlreadyExists');
        exit();
    }

    if (!(empty($password)) && passwordMatch($password, $repeat_password) !== false) {
        header('location: ../listpersons.php?error=passwordDontMatch');
        exit();
    }

    if (!(empty($password)) && invalidPassword($password) !== false) {
        header('location: ../listpersons.php?error=invalidPassword');
        exit();
    }

    $values = ['first_name' => $first_name,'given_name' => $given_name, 'street_name' => $street_name,'street_number' => $street_number, 'post_code' => $post_code,'city' => $city, 'phone_number' => $phone_number,'password' => $password, 'rights' => $rights];

    try{
        updateUser($conn, $current_email, $values);
        header("location: ../mydata.php?error=none");
        exit();
    }
    catch(Exception $exception)
    {
        echo 'Exception caught: ', $exception->getMessage(), "\n";
        exit();
    }
}

function deleteUser($conn, $email) {
    $sql = "DELETE FROM user WHERE email =:email;";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

    } catch (PDOException $exception) {
        throw $exception;
    }
}

