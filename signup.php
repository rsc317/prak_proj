<?php
include_once 'header.php';
require_once 'include/signup.inc.php';

if (isset($_SESSION['loggedUser'])) {
    header("location: ../mydata.php");
    exit();
}

$alertType = '';
$errorMsg = '';

if (isset($_GET['error'])) {
    $errorTypeAndAlert = getErrorMsgAndType($_GET['error']);
    [$errorMsg, $alertType] = $errorTypeAndAlert;

}
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
            <input class="form-control" type="text" name="post_code" id="post_code" placeholder="Postcode" required>
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
        <?php echo "<div class='$alertType' role='alert'>$errorMsg</div>"; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup">Sign Up</button>
        <p class="mt-5 mb-3 text-muted text-center">Already have an account?</p>
        <a class="nav-link" href="login.php">Log in Here</a>

    </form>
    <?php
    include_once 'footer.php';
    ?>


