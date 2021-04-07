<?php
    include_once 'header.php';
?>
    <section>
        <h2>Sign Up</h2>
        <form action="include/login.inc.php" method="post">
            Username:<br>
            <label>
                <input type="email" name="email" placeholder="Email">
            </label><br>
            Password:<br>
            <label>
                <input type="password" name="password" placeholder="Password">
            </label><br>

            <button type="submit" name="login">Login</button><br>
        </form>
    </section>
<?php
    include_once 'footer.php';