<?php
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$rop = 3;
$c_page = ($page - 1) * $rop;

try {
    $result = getLimitedUsers($conn, $c_page, $rop);
    $total_pages = getTotalNumberOfUsers($conn);

} catch (Exception $e) {
    header('location: ../listpersons.php?error=stmtFailed');
    exit();
}

