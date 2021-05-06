<?php
//@TODO have to fix the issue with redirecting with values
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

if(isset($_POST['search'])) {

    $values = $_POST;

    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../search.php?error=' . $error);
            exit();
        }

        $stmt = getUsersBySearch($conn, $values);
        if($stmt->rowCount()) {
            searchResult($stmt);
        }
        else
        {
            header('location: ../search.php?error=stmtFailed');
            exit();
        }
    }

    catch (Exception $e) {
        header('location: ../search.php?error=stmtFailed');
        exit();
    }

}

function searchResult($stmt){
    while ($user = $stmt->fetch()){
        $email = $user['email'];
        $firstName = $user['first_name'];
        echo "<tr>
                  <td>
                        <a href=details.php?email='$email'>$email</a>
                  </td>
                  <td>$firstName</td>
                            </tr>";
    }
}