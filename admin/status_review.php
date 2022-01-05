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
    $sql ="UPDATE company_reviews_map SET status=:status WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
header("location:reviews.php");

?>