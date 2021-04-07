<?php

function emailIsUsed($conn, $email) {
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtemailisusedfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s",$email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        mysqli_stmt_close($stmt);
        return $row;
    }
    else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    $id = createUniqueID();
    $rights_id = insertRights($conn);
        $hash_password = hashPassword($password);
        $sql = "INSERT INTO user(id, email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, rights) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../signup.php?error=stmtinsertuserfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssiisiss",$id,$email, $hash_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer, $rights_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

// inserts rights into table and return id
function insertRights($conn) {
    $admin = 0;
    $su = 0;
    $bu = 1;
    $id = createUniqueID();

    $sql = "INSERT INTO rights(id, admin, super_user, basic_user) VALUES(?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtinsertrightfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siii",$id,$admin,$su,$bu);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

//@createUniqueID creates an unique id and returns the id as a string @TODO research for better method
function createUniqueID(){
    $bytes = random_bytes(16);
    return bin2hex($bytes);
}

//@hashPassword($password) will hash the password @TODO hash with blowfish
function hashPassword($password){
    return password_hash($password, PASSWORD_DEFAULT);
}

function emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    if(empty($email) || empty($password) || empty($repeat_password) || empty($first_name) || empty($given_name) || empty($street_name) || empty($street_number) || empty($post_code) || empty($city) || empty($phone_numer)) {
        return true;
    }
    return false;
}

function invalidName($name){
    if(!preg_match("/[a-zA-Z]*$/", $name)) {
        return true;
    }
    return false;
}

function invalidNumber($number){
    if(!preg_match("/[0-9]*$/", $number)) {
        return true;
    }
    return false;
}

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }

    return false;
}

//@passwordMatches(...) will check if password matches and returns a boolean
function passwordMatch($password, $repeat_password) {
    return $password !== $repeat_password;
}