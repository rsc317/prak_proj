<?php
require_once '../include/dbc.inc.php';
require_once '../include/login.inc.php';

if(isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}