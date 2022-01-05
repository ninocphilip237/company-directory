<?php
include('config.php');


    $status_id=$_GET['id'];
	$status = $_GET['flag'];
    $sql ="UPDATE hourly_rates SET status='".$status."' WHERE id='".$status_id."'";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
    header("location:hourly_rates.php");

?>
