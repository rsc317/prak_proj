<?php
    require('register.php');
?>

<form action="" method="post">
    Username:<br>
    <input type="email" name="email" placeholder="Email"><br>
    Password:<br>
    <input type="password" name="password" placeholder="Password"><br>
    Repeat Password:<br>
    <input type="password" name="repeat_password" placeholder="Password"><br>
    Firstname:<br>
    <input type="text" name="first_name" placeholder="Firstname"><br>
    Givenname:<br>
    <input type="text" name="given_name" placeholder="Givenname"><br>
    Street:<br>
    <input type="text" name="street_name" placeholder="Street"><br>
    Streetnumber:<br>
    <input type="number" name="street_number" placeholder="Streetnumber"><br>
    Postcode:<br>
    <input type="number" name="post_code" placeholder="Postcode"><br>
    City:<br>
    <input type="text" name="city" placeholder="City"><br>
    Phonenumber:<br>
    <input type="number" name="phone_number" placeholder="Phonenumber"><br>

    <input type="submit" name="submit" placeholder="Submit"><br>
</form>

<?php
    if(isset($_POST['submit'])){
        submit($_POST['email'],$_POST['password'],$_POST['repeat_password'],$_POST['first_name'],$_POST['given_name'],$_POST['street_name'],$_POST['street_number'],$_POST['post_code'],$_POST['city'],$_POST['phone_number']);
    }
