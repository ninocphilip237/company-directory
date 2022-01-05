<?php
include('config.php');
    $delete_id=$_REQUEST['dlt_id'];
    $sql ="delete from company_customers_map where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();

?>



