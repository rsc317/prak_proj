<?php
    if(!isset($_SESSION["email"])){
        header("location: ../login.php");
    }
    header("location: ../mydata.php");
