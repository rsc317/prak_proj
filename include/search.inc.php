<?php
require_once 'dbc.inc.php';
require_once 'functions.inc.php';

if(isset($_POST['search'])) {

    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name = $_POST['street_name'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];

    if (!(empty($email))) {
        header('location: ../details.php?email='.$email);
        exit();
    }

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

    if (!(empty($email)) && invalidEmail($email) !== false) {
        header('location: ../mydata.php?error=invalidEmail');
        exit();
    }

    if($valid_email = search($conn,$first_name,$given_name,$street_name,$city, $phone_number)){
        header('location: ../details.php?email='.$valid_email);
    }
    else {
        header('location: ../search.php?error=noResult');
    }
    exit();
}

function search($conn, ...$args) {
    $sql_array = array();
    $params = [];
    $type = "";

    foreach($args as $value ){
        if("" !== trim($value)){
            array_push($sql_array,key($value).'=?');
            array_push($params, $value);
            $type .= 's';
        }
    }

    $type .= "s";
    array_push($params, $_SESSION['email']);

    $sql = "SELECT email FROM user WHERE " . join(", ", $sql_array);
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../search.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,$type,...$params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    if($row = mysqli_fetch_assoc($result)){
        header("location: ../search.php?error=none");
        return $row['email'];
    }

    header("location: ../search.php?error=stmtfailed");
    return false;
}