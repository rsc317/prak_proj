<?php
require_once 'C:\Users\duman\PhpstormProjects\prak_proj\vendor\autoload.php';
require_once 'C:\Users\duman\PhpstormProjects\prak_proj\entities\User.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

const GUSER = 'phptestm01@gmail.com';
const GPWD = 'testphpp';

/**
 * @param PDO $conn
 * @param $values
 * @return User
 */
function insertUser(PDO $conn, &$values): User
{
    $values['active'] = 0;
    $values['vkey'] = createVkey($values['email']);
    $values['rights'] = 0;

    $sql = "INSERT INTO user( email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, active, vkey, rights) 
            VALUES (:email, :first_name, :given_name, :street_name, :street_number, :post_code, :city, :phone_number, :password, :active, :vkey, :rights);";
    try {
        $stmt = $conn->prepare($sql);
        emailVkey($values['email'], $values['vkey']);
        $stmt->execute($values);
        return $stmt->fetchObject('User');
    } catch (PDOException $exception) {
        throw $exception;
    }
}

/**
 * @param $conn PDO
 * @param $email string
 * @return User
 */
function getUser(PDO $conn, string $email): User
{
    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email =:email;");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchObject("User");
    } catch (PDOException $exception) {
        throw $exception;
    }
}

/**
 * @param PDO $conn
 * @param string $loggedUsersEmail
 * @param $values
 * @return array
 */
function updateUserByEmail(PDO $conn, string $loggedUsersEmail, &$values): array
{
    $sql_array = [];
    foreach ($values as $key => $value) {
        if ("" !== trim($value)) {
            $sql_array[] = $key . '=:' . $key;
            if ("password" == $key) {
                $values['password'] = hashPassword($value);
            }
        } else {
            unset($values[$key]);
        }
    }

    $values["useremail"] = $loggedUsersEmail;

    $sql = "UPDATE user SET " . join(", ", $sql_array) . " WHERE email=:useremail;";

    $stmt = $conn->prepare($sql);
    $stmt->execute($values);
    unset($values['useremail']);
    return $values;
}

/**
 * @param $conn PDO
 * @param $email string
 * @return false|mixed
 */
function validateEmail($conn, $email)
{
    try {
        $stmt = $conn->prepare("SELECT email FROM user WHERE email =:email;");
        if (!$stmt->execute(['email' => $email])) {
            return false;
        }
        return $stmt->fetch();
    } catch (PDOException $exception) {
        throw $exception;
    }
}

//@hashPassword($password) will hash the password @TODO hash with blowfish
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

//@emptyInputSignUp checks if the input values are empty
function emptyInput($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer)
{
    if (empty($email) || empty($password) || empty($repeat_password) || empty($first_name) || empty($given_name) || empty($street_name) || empty($street_number) || empty($post_code) || empty($city) || empty($phone_numer)) {
        return true;
    }
    return false;
}

//@invalidname($name) checks if the input value contains only letters
function invalidName($name)
{
    if (!ctype_alpha($name) || invalidInputStringLen($name)) {
        return true;
    }
    return false;
}

//@invalidNumber($number) checks if the number contains only numbers
function invalidNumber($number)
{
    if (!preg_match("/^\d+$/", $number)) {
        return true;
    }
    return false;
}

//@invalidEmail($email) check if the email is a email adress
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    return false;
}

//@passwordMatches(...) checks if passwords matches
function passwordMatch($password, $repeat_password)
{
    return $password !== $repeat_password;
}

//@invalidPassword($password) checks if the password contains at least one uppercase, lowercase and number
function invalidPassword($password)
{
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
        return true;
    }
    return false;
}

//@invalidInputStringLen(...) checks if the input value is at least 2 characters long and highest 64 characters long
function invalidInputStringLen($value)
{
    $value_len = strlen($value);
    if ($value_len < 2 || $value_len > 63) {
        return true;
    }
    return false;
}

function createVkey($email)
{
    return md5(time() . $email);
}

function sendMail($to, $from, $from_name, $subject, $body)
{
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
    if (!$mail->Send()) {
        $error = 'Mail error: ' . $mail->ErrorInfo;
        return false;
    } else {
        $error = 'Message sent!';
        return true;
    }
}

function emailVkey($email, $vkey)
{
    $message = "Hi, please klick on <a href='http://pp.local/verify.php?vkey=$vkey'>Link</a> to verificate your E-Mail address :)";

    if (sendMail($email, 'phptestm01@gmail.com', 'PhPTestProj', 'Email Verifictaion', $message)) {
        header('location:../mailsended.php');
    }
    if (!empty($error)) echo $error;

}

/**
 * @param User $loggedUser
 * @param array $values
 * @return User
 */
function updateUserSession(User &$loggedUser, array $values): User
{
    foreach ($values as $key => $value) {
        switch ($key) {
            case 'email':
                $loggedUser->setEmail($value);
                break;
            case 'first_name':
                $loggedUser->setFirstName($value);
                break;
            case 'given_name':
                $loggedUser->setGivenName($value);
                break;
            case 'street_name':
                $loggedUser->setStreetName($value);
                break;
            case 'street_number':
                $loggedUser->setStreetNumber($value);
                break;
            case 'post_code':
                $loggedUser->setPostCode($value);
                break;
            case 'city':
                $loggedUser->setCity($value);
                break;
            case 'phone_number':
                $loggedUser->setPhoneNumber($value);
                break;
            case 'password':
                $loggedUser->setPassword($value);
                break;
        }
    }

    return $loggedUser;
}
