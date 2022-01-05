<?php
include 'admin/config.php';
session_start();

if(isset($_POST['sval'])){
    $set = $_POST['sval'];

    $_SESSION["skip"] = $set;

}



?>