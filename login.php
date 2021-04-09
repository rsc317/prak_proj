<?php
    include_once 'header.php';
?>
    <section>
        <h2>Login</h2>
        <form name="loginForm" id="loginForm" action="login.php" method="post">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" placeholder="Email/Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <button type="submit" name="login">Login</button><br>
        </form>
    </section>
<?php
    include_once 'footer.php';