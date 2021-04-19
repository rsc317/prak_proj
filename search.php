<?php
include_once 'sidenav.php';
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
                        <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Firstname">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="given_name">Givenname</label>
                        <input class="form-control" type="text" name="given_name" id="given_name" placeholder="Givenname">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="street_name">Street</label>
                        <input class="form-control" type="text" name="street_name" id="street_name" placeholder="Street">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="city">City</label>
                        <input class="form-control" type="text" name="city" id="city" placeholder="City">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="sr-only" for="phone_number">Phonenumber</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Phonenumber">
                    </div>
                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit" name="search">Search</button>
            </form>
            <?php
            if (isset($_GET['error'])) {

                if ($_GET['error'] == 'invalidName') {
                    echo '<p class="text-danger">The name must contain only Letters and at least 2 characters</p>';
                } else if ($_GET['error'] == 'invalidNumber') {
                    echo '<p class="text-danger">Numbers cant be letters/p>';
                } else if ($_GET['error'] == 'stmtfailed') {
                    echo '<p class="text-danger">Something went wrong!</p>';
                } else if ($_GET['error'] == 'noResult') {
                    echo '<p class="text-danger">No match found</p>';
                }
            }
            ?>
        </div>
    </main>
<?php

include_once 'footer.php';