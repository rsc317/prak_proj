<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../lib/PHPMailer/src/Exception.php';
require_once '../lib/PHPMailer/src/PHPMailer.php';
require_once '../lib/PHPMailer/src/SMTP.php';
require_once 'functions.inc.php';
require_once 'dbc.inc.php';

const GUSER = 'phptestm01@gmail.com';
const GPWD = 'testphpp';

if(isset($_POST['signup'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name =  $_POST['street_name'];
    $street_number = $_POST['street_number'];
    $post_code = $_POST['post_code'];
    $city = $_POST['city'];
    $phone_numer = $_POST['phone_number'];

    if (emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) !== false) {
        header('location: ../signup.php?error=emptyInput');
        exit();
    }

    if (invalidName($first_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($given_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($street_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if(invalidInputStringLen($first_name,$given_name,$street_name) !== false) {
        header('location: ../signup.php?error=invalidStringLen');
        exit();
    }

    if (invalidNumber($post_code) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidNumber($phone_numer) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidEmail($email) !== false) {
        header('location: ../signup.php?error=invalidEmail');
        exit();
    }

    if (emailIsUsed($conn, $email) !== false) {
        header('location: ../signup.php?error=emailAlreadyExists');
        exit();
    }

    if (passwordMatch($password, $repeat_password) !== false) {
        header('location: ../signup.php?error=passwordDontMatch');
        exit();
    }

    if(invalidPassword($password) !== false) {
        header('location: ../signup.php?error=invalidPassword');
        exit();
    }

    insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer);
}

//@insertUser(...) inserts a user into the database
function insertUser($conn,$email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    $id = createUniqueID();
    $rights_id = insertRights($conn);
    $active = 0;
    $vkey = createVkey($email);
    $hash_password = hashPassword($password);
    $sql = "INSERT INTO user(id, email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, rights, active, vkey) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssiisissis",$id,$email, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer, $hash_password, $rights_id, $active, $vkey);
    if(mysqli_stmt_execute($stmt)) {
        emailVkey($email,$vkey);
        header("location: ../signup.php?error=none");
        exit();
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
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siii",$id,$admin,$su,$bu);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

//@createUniqueID creates an unique id and returns the id as a string @TODO research for better method
function createUniqueID(){
    //return md5(time());
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
        if($value_len < 2 || $value_len > 63) {
            return true;
        }
    }
    return false;
}

function createVkey($email){
    return md5(time().$email);
}

function sendMail($to, $from, $from_name, $subject, $body) {
    global $error;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo;
        return false;
    } else {
        $error = 'Message sent!';
        return true;
    }
}

function emailVkey($email, $vkey) {
    $message = "Hi, please klick on <a href='http://localhost/verify.php?vkey=$vkey'>Link</a> to verificate your E-Mail address :)";

    if (sendMail($email, 'phptestm01@gmail.com', 'PhPTestProj', 'Email Verifictaion', $message)) {
        header('location:../mailsended.php');
    }
    if (!empty($error)) echo $error;

}