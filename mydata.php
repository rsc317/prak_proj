<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/mydata.inc.php';
?>
    <main>
        <div class="container">
            <br>
            <h1 class="mb-3">My Data</h1>
            <form name="myDataForm" id="myDataForm" action="include/mydata.inc.php"
                  method="post">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="email">E-Mail</label>
                        <input class="form-control" type="email" name="email" id="email"
                               placeholder="<?php echo $email ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="password">Password</label>
                        <input class="form-control" type="text" name="password" id="password"
                               placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="repeat_password">Repeat Password</label>
                        <input class="form-control" type="text" name="repeatPassword" id="repeat_password"
                               placeholder="Repeat Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="first_name">Firstname</label>
                        <input class="form-control" type="text" name="firstName" id="first_name"
                               placeholder="<?php echo $firstName; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="given_name">Givenname</label>
                        <input class="form-control" type="text" name="givenName" id="given_name"
                               placeholder="<?php echo $givenName; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="phone_number">Phonenumber</label>
                        <input class="form-control" type="text" name="phoneNumber" id="phone_number"
                               placeholder="<?php echo $phoneNumber; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label class="sr-only" for="street_name">Street</label>
                        <input class="form-control" type="text" name="streetName" id="street_name"
                               placeholder="<?php echo $streetName; ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <div class="form-group">
                            <label class="sr-only" for="street_number">Number</label>
                            <input class="form-control" type="text" name="streetNumber" id="street_number"
                                   placeholder="<?php echo $streetNumber; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="sr-only" for="post_code">Postcode</label>
                        <input class="form-control" type="text" name="postCode" id="post_code"
                               placeholder="<?php echo $postCode; ?>">
                    </div>
                    <div class="form-group col-md-8">
                        <label class="sr-only" for="city">City</label>
                        <input class="form-control" type="text" name="city" id="city"
                               placeholder="<?php echo $city; ?>">
                    </div>
                </div>
                    <?php
                    $errorMsg = "";
                    if ($errorMsg)
                    {
                        $alertType = 'alert alert-warning';
                        if('User update succeed' == $errorMsg){
                            $alertType = 'alert alert-success';
                        }
                        echo"<div class='$alertType' role='alert'>$errorMsg</div>";
                    }
                    ?>
                <button class="w-100 btn btn-primary btn-lg" type="submit" name="update">Update</button>
            </form>
        </div>
    </main>
<?php

if (isset($_GET['error'])) {
    $errorMsg = match ($_GET['error']) {
        'emailAlreadyExists' => 'This email is already in use!',
        'passwordDontMatch' => 'Passwords dont match!',
        'invalidPassword' => 'Your password must contain at least one number, one uppercase letter and one lowercase letter',
        'invalidName' => 'The name must contain only Letters and must be at least two characters long',
        'invalidNumber' => 'Numbers cant be letters',
        'stmtFailed' => 'Something went wrong!',
        'none' => 'User update succeed',
        default => "",
    };
}
include_once 'footer.php';