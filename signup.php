<?php
include_once 'header.php';
?>
    <section>
        <h2>Sign Up</h2>
        <div id="error"></div>
        <form name="signupForm" id="signupForm" action="include/signup.inc.php" method="post">

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" placeholder="Email/Username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <label for="repeat_password">Repeat Password</label>
            <input type="password" name="repeat_password" id="repeat_password" placeholder="Password" required>

            <label for="first_name">Firstname</label>
            <input type="text" name="first_name" id="first_name" placeholder="Firstname" required>

            <label for="given_name">Givenname</label>
            <input type="text" name="given_name" id="given_name" placeholder="Givenname" required>

            <label for="street_name">Street</label>
            <input type="text" name="street_name" id="street_name" placeholder="Street" required>

            <label for="street_number">Number</label>
            <input type="text" name="street_number" id="street_number" placeholder="Streetnumber" required>

            <label for="post_code">Postcode</label>
            <input type="number" name="post_code" id="post_code" placeholder="Postcode" required>

            <label for="city">City</label>
            <input type="text" name="city" id="city" placeholder="City" required>

            <label for="phone_number">Phonenumber</label>
            <input type="text" name="phone_number" id="phone_number" placeholder="Phonenumber" required>

            <button type="submit" name="signup">Sign Up</button>
            <br>
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
                echo '<p>You have signed up</p>';
            }
        }
        ?>
    </section>

<?php
include_once 'footer.php';
