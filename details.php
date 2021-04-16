<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/details.inc.php';

if (!isset($_SESSION['email'])) {
    header("location: ../login.php");
    exit();
}
?>
    <h2><?php echo "$user_first_name $user_given_name". " is Active: ".$user_active; ?></h2>
    <div id="error"></div>
    <form name="myDataForm" id="myDataForm" action="include/details.inc.php" method="post">
        <div class="form-group row">
            <div class="col-xs-2">
                <label class="form-label" for="email">E-Mail</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo "<input class='form-control' type='email' name'email' id='email' placeholder='$user_email'>";
                } else {
                    echo "<a>$user_email</a>";
                }
                ?>
            </div>
            <?php
            if (isset($_SESSION['admin'])) {
                echo '            <div class="col-xs-2">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="text" name="password" id="password" placeholder="">
            </div>

            <div class="col-xs-2">
                <label class="form-label" for="repeat_password">Repeat Password</label>
                <input class="form-control" type="text" name="repeat_password" id="repeat_password"
                       placeholder="">
            </div>';
            }
            ?>
            <div class="col-xs-2">
                <label class="form-label" for="first_name">Firstname</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="text" name="first_name" id="first_name" placeholder="' . $user_first_name . '">';
                } else {
                    echo '<a>' . $user_first_name . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="given_name">Givenname</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="text" name="given_name" id="given_name" placeholder="' . $user_given_name . '">';
                } else {
                    echo '<a>' . $user_given_name . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="street_name">Street</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="text" name="street_name" id="street_name"
                       placeholder="' . $user_street_name . '">';
                } else {
                    echo '<a>' . $user_street_name . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="street_number">Number</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="text" name="street_number" id="street_number"
                       placeholder="' . $user_street_number . '">';
                } else {
                    echo '<a>' . $user_street_number . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="post_code">Postcode</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="number" name="post_code" id="post_code" placeholder="' . $user_post_code . '">';
                } else {
                    echo '<a>' . $user_post_code . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="city">City</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="text" name="city" id="city" placeholder="' . $user_city . '">';
                } else {
                    echo '<a>' . $user_city . '</a>';
                }
                ?>
            </div>
            <div class="col-xs-2">
                <label class="form-label" for="phone_number">Phonenumber</label>
                <?php
                if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
                    echo '<input class="form-control" type="number" name="phone_number" id="phone_number"
                       placeholder="' . $user_phone_number . '">';
                } else {
                    echo '<a>' . $user_phone_number . '</a>';
                }
                ?>
            </div
            <?php
            if (isset($_SESSION['admin'])){
                echo "<div class='col-xs-2'>
                    <label class='form-label' for='rights'>Rights</label>
                    <select class='form-control' name='rights' id='rights'>
                        <option value='none'>None</option>
                        <option value='admin'>Admin</option>
                        <option value='super_user'>Super User</option>
                        <option value='basic_user'>Basic User</option>
                    </select>
                </div>";
            }
            ?>

        </div>
        <?php
        if (isset($_SESSION['admin']) || isset($_SESSION['super_user'])) {
            echo '<button class="btn btn-primary btn-block mb-4" type="submit" name="update">Update</button>';
        }
        if (isset($_SESSION['admin'])) {
            echo '<button class="btn btn-primary btn-block mb-4" type="submit" name="delete">Delete</button>';
        }
        ?>
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
        echo '<p>Update successful</p>';
    }
}

include_once 'footer.php';