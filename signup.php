<?php
    include_once 'header.php';
?>
    <section>
        <h2>Sign Up</h2>
        <form action="include/signup.inc.php" method="post">
            E-Mail:<br>
            <label>
                <input type="email" name="email" placeholder="Email/Username">
            </label><br>
            Password:<br>
            <label>
                <input type="password" name="password" placeholder="Password">
            </label><br>
            Repeat Password:<br>
            <label>
                <input type="password" name="repeat_password" placeholder="Password">
            </label><br>
            Firstname:<br>
            <label>
                <input type="text" name="first_name" placeholder="Firstname">
            </label><br>
            Givenname:<br>
            <label>
                <input type="text" name="given_name" placeholder="Givenname">
            </label><br>
            Street:<br>
            <label>
                <input type="text" name="street_name" placeholder="Street">
            </label><br>
            Streetnumber:<br>
            <label>
                <input type="number" name="street_number" placeholder="Streetnumber">
            </label><br>
            Postcode:<br>
            <label>
                <input type="number" name="post_code" placeholder="Postcode">
            </label><br>
            City:<br>
            <label>
                <input type="text" name="city" placeholder="City">
            </label><br>
            Phonenumber:<br>
            <label>
                <input type="number" name="phone_number" placeholder="Phonenumber">
            </label><br>

            <button type="submit" name="submit">Sign Up</button> <br>
        </form>
    </section>
<?php
    include_once 'footer.php';
