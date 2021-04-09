<?php

function verifyEmail($conn, $vkey) {
    $sql = "SELECT active, vkey FROM user WHERE active = ? AND vkey = ? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    $active = 0;

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtverifyemailfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is",$active, $vkey);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_fetch_assoc($result)){
        mysqli_stmt_close($stmt);
        return setUserActive($conn, $vkey);
    }
    else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function setUserActive($conn, $vkey) {
    $sql = "UPDATE USER SET active = ? WHERE vkey = ? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    $active = 1;

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtsetuseractivefailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is",$active, $vkey);
    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    }

    mysqli_stmt_close($stmt);
    return false;
}