<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/bootstrap.bundle.js"></script>
    <title>Web Anwendung</title>
</head>
<body>
<header>
    <nav>
                <?php
                if(isset($_SESSION["email"])){
                    echo'  <a href="index.php">Home</a> 
                           <a href="include/logout.inc.php">Logout</a> ';
                }
                else {
                    echo'  <a href="signup.php">Signup</a> 
                           <a href="login.php">Login</a> ';
                }
                ?>
    </nav>
</header>
