<?php
include('config.php');

if(isset($_SESSION['userlogin'])){
    if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.location.href='index.php'";
      echo"</script>";
      exit();
    }
    }

    $status_id=$_GET['id'];
    $status = $_GET['flag'];
    

    //Check Service Already Assigned to any company
    if($status==2){
    $sql10 ="SELECT * FROM `company_service_map` WHERE service_id=:id";
    $query10= $conn -> prepare($sql10);
    $query10-> bindParam(':id', $status_id);
    $query10-> execute();
    if($query10->rowCount() > 0)
    {
        echo "<script type=text/javascript>";
        echo "alert('Status Change Failed...Service is Already in use...!');";
        echo "document.location.href='services.php'";
        echo"</script>";
        exit;
    }
    
    }



    $sql ="UPDATE services SET status=:status WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
header("location:services.php");

?>
