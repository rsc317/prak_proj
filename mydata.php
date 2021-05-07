<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/mydata.inc.php';

if (isset($_GET['error'])) {
    $errorTypeAndAlert = getErrorMsgAndType($_GET['error']);
    [$errorMsg, $alertType] = $errorTypeAndAlert;

}

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
                           placeholder="<?php echo $loggedUser->getEmail(); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label class="sr-only" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password"
                           placeholder="Password">
                </div>
                <div class="form-group col-md-6">
                    <label class="sr-only" for="repeat_password">Repeat Password</label>
                    <input class="form-control" type="password" name="repeat_password" id="repeat_password"
                           placeholder="Repeat Password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="sr-only" for="first_name">Firstname</label>
                    <input class="form-control" type="text" name="first_name" id="first_name"
                           placeholder="<?php echo $loggedUser->getFirstName(); ?>">
                </div>
                <div class="form-group col-md-12">
                    <label class="sr-only" for="given_name">Givenname</label>
                    <input class="form-control" type="text" name="given_name" id="given_name"
                           placeholder="<?php echo $loggedUser->getGivenName(); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="sr-only" for="phone_number">Phonenumber</label>
                    <input class="form-control" type="text" name="phone_number" id="phone_number"
                           placeholder="<?php echo $loggedUser->getPhoneNumber(); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-10">
                    <label class="sr-only" for="street_name">Street</label>
                    <input class="form-control" type="text" name="street_name" id="street_name"
                           placeholder="<?php echo $loggedUser->getStreetName(); ?>">
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <label class="sr-only" for="street_number">Number</label>
                        <input class="form-control" type="text" name="street_number" id="street_number"
                               placeholder="<?php echo $loggedUser->getStreetNumber(); ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="sr-only" for="post_code">Postcode</label>
                    <input class="form-control" type="text" name="post_code" id="post_code"
                           placeholder="<?php echo $loggedUser->getPostCode(); ?>">
                </div>
                <div class="form-group col-md-8">
                    <label class="sr-only" for="city">City</label>
                    <input class="form-control" type="text" name="city" id="city"
                           placeholder="<?php echo $loggedUser->getCity(); ?>">
                </div>
            </div>
            <?php if (isset($alertType) && ($errorMsg)): ?>
                <div class='form-row'>
                    <div class="form-group col-md-12">
                        <div class='<?php echo $alertType ?>' role='alert'><?php echo $errorMsg ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <button class="w-100 btn btn-primary btn-lg" type="submit" name="update">Update</button>
        </form>
    </div>
</main>
<?php
include_once 'footer.php';