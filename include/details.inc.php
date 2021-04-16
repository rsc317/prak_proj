<?php
require_once 'dbc.inc.php';
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
        $user_rights_id = $user_data['rights'];
        setcookie('user_rights_id', $user_rights_id, time() + 3600);
        $user_rights = getRights($conn, $user_rights_id);
        $user_active = $user_data['active'];
    }
}

if (isset($_POST['delete'])) {

    if (isset($_COOKIE['user_email'])) {
        deleteUser($conn, $_COOKIE['user_email']);
        deleteRights($conn, $_COOKIE['user_rights_id']);
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

    if($rights != 'none'){
        $rights_id = getRightsId($conn, $current_email);
        updateRights($conn, $rights, $rights_id);
        header("location: ../details.php?error=none&email=$current_email");
        exit();
    }
    if(updateSelectedUser($conn, $current_email, $new_email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_number, $rights)){
        header("location: ../details.php?error=none&email=$current_email");
        exit();
    }

}

function updateSelectedUser($conn, $current_email, $new_email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_number, $rights)
{
    $sql_array = array();
    $params = [];
    $type = "";

    if ("" !== trim($new_email)) {
        array_push($sql_array, 'email=?');
        array_push($params, $new_email);
        $type .= 's';
    }
    if ("" !== trim($first_name)) {
        array_push($sql_array, 'first_name=?');
        array_push($params, $first_name);
        $type .= 's';
    }
    if ("" !== trim($given_name)) {
        array_push($sql_array, 'given_name=?');
        array_push($params, $given_name);
        $type .= 's';
    }
    if ("" !== trim($street_name)) {
        array_push($sql_array, 'street_name=?');
        array_push($params, $street_name);
        $type .= 's';
    }
    if ("" !== trim($street_number)) {
        array_push($sql_array, 'street_number=?');
        array_push($params, $street_number);
        $type .= 'i';
    }
    if ("" !== trim($post_code)) {
        array_push($sql_array, 'post_code=?');
        array_push($params, $post_code);
        $type .= 'i';
    }
    if ("" !== trim($city)) {
        array_push($sql_array, 'city=?');
        array_push($params, $city);
        $type .= 's';
    }
    if ("" !== trim($phone_number)) {
        array_push($sql_array, 'phone_number=?');
        array_push($params, $phone_number);
        $type .= 's';
    }
    if ("" !== trim($password)) {
        array_push($sql_array, 'password=?');
        array_push($params, $password);
        $type .= 's';
    }

    if (!(count($params) > 0)) {
        header("location: ../details.php?email=".$current_email);
        exit();
    }

    $type .= "s";
    array_push($params, $current_email);

    $sql = "UPDATE user SET " . join(", ", $sql_array) . " WHERE email=?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../details.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, $type, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        header("location: ../details.php?error=stmtfailed");
        return false;
    }
}

function deleteUser($conn, $email) {
    $sql = "DELETE FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../listpersons.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s",$email);

    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
    }else {
        return false;
    }
}

function deleteRights($conn, $id) {
    $sql = "DELETE FROM rights WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../listpersons.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s",$id);

    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
    }else {
        return false;
    }
}
