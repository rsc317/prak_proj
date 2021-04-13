<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../lib/PHPMailer/src/Exception.php';
require_once '../lib/PHPMailer/src/PHPMailer.php';
require_once '../lib/PHPMailer/src/SMTP.php';
require_once 'dbc.inc.php';

const GUSER = 'phptestm01@gmail.com';
const GPWD = 'testphpp';

//@emailIsUsed(...) checks if the email address already exists
function getDataByEmail($conn, $email) {
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s",$email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    if($row = mysqli_fetch_assoc($result)){
        return $row;
    }
    else {
        return false;
    }
}

//@hashPassword($password) will hash the password @TODO hash with blowfish
function hashPassword($password){
    return password_hash($password, PASSWORD_DEFAULT);
}

//@emptyInputSignUp checks if the input values are empty
function emptyInput($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) {
    if(empty($email) || empty($password) || empty($repeat_password) || empty($first_name) || empty($given_name) || empty($street_name) || empty($street_number) || empty($post_code) || empty($city) || empty($phone_numer)) {
        return true;
    }
    return false;
}

//@invalidname($name) checks if the input value contains only letters
function invalidName($name){
    if(!ctype_alpha($name) && invalidInputStringLen($name)) {
        return true;
    }
    return false;
}

//@invalidNumber($number) checks if the number contains only numbers
function invalidNumber($number){
    if(!preg_match("/^\d+$/", $number)) {
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

//@invalidInputStringLen(...) checks if the input value is at least 2 characters long and highest 64 characters long
function invalidInputStringLen($value) {
    $value_len = strlen($value);
    if ($value_len < 2 || $value_len > 63) {
        return true;
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

function getRights($id) {
    $sql = "SELECT * FROM rights WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    if($row = mysqli_fetch_assoc($result)){
        return $row;
    }
    else {
        return false;
    }
}