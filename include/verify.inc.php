<?php
require_once '../include/dbc.inc.php';
require_once '../include/function.inc.php';

if(isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];

}else{
    die("ERROR KEY WRONG");
}
include_once 'header.php';

include_once 'footer.php';