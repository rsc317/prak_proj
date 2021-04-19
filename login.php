<?php
include_once 'header.php';
?>
    <link href="assets/css/signin.css" rel="stylesheet">
    </head>
    <body class="text-center">
    <main class="form-signin">
            <form name="loginForm" id="loginForm" action="include/login.inc.php" method="post">
                <h1 class="h3 mb-3 font-weight-normal"> Please Login</h1>
                <div class="form-floating">
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email address"
                           required=""
                           autofocus="">
                    <label class="sr-only" for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"
                           required="">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
                <p class="mt-5 mb-3 text-muted text-center">Don't have an account?</p>
                <a class="nav-link" href="signup.php">Sign Up Here</a>
            </form>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyInput') {
                echo '<p class="text-danger">Fill in all fields!</p>';
            } else if ($_GET['error'] == 'invalidLogin') {
                echo '<p class="text-danger">User data is invalid</p>';
            } else if ($_GET['error'] == 'stmtfailed') {
                echo '<p class="text-danger">Something went wrong!</p>';
            }
        }
        ?>
    </main>
    </body>

<?php
include_once 'footer.php';