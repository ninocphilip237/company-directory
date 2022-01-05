<?php
$delete_id = $l_image = '';
include('config.php');

if(isset($_SESSION['userlogin'])){
    if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.company.href='index.php'";
      echo"</script>";
      exit();
    }
    }
   
    $delete_id=$_GET['dlt_id'];

    $sql10 ="SELECT * FROM `company_service_map` WHERE service_id=:id";
    $query10= $conn -> prepare($sql10);
    $query10-> bindParam(':id', $delete_id);
    $query10-> execute();
    if($query10->rowCount() > 0)
    {
        echo "<script type=text/javascript>";
        echo "alert('Delete Failed...Service is Already in use...!');";
        echo "document.location.href='services.php'";
        echo"</script>";
        exit;
    }



    $sqls ="SELECT * FROM services WHERE id=:id";
    $querys= $conn -> prepare($sqls);
    $querys-> bindParam(':id', $delete_id);
    $querys-> execute();
    $results=$querys->fetchAll();
	if($querys->rowCount() > 0)
    {
        foreach ($results as $data) {
		
			$l_image = $data['image'];
		
        }
    }

    if($l_image!=''){
        $filename = "uploads/services/".$l_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }

    
    $sql ="delete from services where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();
header("location:services.php");

?>
