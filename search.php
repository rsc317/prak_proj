<?php
include_once 'header.php';
include_once 'sidenav.php';
?>
    <h2>Search</h2>
    <div id="error"></div>
    <form name="searchForm" id="searchForm" action="include/search.inc.php" method="post">

        <label for="email">E-Mail</label>
        <input type="email" name="email" id="email" placeholder="Email/Username">

        <label for="first_name">Firstname</label>
        <input type="text" name="first_name" id="first_name" placeholder="Firstname">

        <label for="given_name">Givenname</label>
        <input type="text" name="given_name" id="given_name" placeholder="Givenname">

        <label for="street_name">Street</label>
        <input type="text" name="street_name" id="street_name" placeholder="Street">

        <label for="city">City</label>
        <input type="text" name="city" id="city" placeholder="City">

        <label for="phone_number">Phonenumber</label>
        <input type="text" name="phone_number" id="phone_number" placeholder="Phonenumber">

        <button type="submit" name="search">Search</button>
        <br>
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
include_once 'footer.php';