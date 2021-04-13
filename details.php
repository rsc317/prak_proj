<?php
include_once 'header.php';
include_once 'sidenav.php';
?>
    <section>
        <h2>User Data</h2>
        <div id="error"></div>
        <form name="myDataForm" id="myDataForm" action="include/mydata.inc.php" method="post">

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" placeholder="">

            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="password">

            <label for="repeat_password">Repeat Password</label>
            <input type="text" name="repeat_password" id="repeat_password" placeholder="password">

            <label for="first_name">Firstname</label>
            <input type="text" name="first_name" id="first_name" placeholder="">

            <label for="given_name">Givenname</label>
            <input type="text" name="given_name" id="given_name" placeholder="">

            <label for="street_name">Street</label>
            <input type="text" name="street_name" id="street_name"
                   placeholder="">

            <label for="street_number">Number</label>
            <input type="text" name="street_number" id="street_number"
                   placeholder="">

            <label for="post_code">Postcode</label>
            <input type="number" name="post_code" id="post_code" placeholder="">

            <label for="city">City</label>
            <input type="text" name="city" id="city" placeholder="">

            <label for="phone_number">Phonenumber</label>
            <input type="number" name="phone_number" id="phone_number"
                   placeholder="">

            <label for="active">Active</label>
            <input type="number" name="active" id="active"
                   placeholder="">

            <label for="rights">Rights</label>
            <input type="number" name="rights" id="rights"
                   placeholder="">

            <button type="submit" name="update">Update</button>
            <br>
        </form>
    </section>
<?php
include_once 'footer.php';