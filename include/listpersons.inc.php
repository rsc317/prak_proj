<?php
require_once 'connect.php';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$rop = 3;
$c_page = ($page - 1) * $rop;

$result = getLimitedUsers($conn, $c_page, $rop);
$total_pages = getTotalNumberOfUsers($conn);

function getTotalNumberOfUsers($conn) {
    $sql = "SELECT COUNT(*) FROM `user`";

    try
    {
        $stmt = $conn->query($sql);
        return $stmt->fetchColumn();
    }
    catch(PDOException $exception)
    {
        throw $exception;
    }
}

function getLimitedUsers($conn, $c_page, $rop) {
    $sql = "SELECT `email`, `first_name` FROM `user` ORDER BY `email` LIMIT {$c_page},{$rop}";

    try
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    catch(PDOException $exception)
    {
        throw $exception;
    }
}
