<?php
require_once 'include/functions.inc.php';

function verifyEmail($conn, $vkey) {
    try
    {
        $stmt = $conn->prepare("UPDATE user SET active=:active WHERE vkey =:vkey;");
        if(!$stmt->execute(['active' => 1, 'vkey' => $vkey]))
        {
            return false;
        }
        return $stmt->fetch();
    }
    catch(PDOException $exception)
    {
        throw $exception;
    }
}
