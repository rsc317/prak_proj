<?php
//@TODO find a solution to avoid absolute paths
require_once 'C:\Users\duman\PhpstormProjects\prak_proj\vendor\autoload.php';
require_once 'C:\Users\duman\PhpstormProjects\prak_proj\entities\User.php';

use PHPMailer\PHPMailer\PHPMailer;


const GUSER = 'phptestm01@gmail.com';
const GPWD = 'testphpp';

const VALIDATIONTYPE = ["email" => 'email', "first_name" => 'name', "given_name" => 'name', "street_name" => 'name',
    "street_number" => 'none', "post_code" => 'number', "city" => 'name', "phone_number" => 'number',
    "password" => 'password', "repeat_password" => 'password', "active" => 'none', "vkey" => 'none', "rights" => 'none'];

/**
 * @param PDO $conn
 * @param $values
 * @return Boolean
 * @throws \PHPMailer\PHPMailer\Exception
 */
function insertUser(PDO $conn, &$values): bool
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
    } catch (Exception $exception) {
        throw $exception;
    }
}

/**
 * @param $conn PDO
 * @param $email string
 * @return User|bool
 * @throws Exception
 */
function getUser(PDO $conn, string $email): User|bool
{
    $stmt = $conn->prepare("SELECT * FROM user WHERE email =:email;");
    $stmt->execute(['email' => $email]);
    return $stmt->fetchObject("User");
}

/**
 * @param PDO $conn
 * @param $values
 */
function getUsersBySearch(PDO $conn, $values)
{
    $sql_array = [];
    foreach ($values as $key => $value) {
        if ("" !== trim($value)) {
            $sql_array[] = $key . '=:' . $key;
        } else {
            unset($values[$key]);
        }
    }

    $stmt = $conn->prepare("SELECT email, first_name FROM user WHERE " . join(" OR ", $sql_array));
    $stmt->execute($values);
    return $stmt;
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
 * @param PDO $conn
 * @param string $email
 */
function deleteUser(PDO $conn, string $email)
{
    $sql = "DELETE FROM user WHERE email =:email;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

/**
 * @param $conn PDO
 * @param $email string
 * @return mixed
 */
function isEmailAlreadyAssigned(PDO $conn, string $email): mixed
{
    $stmt = $conn->prepare("SELECT email FROM user WHERE email =:email;");
    if (!$stmt->execute(['email' => $email])) {
        return false;
    }
    return $stmt->fetch();
}

/**
 * @param PDO $conn
 * @return int
 */
function getTotalNumberOfUsers(PDO $conn): int
{
    $sql = "SELECT COUNT(*) FROM `user`";
    $stmt = $conn->query($sql);

    return $stmt->fetchColumn();
}

/**
 * @param PDO $conn
 * @param int $c_page
 * @param int $rop
 * @return array
 */
function getLimitedUsers(PDO $conn, int $c_page, int $rop): array
{
    $sql = "SELECT `email`, `first_name` FROM `user` ORDER BY `email` LIMIT {$c_page},{$rop}";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * @param string $password
 * @return string
 */
function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * @param string $name
 * @return bool
 */
function invalidName(string $name): bool
{
    return !(preg_match('/^\pL+$/u', $name));
}

/**
 * @param string $number
 * @return bool
 */
function invalidNumber(string $number): bool
{
    if (!preg_match("/^\d+$/", $number)) {
        return true;
    }
    return false;
}

/**
 * @param string $email
 * @return bool
 */
function invalidEmail(string $email): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    return false;
}

/**
 * @param string $password
 * @param string $repeat_password
 * @return bool
 */
function passwordMatch(string $password, string $repeat_password): bool
{
    return $password !== $repeat_password;
}

/**
 * @param string $password
 * @return bool
 */
function invalidPassword(string $password): bool
{
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
        return true;
    }
    return false;
}

/**
 * @param string $value
 * @return bool
 */
function invalidInputStringLen(string $value): bool
{
    $value_len = strlen($value);
    if ($value_len < 2 || $value_len > 63) {
        return true;
    }
    return false;
}

/**
 * @param string $email
 * @return string
 */
function createVkey(string $email): string
{
    return md5(time() . $email);
}

/**
 * @param $to
 * @param $from
 * @param $from_name
 * @param $subject
 * @param $body
 * @return bool
 * @throws \PHPMailer\PHPMailer\Exception
 */
function sendMail($to, $from, $from_name, $subject, $body): bool
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

/**
 * @param $email
 * @param $vkey
 * @throws \PHPMailer\PHPMailer\Exception
 */
function emailVkey($email, $vkey)
{
    $message = "Hi, please klick on <a href='http://pp.local/verify.php?vkey=$vkey'>Link</a> to verificate your E-Mail address :)";
    sendMail($email, 'phptestm01@gmail.com', 'PhPTestProj', 'Email Verifictaion', $message);
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

/**
 * @param string $error
 * @return string[]
 */
function getErrorMsgAndType(string $error): array
{
    $errorMsg = '';
    $alertType = 'alert alert-warning';

    switch ($error) {
        case 'registered':
            $errorMsg = 'Thank you, we have send you an email to verify your Account';
            $alertType = 'alert alert-success';
            break;
        case 'updated':
            $errorMsg = 'Data was successfully updated';
            $alertType = 'alert alert-success';
            break;
        case 'found':
            $errorMsg = 'Users found';
            $alertType = 'alert alert-success';
            break;
        case 'emailAlreadyExists':
            $errorMsg = 'This email is already in use!';
            break;
        case 'passwordDontMatch':
            $errorMsg = 'Passwords dont match!';
            break;
        case 'invalidPassword':
            $errorMsg = 'Your password must contain at least one number, one uppercase letter and one lowercase letter';
            break;
        case 'invalidName':
            $errorMsg = 'The name must contain only Letters';
            break;
        case 'invalidNumber':
            $errorMsg = 'Numbers cant be letters';
            break;
        case 'stmtFailed':
            $errorMsg = 'Something went wrong!';
            $alertType = 'alert alert-danger';
            break;
        case 'emptyInput':
            $errorMsg = 'Fill in all fields!';
            break;
        case 'invalidLen':
            $errorMsg = 'The name must be at least two characters long';
            break;
        case 'invalidLogin':
            $errorMsg = 'The username and password you entered did not match. Please check and try again.';
            break;
    }

    return [$errorMsg, $alertType];
}

/**
 * @param PDO $conn
 * @param array $values
 * @return false|string
 */
function invalidInputValues(PDO $conn, array $values): bool|string
{
    foreach ($values as $key => $value) {
        if ("" !== trim($value)) {
            switch (VALIDATIONTYPE[$key]) {
                case 'email':
                    if (isEmailAlreadyAssigned($conn, $value)) {
                        return 'emailAlreadyExists';
                    }
                    if (invalidEmail($value)) {
                        return 'invalidEmail';
                    }
                    break;
                case 'name':
                    if (invalidName($value)) {
                        return 'invalidName';
                    }
                    if (invalidInputStringLen($value)) {
                        return 'invalidLen';
                    }
                    break;
                case 'number':
                    if (invalidNumber($value)) {
                        return 'invalidNumber';
                    }
                    break;
                case 'password':
                    if (passwordMatch($values['password'], $values['repeat_password'])) {
                        return 'passwordDontMatch';
                    }

                    if (invalidPassword($values['password'])) {
                        return 'invalidPassword';
                    }
                    break;
            }
        }
    }
    return false;
}

///**
// * @param array $values
// * @return array
// */
//function setValues(array $values): array
//{
//    $email = $values['email'];
//    $password = $values['password'];
//    $repeatPassword = $values['repeat_password'];
//    $firstName = $values['first_name'];
//    $givenName = $values['given_name'];
//    $streetName = $values['street_name'];
//    $streetNumber = $values['street_number'];
//    $postCode = $values['post_code'];
//    $city = $values['city'];
//    $phoneNumber = $values['phone_number'];
//
//    return ['email' => $email, 'first_name' => $firstName, 'given_name' => $givenName, 'street_name' => $streetName,
//        'street_number' => $streetNumber, 'post_code' => $postCode, 'city' => $city, 'phone_number' => $phoneNumber, 'password' => $password, 'repeat_password' => $repeatPassword];
//}