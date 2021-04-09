<?php
include_once 'header.php';

require_once 'include/dbc.inc.php';
require_once 'include/verify.inc.php';

if(isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    if(verifyEmail($conn,$vkey)) {
        header('location:../verified.php');
    }
    else {
        header('location:../signup.php');
    }
}
include_once 'footer.php';