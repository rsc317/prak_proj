<?php
include_once 'header.php';
?>
    <section>
        <h2>Sign Up</h2>
        <div id="error"></div>
        <form name="signupForm" id="signupForm" action="include/signup.inc.php" method="post">
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
    </section>
<?php
include_once 'footer.php';
