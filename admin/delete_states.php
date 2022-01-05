<?php
include 'config.php';
if(isset($_SESSION['userlogin'])){
    if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.company.href='index.php'";
      echo"</script>";
      exit();
    }
    }



$delete_id = $_REQUEST['dlt_id'];

$sql10 ="SELECT * FROM `company_location_map` WHERE state_id=:id";
$query10= $conn -> prepare($sql10);
$query10-> bindParam(':id', $delete_id);
$query10-> execute();
if($query10->rowCount() > 0)
{
    echo "<script type=text/javascript>";
    echo "alert('Delete Failed...State is Already in use...!');";
    echo "document.location.href='states.php'";
    echo"</script>";
    exit;
}



$sqls ="SELECT * FROM states WHERE id=:id";
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
        $filename = "uploads/states/".$l_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }
$sql = "delete from states where id=:id";
$query = $conn->prepare($sql);
$query->bindParam(':id', $delete_id);
$query->execute();


$sqls1 ="SELECT * FROM cities WHERE state_id=:id";
    $querys1= $conn -> prepare($sqls1);
    $querys1-> bindParam(':id', $delete_id);
    $querys1-> execute();
    $results1=$querys1->fetchAll();
	if($querys1->rowCount() > 0)
    {
        foreach ($results1 as $data1) {
		
			$l_image1 = $data1['image'];
		
        }
    }

    if($l_image1!=''){
        $filename1 = "uploads/cities/".$l_image1;
        if (file_exists($filename1)) {
           unlink($filename1);
         }
        }
$sql1 = "delete from cities where state_id=:id";
$query1= $conn->prepare($sql1);
$query1->bindParam(':id', $delete_id);
$query1->execute();


$sqls2 ="SELECT * FROM locations WHERE state_id=:id";
    $querys2= $conn -> prepare($sqls);
    $querys2-> bindParam(':id', $delete_id);
    $querys2-> execute();
    $results2=$querys2->fetchAll();
	if($querys2->rowCount() > 0)
    {
        foreach ($results2 as $data2) {
		
			$l_image2 = $data2['image'];
		
        }
    }

    if($l_image2!=''){
        $filename2 = "uploads/locations/".$l_image2;
        if (file_exists($filename2)) {
           unlink($filename2);
         }
        }
$sql2 = "delete from locations where state_id=:id";
$query2= $conn->prepare($sql2);
$query2->bindParam(':id', $delete_id);
$query2->execute();

   
echo "<script type=text/javascript>";
echo "alert('State Deleted Successfully...!');";
echo "document.location.href='states.php'";
echo"</script>";
