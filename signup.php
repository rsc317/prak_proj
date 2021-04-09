<?php
include_once 'header.php';

require_once 'include/signup.inc.php';
require_once 'include/dbc.inc.php';

if(isset($_POST['signup'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $given_name = $_POST['given_name'];
    $street_name =  $_POST['street_name'];
    $street_number = $_POST['street_number'];
    $post_code = $_POST['post_code'];
    $city = $_POST['city'];
    $phone_numer = $_POST['phone_number'];

    if (emptyInputSignUp($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer) !== false) {
        header('location: ../signup.php?error=emptyInput');
        exit();
    }

    if (invalidName($first_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($given_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if (invalidName($street_name) !== false) {
        header('location: ../signup.php?error=invalidName');
        exit();
    }

    if(invalidInputStringLen($first_name,$given_name,$street_name) !== false) {
        header('location: ../signup.php?error=invalidStringLen');
        exit();
    }

    if (invalidNumber($post_code) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidNumber($phone_numer) !== false) {
        header('location: ../signup.php?error=invalidNumber');
        exit();
    }

    if (invalidEmail($email) !== false) {
        header('location: ../signup.php?error=invalidEmail');
        exit();
    }

    if (emailIsUsed($conn, $email) !== false) {
        header('location: ../signup.php?error=emailAlreadyExists');
        exit();
    }

    if (passwordMatch($password, $repeat_password) !== false) {
        header('location: ../signup.php?error=passwordDontMatch');
        exit();
    }

    if(invalidPassword($password) !== false) {
        header('location: ../signup.php?error=invalidPassword');
        exit();
    }

    insertUser($conn, $email, $password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer);
}
?>
    <section>
        <h2>Sign Up</h2>
        <div id="error"></div>
        <form name="signupForm" id="signupForm" action="signup.php" method="post">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" placeholder="Email/Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form.group">
                <label for="repeat_password">Repeat Password</label>
                <input type="password" name="repeat_password" id="repeat_password" placeholder="Password" required>
            </div>
            <div class="form.group">
                <label for="first_name">Firstname</label>
                <input type="text" name="first_name" id="first_name" placeholder="Firstname" required>
            </div>
            <div class="form.group">
                <label for="given_name">Givenname</label>
                <input type="text" name="given_name" id="given_name" placeholder="Givenname" required>
            </div>
            <div class="form.group">
                <label for="street_name">Street</label>
                <input type="text" name="street_name" id="street_name" placeholder="Street" required>
            </div>
            <div class="form.group">
                <label for="street_number">Number</label>
                <input type="text" name="street_number" id="street_number" placeholder="Streetnumber" required>
            </div>
            <div class="form.group">
                <label for="post_code">Postcode</label>
                <input type="number" name="post_code" id="post_code" placeholder="Postcode" required>
            </div>
            <div class="form.group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" placeholder="City" required>
            </div>
            <div class="form.group">
                <label for="phone_number">Phonenumber</label>
                <input type="number" name="phone_number" id="phone_number" placeholder="Phonenumber" required>
            </div>


            <button type="submit" name="signup">Sign Up</button>
            <br>
        </form>
        <?php
        if(isset($_GET['error'])) {

            if($_GET['error'] == 'emptyInput') {
                echo '<p class="text-danger">Fill in all fields!</p>';
            }
            else if  ($_GET['error'] == 'emailAlreadyExists') {
                echo '<p class="text-danger">This email is already in use!</p>';
            }
            else if  ($_GET['error'] == 'passwordDontMatch') {
                echo '<p class="text-danger">Passwords dont match!</p>';
            }
            else if  ($_GET['error'] == 'invalidPassword') {
                echo '<p class="text-danger"Your password must contain at least one number, one uppercase letter and one lowercase letter</p>';
            }
            else if  ($_GET['error'] == 'invalidName') {
                echo '<p class="text-danger">The name must contain only Letters</p>';
            }
            else if  ($_GET['error'] == 'invalidNumber') {
                echo '<p class="text-danger">Numbers cant be letters/p>';
            }
            else if  ($_GET['error'] == 'invalidStringLen') {
                echo '<p class="text-danger">The name must be at least two characters long</p>';
            }
            else if  ($_GET['error'] == 'stmtfailed') {
                echo '<p class="text-danger">Something went wrong!</p>';
            }
            else if  ($_GET['error'] == 'none') {
                echo '<p class="text-danger">You have signed up</p>';
            }
        }
        ?>
    </section>

<?php
include_once 'footer.php';
