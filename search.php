<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include\search.inc.php';

if (isset($_GET['error'])) {
    $errorTypeAndAlert = getErrorMsgAndType($_GET['error']);
    [$errorMsg, $alertType] = $errorTypeAndAlert;

}

?>
    <main>
        <div class="container">

            <h1 class="mb-3">Search</h1>
            <form name="searchForm" id="searchForm" action="include/search.inc.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="email">E-Mail</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email/Username">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="first_name">Firstname</label>
                        <input class="form-control" type="text" name="first_name" id="first_name"
                               placeholder="Firstname">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="given_name">Givenname</label>
                        <input class="form-control" type="text" name="given_name" id="given_name"
                               placeholder="Givenname">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="street_name">Street</label>
                        <input class="form-control" type="text" name="street_name" id="street_name"
                               placeholder="Street">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="city">City</label>
                        <input class="form-control" type="text" name="city" id="city" placeholder="City">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="phone_number">Phonenumber</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                               placeholder="Phonenumber">
                    </div>
                </div>
                <?php if (isset($alertType) && ($errorMsg)): ?>
                    <div class='form-row'>
                        <div class="form-group col-md-12">
                            <div class='<?php echo $alertType ?>' role='alert'><?php echo $errorMsg ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <button class="w-100 btn btn-primary btn-lg" type="submit" name="search">Search</button>
            </form>
        </div>
    </main>
<?php
include_once 'footer.php';