<?php
    require 'connection.php';

    //@submit(...) will check the given Data and enter it into the database if conditions are passed @TODO implement better Error Messages
    function submit($email, $password, $repeat_password, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer){
        global $db;

        if(emailIsUsed($email)) {
            if (passwordMatches($password, $repeat_password)) {
                $hash_password = hashPassword($password);

                $admin = 0;
                $su = 0;
                $bu = 1;
                $id = createUniqueID();

                $insert_rights = $db->prepare("INSERT INTO rights(id, admin, super_user, basic_user) VALUES(?,?,?,?)");
                $insert_rights->bind_param('siii', $id,$admin,$su,$bu);
                $insert_rights->execute();

                if($insert_rights !== false){
                    $insert_rights->close();

                    $insert = $db->prepare("INSERT INTO user(id, email, first_name, given_name, street_name, street_number, post_code, city, phone_number, password, rights) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                    $insert->bind_param('sssssiisisi', $id, $email, $first_name, $given_name, $street_name, $street_number, $post_code, $city, $phone_numer, $hash_password, $id);
                    $insert->execute();

                    if($insert !== false){
                        $insert->close();
                    }

                    else{
                        echo "ERROR";
                    }
                }
                else{
                    echo "ERROR";
                }
            }

            else {
                echo "Password does not match";
            }
        }

        else{
            echo "E-Mail address is already in use";
        }
    }

    //@hashPassword($password) will hash the password @TODO hash with blowfish
    function hashPassword($password): string{
        return md5($password);
    }

    //@passwordMatches(...) will check if password matches and returns a boolean
    function passwordMatches($password, $repeat_password): bool{
        return $password == $repeat_password;
    }

    //@emailIsUsed($email) will check if the email adresse is already in use and returns a boolean
    function emailIsUsed($email): bool{
        global $db;
        $search_user = $db->prepare("SELECT id FROM user WHERE email = ?");
        $search_user->bind_param('s',$email);
        $search_user->execute();
        $search_result = $search_user->get_result();

        return $search_result->num_rows == 0;
    }

    //@createUniqueID creates an unique 16 digits id and returns the id as a string @TODO research for better method
    function createUniqueID(): string
    {
        $bytes = random_bytes(16);
        return bin2hex($bytes);
    }