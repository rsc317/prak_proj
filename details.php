<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/details.inc.php';

if (!isset($user)) {
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
            <h1><?php echo $firstName . " " . $givenName . " is Active: " . $user->isActive(); ?></h1>
            <br>
            <form name="myDataForm" id="myDataForm" action="include/details.inc.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="email">E-Mail</label>
                            <input class="form-control" type="text" name="email" id="emial"
                                   placeholder="<?php echo $email?>">
                        <?php else: ?>
                            <h2><?php echo $email ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (3 == $loggedUsersRgihts): ?>
                    <div class="form-row">
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
                <?php endif ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="first_name">Firstname</label>
                            <input class="form-control" type="text" name="first_name" id="first_name"
                                   placeholder="<?php echo $firstName ?>">
                        <?php else: ?>
                            <h2><?php echo $firstName ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-6">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="given_name">Givenname</label>
                            <input class="form-control" type="text" name="given_name" id="given_name"
                                   placeholder="<?php echo $givenName ?>">
                        <?php else: ?>
                            <h2><?php echo $givenName ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="street_name">Street</label>
                            <input class="form-control" type="text" name="street_name" id="street_name"
                                   placeholder="<?php echo $streetName ?>">
                        <?php else: ?>
                            <h2><?php echo $streetName ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-3">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="street_number">Number</label>
                            <input class="form-control" type="text" name="street_number" id="street_number"
                                   placeholder="<?php echo $streetNumber ?>">
                        <?php else: ?>
                            <h2><?php echo $streetNumber ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="post_code">Postcode</label>
                            <input class="form-control" type="text" name="post_code" id="post_code"
                                   placeholder="<?php echo $postCode ?>">
                        <?php else: ?>
                            <h2><?php echo $postCode ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="city">City</label>
                            <input class="form-control" type="text" name="city" id="city"
                                   placeholder="<?php echo $city ?>">
                        <?php else: ?>
                            <h2><?php echo $city ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                            <label class="sr-only" for="phone_number">Phonenumber</label>
                            <input class="form-control" type="text" name="phone_number" id="phone_number"
                                   placeholder="<?php echo $phoneNumber ?>">
                        <?php else: ?>
                            <h2><?php echo $phoneNumber ?></h2>
                        <?php endif; ?>
                    </div>
                    <?php if (3 == $loggedUsersRgihts): ?>
                        <div class='form-group col-md-3'>
                            <label class='sr-only' for='rights'>Rights</label>
                            <select class='form-control' name='rights' id='rights'>
                                <option value="" selected disabled hidden>

                                </option>
                                <option value=3>Admin</option>
                                <option value=2>Super User</option>
                                <option value=1>Basic User</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (isset($alertType) && ($errorMsg)): ?>
                    <div class='form-row'>
                        <div class="form-group col-md-12">
                            <div class='<?php echo $alertType ?>' role='alert'><?php echo $errorMsg ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-row">
                    <?php if (3 == $loggedUsersRgihts || 2 == $loggedUsersRgihts): ?>
                        <div class="form-group col-md-6">
                            <button class="w-100 btn btn-primary btn-lg" type="submit" name="update">Update</button>
                        </div>
                    <?php endif; ?>
                    <?php if (3 == $loggedUsersRgihts): ?>
                        <div class="form-group col-md-6">
                            <button class="w-100 btn btn-primary btn-lg" type="submit" name="delete">Delete</button>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </main>
<?php
include_once 'footer.php';