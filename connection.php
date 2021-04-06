<?php
$host = 'localhost';
$user_name = 'root';
$password = '';
$data_base = 'prak_proj';

$db = new mysqli($host,$user_name,$password,$data_base);

if($db->connect_error){
    echo $db->connect_error;
}