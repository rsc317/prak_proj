<?php

//@emailIsUsed(...) checks if the email address already exists
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

//@insertUser(...) inserts a user into the database
function insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    $id = createUniqueID();
    $rights_id = insertRights($conn);
    $active = 0;
    $vkey = createVkey($email);
        $hash_password = hashPassword($password);
        $sql = "INSERT INTO user(id, email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, rights, active, vkey) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../signup.php?error=stmtinsertuserfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssiisissis",$id,$email, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer, $hash_password, $rights_id, $active, $vkey);
        if(mysqli_stmt_execute($stmt)) {

            emailVkey($email,$vkey);
        }
        mysqli_stmt_close($stmt);
}

//@insertRights($conn) inserts rights into the databse
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

//@emptyInputSignUp checks if the input values are empty
function emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    if(empty($email) || empty($password) || empty($repeat_password) || empty($first_name) || empty($given_name) || empty($street_name) || empty($street_number) || empty($post_code) || empty($city) || empty($phone_numer)) {
        return true;
    }
    return false;
}

//@invalidname($name) checks if the input value contains only letters
function invalidName($name){
    if(!preg_match("/[a-zA-Z]*$/", $name)) {
        return true;
    }
    return false;
}

//@invalidNumber($number) checks if the number contains only numbers
function invalidNumber($number){
    if(!preg_match("/[0-9]*$/", $number)) {
        return true;
    }
    return false;
}

//@invalidEmail($email) check if the email is a email adress
function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }

    return false;
}

//@passwordMatches(...) checks if passwords matches
function passwordMatch($password, $repeat_password) {
    return $password !== $repeat_password;
}

//@invalidPassword($password) checks if the password contains at least one uppercase, lowercase and number
function invalidPassword($password) {
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
        return true;
    }
    return false;
}

//@invalidInputStringLen(...) checks if the input value is at least 3 characters long and highest 64 characters long
function invalidInputStringLen(&...$args) {
    foreach($args as $value) {
        $value_len = strlen($value);
        if($value_len < 3 || $value_len > 63) {
            return true;
        }
    }
    return false;
}

function createVkey($email){
    return md5(time().$email);
}

//TODO Configure Xampp on mac to send mail
function emailVkey($email, $vkey) {
    $subject = "Email Verifictaion";
    $message = "<a href='http://localhost/verify.php?vkey=$vkey>Register Account</a>'";
    $headers = "From: phptestm01@gmail.com \r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    if(mail($email,$subject,$message,$headers)) {
        header('location:../verified.php');
    }
}