<?php
require_once 'dbc.inc.php';

function getUsers($conn) {
    $sql = "SELECT `email`, `first_name`, `given_name` , `street_name`, `street_number`, `post_code`, `city`, `phone_number`, `active` FROM `user`";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

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
    $sql = "SELECT `email`, `first_name`, `given_name` , `street_name`, `street_number`, `post_code`, `city`, `phone_number`, `active` FROM `user` ORDER BY `email` LIMIT {$c_page},{$rop}";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}
