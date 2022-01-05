<?php
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

    $sql10 ="SELECT * FROM `company_location_map` WHERE city_id=:id";
    $query10= $conn -> prepare($sql10);
    $query10-> bindParam(':id', $delete_id);
    $query10-> execute();
    if($query10->rowCount() > 0)
    {
        echo "<script type=text/javascript>";
        echo "alert('Delete Failed...City is Already in use...!');";
        echo "document.location.href='city.php'";
        echo"</script>";
        exit;
    }
    
    $sqls ="SELECT * FROM cities WHERE id=:id";
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
        $filename = "uploads/cities/".$l_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }
    $sql ="delete from cities where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    $query-> execute();



    $sqls2 ="SELECT * FROM locations WHERE city_id=:id";
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
    $sql2 = "delete from locations where city_id=:id";
    $query2= $conn->prepare($sql2);
    $query2->bindParam(':id', $delete_id);
    $query2->execute();

header("location:city.php");

?>
