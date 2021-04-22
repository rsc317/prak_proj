<?php
include_once 'sidenav.php';
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
                               placeholder="Email address">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="password">Password</label>
                        <input class="form-control" type="text" name="password" id="password"
                               placeholder="Password">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="repeat_password">Repeat Password</label>
                        <input class="form-control" type="text" name="repeat_password" id="repeat_password"
                               placeholder="Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="first_name">Firstname</label>
                        <input class="form-control" type="text" name="first_name" id="first_name"
                               placeholder="<?php echo $_SESSION['first_name']; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="given_name">Givenname</label>
                        <input class="form-control" type="text" name="given_name" id="given_name"
                               placeholder="<?php echo $_SESSION['given_name']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="phone_number">Phonenumber</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                               placeholder="<?php echo $_SESSION['phone_number']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label class="sr-only" for="street_name">Street</label>
                        <input class="form-control" type="text" name="street_name" id="street_name"
                               placeholder="<?php echo $_SESSION['street_name']; ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <div class="form-group">
                            <label class="sr-only" for="street_number">Number</label>
                            <input class="form-control" type="number" name="street_number" id="street_number"
                                   placeholder="<?php echo $_SESSION['street_number']; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="sr-only" for="post_code">Postcode</label>
                        <input class="form-control" type="number" name="post_code" id="post_code"
                               placeholder="<?php echo $_SESSION['post_code']; ?>">
                    </div>
                    <div class="form-group col-md-8">
                        <label class="sr-only" for="city">City</label>
                        <input class="form-control" type="text" name="city" id="city"
                               placeholder="<?php echo $_SESSION['city']; ?>">
                    </div>
                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit" name="update">Update</button>
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
        </div>
    </main>
<?php
include_once 'footer.php';