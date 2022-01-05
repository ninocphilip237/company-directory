<?php
include('config.php');
    $delete_id=$_GET['dlt_id'];
    $sql ="delete from hourly_rates where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();
header("location:hourly_rates.php");

?>



