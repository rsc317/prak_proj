<?php
require_once 'dbc.inc.php';
require_once 'functions.inc.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $user_data = getDataByEmail($conn, $email);

}

else {
    header("location: ../login.php");
    exit();
}
