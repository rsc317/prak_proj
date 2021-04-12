<?php
    include_once 'header.php';
    ?>

<div class="form-group">
    <?php
    if(isset($_SESSION["id"])){
        include_once 'welcome.php';
    }
    else {
        include_once 'login.php';
    }
    ?>
</div>
<?php
    include_once 'footer.php';
    ?>