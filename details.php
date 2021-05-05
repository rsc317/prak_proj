<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/details.inc.php';

$alertType = '';
$errorMsg = '';

if(!isset($user))
{
    header("location: ../listpersons.php?error=stmtFailed");
    exit();
}
if (isset($_GET['error'])) {
    $errorTypeAndAlert = getErrorMsgAndType($_GET['error']);
    [$errorMsg, $alertType] = $errorTypeAndAlert;

}
?>
    <main>
        <div class="container">
            <br>
            <h1><?php echo $user->getFirstName()." ". $user->getGivenName() . " is Active: " . $user->isActive(); ?></h1>
            <form name="myDataForm" id="myDataForm" action="include/details.inc.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="email">E-Mail</label>
                        <?php
                        if (3 == $loggedUser->getRights()|| 2 == $loggedUser->getRights()) {
                            echo "<input class='form-control' type='email' name'email' id='email' placeholder='".$user->getEmail()."'>";
                        } else {
                            echo "<a>".$user->getEmail()."</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (3 == $loggedUser->getRights()) {
                    echo '            <div class="form-row"><div class="form-group col-md-6"> 
                <label class="sr-only"  for="password">Password</label>
                <input class="form-control" type="text" name="password" id="password" placeholder="Password">
            </div>

            <div class="form-group col-md-6"> 
                <label class="sr-only"  for="repeat_password">Repeat Password</label>
                <input class="form-control" type="text" name="repeat_password" id="repeat_password"
                       placeholder="Repeat Password">
            </div>
            </div>';
                }
                ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="first_name">Firstname</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="first_name" id="first_name" placeholder="' . $user->getFirstName() . '">';
                        } else {
                            echo '<a>' . $user->getFirstName() . '</a>';
                        }
                        ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="given_name">Givenname</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="given_name" id="given_name" placeholder="' . $user->getGivenName() . '">';
                        } else {
                            echo '<a>' . $user->getGivenName() . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label class="sr-only" for="street_name">Street</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="street_name" id="street_name"
                       placeholder="' . $user->getStreetName() . '">';
                        } else {
                            echo '<a>' . $user->getStreetName() . '</a>';
                        }
                        ?>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="sr-only" for="street_number">Number</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="street_number" id="street_number"
                       placeholder="' . $user->getStreetNumber() . '">';
                        } else {
                            echo '<a>' . $user->getStreetNumber() . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label class="sr-only" for="post_code">Postcode</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="post_code" id="post_code" placeholder="' . $user->getPostCode() . '">';
                        } else {
                            echo '<a>' . $user->getPostCode() . '</a>';
                        }
                        ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="sr-only" for="city">City</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="city" id="city" placeholder="' . $user->getCity() . '">';
                        } else {
                            echo '<a>' . $user->getCity() . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label class="sr-only" for="phone_number">Phonenumber</label>
                        <?php
                        if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                            echo '<input class="form-control" type="text" name="phone_number" id="phone_number"
                       placeholder="' . $user->getPhoneNumber() . '">';
                        } else {
                            echo '<a>' . $user->getPhoneNumber() . '</a>';
                        }
                        ?>
                    </div

                <?php
                if (3 == $loggedUser->getRights()) {
                    echo "
                <div class='form-row'>
                    <div class='form-group col-md-3'>
                        <label class='sr-only' for='rights'>Rights</label>
                        <select class='form-control' name='rights' id='rights'>
                            <option value=3>Admin</option>
                            <option value=2>Super User</option>
                            <option value=1>Basic User</option>
                        </select>
                    </div>
                </div>";
                }
                ?>
                    <?php echo"<div class='form-row'><div class='$alertType' role='alert'>$errorMsg</div></div>"; ?>
                <div class="form-row">

                <?php
                if (3 == $loggedUser->getRights() || 2 == $loggedUser->getRights()) {
                    echo '<div class="form-group col-md-6"><button class="w-100 btn btn-primary btn-lg" type="submit" name="update">Update</button></div>';
                }
                if (3 == $loggedUser->getRights()) {
                    echo '<div class="form-group col-md-6"><button class="w-100 btn btn-primary btn-lg" type="submit" name="delete">Delete</button></div>';
                }
                ?>
                </div>
            </form>
        </div>
    </main>
<?php
include_once 'footer.php';