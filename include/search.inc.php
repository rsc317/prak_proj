<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

if(isset($_POST['search'])) {

    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name = $_POST['street_name'];
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

    if (!(empty($phone_number)) && invalidNumber($phone_number) !== false) {
        header('location: ../mydata.php?error=invalidNumber');
        exit();
    }

    if($valid_email = search($conn, $email, $first_name,$given_name,$street_name,$city, $phone_number)){
        header('location: ../details.php?email='.$valid_email);
    }
    else {
        header('location: ../search.php?error=noResult');
    }
    exit();
}

function search($conn, $email, $first_name, $given_name, $street_name, $city, $phone_number) {
    $sql_array = array();
    $params = [];
    $type = "";

    if("" !== trim($email)){
        array_push($sql_array,'email=?');
        array_push($params, $email);
        $type .= 's';
    }

    if("" !== trim($first_name)){
        array_push($sql_array,'first_name=?');
        array_push($params, $first_name);
        $type .= 's';
    }

    if("" !== trim($given_name)){
        array_push($sql_array,'given_name=?');
        array_push($params, $given_name);
        $type .= 's';
    }

    if("" !== trim($street_name)){
        array_push($sql_array,'street_name=?');
        array_push($params, $street_name);
        $type .= 's';
    }

    if("" !== trim($city)){
        array_push($sql_array,'city=?');
        array_push($params, $city);
        $type .= 's';
    }

    if("" !== trim($phone_number)){
        array_push($sql_array,'phone_number=?');
        array_push($params, $phone_number);
        $type .= 's';
    }

    $sql = "SELECT email FROM user WHERE " . join(" AND ", $sql_array);
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../search.php?error=stmtfailed".$sql);
        exit();
    }

    mysqli_stmt_bind_param($stmt,$type,...$params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    if($row = mysqli_fetch_assoc($result)){
        return $row['email'];
    }

    return false;
}