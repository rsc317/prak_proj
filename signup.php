<?php
include_once 'header.php';

?>
    <section>
        <h2>Sign Up</h2>
        <div id="error"></div>
        <form name="signupForm" id="signupForm" action="include/signup.inc.php" method="post">
            
                <label class="sr-only" for="email">E-Mail</label>
                <input class="form-control"type="email" name="email" id="email" placeholder="Email/Username" required>
            
            
               <label class="sr-only" for="password">Password</label>
                <input class="form-control"type="password" name="password" id="password" placeholder="Password" required>
            
            
               <label class="sr-only"for="repeat_password">Repeat Password</label>
                <input class="form-control"type="password" name="repeat_password" id="repeat_password" placeholder="Password" required>
            
            
               <label class="sr-only"for="first_name">Firstname</label>
                <input class="form-control"type="text" name="first_name" id="first_name" placeholder="Firstname" required>
            
            
               <label class="sr-only"for="given_name">Givenname</label>
                <input class="form-control"type="text" name="given_name" id="given_name" placeholder="Givenname" required>
            
            
               <label class="sr-only"for="street_name">Street</label>
                <input class="form-control"type="text" name="street_name" id="street_name" placeholder="Street" required>
            
            
               <label class="sr-only"for="street_number">Number</label>
                <input class="form-control"type="text" name="street_number" id="street_number" placeholder="Streetnumber" required>
            
            
               <label class="sr-only"for="post_code">Postcode</label>
                <input class="form-control"type="number" name="post_code" id="post_code" placeholder="Postcode" required>
            
            
               <label class="sr-only"for="city">City</label>
                <input class="form-control"type="text" name="city" id="city" placeholder="City" required>
            
            
               <label class="sr-only"for="phone_number">Phonenumber</label>
                <input class="form-control"type="number" name="phone_number" id="phone_number" placeholder="Phonenumber" required>
            


            <button class="btn btn-lg btn-primary btn-block"  type="submit" name="signup">Sign Up</button>
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
                echo '<p>You have signed up</p>';
            }
        }
        ?>
    </section>

<?php
include_once 'footer.php';
