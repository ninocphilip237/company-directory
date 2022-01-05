<?php
include('config.php');
    $status_id=$_REQUEST['id'];
    $status = $_REQUEST['flag'];
    // print_r($_REQUEST);
    $sql ="UPDATE company_portfolio_map SET status=:status WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
?>
