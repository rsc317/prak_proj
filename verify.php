<?php
include_once 'header.php';

require_once 'include/connect.php';
require_once 'include/verify.inc.php';

if(isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    try{
        verifyEmail($conn,$vkey);
        header("location: ../verified.php?");
        exit();
    }
    catch(Exception $exception)
    {
        echo 'Exception caught: ', $exception->getMessage(), "\n";
        exit();
    }
}
include_once 'footer.php';