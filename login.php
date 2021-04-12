<?php
    include_once 'header.php';
?>
    <section>
        <form name="loginForm" id="loginForm" action="include/login.inc.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
            <label class="sr-only" for="email">E-Mail</label>
            <input type="email" name="email" id="email" placeholder="Email/Username" class="form-control" required autofocus>
            <label class="sr-only" for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required autofocus>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button><br>
        </form>
        <?php
        if(isset($_GET['error'])) {

            if($_GET['error'] == 'emptyInput') {
                echo '<p class="text-danger">Fill in all fields!</p>';
            }
            else if  ($_GET['error'] == 'invalidLogin') {
                echo '<p class="text-danger">User data is invalid</p>';
            }
            else if  ($_GET['error'] == 'stmtfailed') {
                echo '<p class="text-danger">Something went wrong!</p>';
            }
            else if  ($_GET['error'] == 'none') {
                echo '<p class="text-danger">You have loged in</p>';
            }
        }
        ?>
    </section>
<?php
    include_once 'footer.php';