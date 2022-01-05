<?php
include('config.php');
    $delete_id=$_GET['dlt_id'];
    $sql ="delete from team_sizes where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();
header("location:team_sizes.php");

?>



