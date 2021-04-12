<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/bootstrap.bundle.js"></script>
    <title>Web Anwendung</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark border-top bg-dark">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <?php
                if(isset($_SESSION["id"])){
                    echo'<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                         <li class="nav-item"><a class="nav-link" href="include/logout.inc.php">Logout</a></li>';
                }
                else {
                    echo'<li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
                         <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
<main role="main" class="container">
<div class="carousel slide">
    <div class="carousel-inner">