<?php
include('config.php');
if(isset($_SESSION['userlogin'])){
    if($_SESSION['usertype'] != 'admin'){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.location.href='index.php'";
      echo"</script>";
      exit();
    }
    }
    $status_id=$_GET['id'];
	$status = $_GET['flag'];
    $sql ="UPDATE users SET user_status=:status WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $status_id);
	$query-> bindParam(':status', $status);
    $query-> execute();
header("location:users.php");

?>