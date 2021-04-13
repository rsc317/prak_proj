<?php
include_once 'sidenav.php'
?>

<div id="main">
    <?php
    $name = $_SESSION['first_name'];
    $family_name = $_SESSION['given_name'];
    echo "<h1> Willkommen $name $family_name</h1>"
    ?>
</div>