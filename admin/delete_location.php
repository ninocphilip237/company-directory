<?php
session_start();
$delete_id = $l_image = '';
include('config.php');
$delete_id=$_GET['dlt_id'];

$sql10 ="SELECT * FROM `company_location_map` WHERE location_id=:id";
$query10= $conn -> prepare($sql10);
$query10-> bindParam(':id', $delete_id);
$query10-> execute();
if($query10->rowCount() > 0)
{
    echo "<script type=text/javascript>";
    echo "alert('Delete Failed...Location is Already in use...!');";
    echo "document.location.href='locations.php'";
    echo"</script>";
    exit;
}

if(isset($_SESSION['userlogin'])){
    if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.location.href='index.php'";
      echo"</script>";
      exit();
    }
    }
    
    $sqls ="SELECT * FROM locations WHERE id=:id";
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
        $filename = "uploads/locations/".$l_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }

    
    $sql ="delete from locations where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();
header("location:locations.php");

?>



