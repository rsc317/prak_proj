<?php
$host = "localhost";
$user_name = "root";
$password = "password";
$db_name = "prak_proj";
$port = "3306";
$charset = 'utf8mb4';

$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
    \PDO::MYSQL_ATTR_FOUND_ROWS => true
];

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset;port=$port";
try {
    $conn = new \PDO($dsn, $user_name, $password, $options);
    session_start();
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

