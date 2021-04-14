<?php
require_once 'dbc.inc.php';
require_once 'functions.inc.php';

//TODO have to implement a way to parse the email address right
if (isset($_POST['delete'])) {
    deleteUser($conn, "test6@mail.com");
    header("location: ../listpersons.php?error=none");
    exit();
}