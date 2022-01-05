<?php
include 'config.php';
$delete_id = $_REQUEST['dlt_id'];
$sql = "delete from users where id=:id";
$query = $conn->prepare($sql);
$query->bindParam(':id', $delete_id);
$query->execute();
header("location:users.php");