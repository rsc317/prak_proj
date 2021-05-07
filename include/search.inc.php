<?php
//@TODO have to fix the issue with redirecting with values
require_once 'connect.php';
require_once 'functions.inc.php';

if (!isset($_SESSION['loggedUser'])) {
    header("location: ../login.php");
    exit();
}

function getSearchResults($conn, $values)
{
    try {
        $error = invalidInputValues($conn, $values);

        if($error)
        {
            header('location: ../search.php?error=' . $error);
            exit();
        }

        $stmt = getUsersBySearch($conn, $values);
        if($stmt->rowCount()) {
            while ($user = $stmt->fetch()){
                $email = $user['email'];
                $firstName = $user['first_name'];
                echo "<tr>
                  <td>
                        <a href=details.php?email=$email>$email</a>
                  </td>
                  <td>$firstName</td>
                            </tr>";
            }
        }
        else
        {
            echo "No results found!";
        }
    }

    catch (Exception $e) {
        header('location: ../search.php?error=stmtFailed');
        exit();
    }
}
