<?php
include_once 'header.php';
include_once 'sidenav.php';

if(!isset($_SESSION['email'])){
    header("location: ../login.php");
    exit();
}
?>

    <section>
        <h2>User Data</h2>
        <div id="error"></div>
        <form name="myDataForm" id="myDataForm" action="include/mydata.inc.php" method="post">

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" placeholder="">

            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="password">

            <label for="repeat_password">Repeat Password</label>
            <input type="text" name="repeat_password" id="repeat_password" placeholder="password">

            <label for="first_name">Firstname</label>
            <input type="text" name="first_name" id="first_name" placeholder="<?php echo $_SESSION['first_name']; ?>">

            <label for="given_name">Givenname</label>
            <input type="text" name="given_name" id="given_name" placeholder="<?php echo $_SESSION['given_name']; ?>">

            <label for="street_name">Street</label>
            <input type="text" name="street_name" id="street_name"
                   placeholder="<?php echo $_SESSION['street_name']; ?>">

            <label for="street_number">Number</label>
            <input type="text" name="street_number" id="street_number"
                   placeholder="<?php echo $_SESSION['street_number']; ?>">

            <label for="post_code">Postcode</label>
            <input type="number" name="post_code" id="post_code" placeholder="<?php echo $_SESSION['post_code']; ?>">

            <label for="city">City</label>
            <input type="text" name="city" id="city" placeholder="<?php echo $_SESSION['city']; ?>">

            <label for="phone_number">Phonenumber</label>
            <input type="number" name="phone_number" id="phone_number"
                   placeholder="<?php echo $_SESSION['phone_number']; ?>">

            <button type="submit" name="update">Update</button>
            <br>
        </form>
        <?php
        if (isset($_GET['error'])) {

            if ($_GET['error'] == 'emailAlreadyExists') {
                echo '<p class="text-danger">This email is already in use!</p>';
            } else if ($_GET['error'] == 'passwordDontMatch') {
                echo '<p class="text-danger">Passwords dont match!</p>';
            } else if ($_GET['error'] == 'invalidPassword') {
                echo '<p class="text-danger">Your password must contain at least one number, one uppercase letter and one lowercase letter</p>';
            } else if ($_GET['error'] == 'invalidName') {
                echo '<p class="text-danger">The name must contain only Letters</p>';
            } else if ($_GET['error'] == 'invalidNumber') {
                echo '<p class="text-danger">Numbers cant be letters/p>';
            } else if ($_GET['error'] == 'invalidStringLen') {
                echo '<p class="text-danger">The name must be at least two characters long</p>';
            } else if ($_GET['error'] == 'stmtfailed') {
                echo '<p class="text-danger">Something went wrong!</p>';
            } else if ($_GET['error'] == 'none') {
                echo '<p>Data has changed</p>';
            }
        }
        ?>
    </section>
<?php
include_once 'footer.php';