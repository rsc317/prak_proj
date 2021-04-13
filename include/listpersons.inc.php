<?php
require_once 'dbc.inc.php';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$rop = 5;
$c_page = ($page - 1) * $rop;

$result = getLimitedUsers($conn, $c_page, $rop);
$total_pages = getTotalNumberOfUsers($conn);

function getTotalNumberOfUsers($conn) { //total_pages
    $sql = "SELECT COUNT(*) FROM `user`";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt)->fetch_row();

    return $result[0];
}

function getLimitedUsers($conn, $c_page, $rop) {
    $sql = "SELECT `email`, `first_name` FROM `user` ORDER BY `email` LIMIT {$c_page},{$rop}";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}
