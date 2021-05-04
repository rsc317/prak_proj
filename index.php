<?php
    if(!isset($_SESSION['loggedUser'])){
        header("location: ../login.php");
    }
    header("location: ../mydata.php");
