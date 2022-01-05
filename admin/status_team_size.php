<?php
include('config.php');
    $status_id=$_GET['id'];
	$status = $_GET['flag'];
   echo $sql ="UPDATE team_sizes SET status='".$status."' WHERE id='".$status_id."'";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
    header("location:team_sizes.php");

?>
 