<?php
include_once 'header.php';
?>
<link href="assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<main class="form-signin">
    <form name="signupForm" id="signupForm" action="include/signup.inc.php" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Please Sign Up</h1>

        <div class="form-floating">
            <label class="sr-only" for="email">Email address</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Email/Username" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="repeat_password">Repeat Password</label>
            <input class="form-control" type="password" name="repeat_password" id="repeat_password"
                   placeholder="Repeat Password" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="first_name">Firstname</label>
            <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Firstname" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="given_name">Givenname</label>
            <input class="form-control" type="text" name="given_name" id="given_name" placeholder="Givenname" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="street_name">Street</label>
            <input class="form-control" type="text" name="street_name" id="street_name" placeholder="Street" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="street_number">Number</label>
            <input class="form-control" type="text" name="street_number" id="street_number" placeholder="Streetnumber"
                   required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="post_code">Postcode</label>
            <input class="form-control" type="number" name="post_code" id="post_code" placeholder="Postcode" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="city">City</label>
            <input class="form-control" type="text" name="city" id="city" placeholder="City" required>
        </div>
        <div class="form-floating">
            <label class="sr-only" for="phone_number">Phonenumber</label>
            <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Phonenumber"
                   required>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup">Sign Up</button>
        <p class="mt-5 mb-3 text-muted text-center">Already have an account?</p>
        <a class="nav-link" href="login.php">Log in Here</a>

    </form>
    <?php
    if (isset($_GET['error'])) {

        if ($_GET['error'] == 'emptyInput') {
            echo '<p class="text-danger">Fill in all fields!</p>';
        } else if ($_GET['error'] == 'emailAlreadyExists') {
            echo '<p class="text-danger">This email is already in use!</p>';
        } else if ($_GET['error'] == 'passwordDontMatch') {
            echo '<p class="text-danger">Passwords dont match!</p>';
        } else if ($_GET['error'] == 'invalidPassword') {
            echo '<p class="text-danger"Your password must contain at least one number, one uppercase letter and one lowercase letter</p>';
        } else if ($_GET['error'] == 'invalidName') {
            echo '<p class="text-danger">The name must contain only Letters and at least 2 characters</p>';
        } else if ($_GET['error'] == 'invalidNumber') {
            echo '<p class="text-danger">Numbers cant be letters/p>';
        } else if ($_GET['error'] == 'invalidStringLen') {
            echo '<p class="text-danger">The name must be at least two characters long</p>';
        } else if ($_GET['error'] == 'stmtfailed') {
            echo '<p class="text-danger">Something went wrong!</p>';
        } else if ($_GET['error'] == 'none') {
            echo '<p>You have signed up, please check your emails and verify your account</p>';
        }
    }
    ?>
<?php
include_once 'footer.php';
?>


