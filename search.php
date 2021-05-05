<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include\search.inc.php';

$alertType = '';
$errorMsg = '';

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
                <?php echo "<div class='$alertType' role='alert'>$errorMsg</div>"; ?>
                <button class="w-100 btn btn-primary btn-lg" type="submit" name="search">Search</button>
            </form>
            <?php if (isset($users)): ?>
            <br>
            <div class="form-row">
            <table class="table table-bordered table-hover" style="width: 1408px;">
                <th style="text-align: center; " colspan="3">
                    <div class="th-inner ">LIST PERSONS</div>
                    <div class="fht-cell"></div>
                </th>
                <tr>
                    <th style="text-align: center">E-Mail</th>
                    <th style="text-align: center">Name</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><a href=details.php?email=<?php echo $user['email']; ?>><?php echo $user['email']; ?></a></td>
                        <td><?php echo $user['first_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            </div>
<?php endif; ?>
        </div>
    </main>
<?php
include_once 'footer.php';