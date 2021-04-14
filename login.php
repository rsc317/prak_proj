<?php
include_once 'header.php';
?>
    <form name="loginForm" id="loginForm" action="include/login.inc.php" method="post">
        <h1>Login</h1>
        <div class="form-group">
            <label for="email">E-Mail</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Email/Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <button class="btn btn-primary" type="submit" name="login">Login</button>
        <br>
    </form>
<?php
if (isset($_GET['error'])) {

    if ($_GET['error'] == 'emptyInput') {
        echo '<p class="text-danger">Fill in all fields!</p>';
    } else if ($_GET['error'] == 'invalidLogin') {
        echo '<p class="text-danger">User data is invalid</p>';
    } else if ($_GET['error'] == 'stmtfailed') {
        echo '<p class="text-danger">Something went wrong!</p>';
    } else if ($_GET['error'] == 'none') {
        echo '<p class="text-danger">You have loged in</p>';
    }
}
?>
<?php
include_once 'footer.php';