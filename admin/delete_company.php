<?php
session_start();
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
    else
    {
      echo "<script type=text/javascript>";
      echo "alert('Please Login to access this page !');";
      echo "document.location.href='index.php'";
      echo"</script>";
      exit();
    }
    $delete_id = $logo = '';
    $delete_id=$_GET['dlt_id'];

    $sqls ="SELECT * FROM companies WHERE id=:id";
    $querys= $conn -> prepare($sqls);
    $querys-> bindParam(':id', $delete_id);
    $querys-> execute();
    $results=$querys->fetchAll();
	if($querys->rowCount() > 0)
    {
        foreach ($results as $data) {
	
			$logo = $data['logo'];
	
        }
    }
    
    
    $sql ="delete from companies where id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $delete_id);
    if($query-> execute()){
        // for deleting logo file
        if($logo!=''){
            $filename = "uploads/companies/".$logo;
            if (file_exists($filename)) {
               unlink($filename);
             }
            }
         // for deleting maps related to company
            $sql7 ="DELETE FROM `company_service_map` WHERE `company_id`=:comid";
            $query7= $conn -> prepare($sql7);
            $query7-> bindParam(':comid', $delete_id);
            $query7-> execute();    

            $sql1 ="DELETE FROM `company_customers_map` WHERE `company_id`=:comid";
            $query1= $conn -> prepare($sql1);
            $query1-> bindParam(':comid', $delete_id);
            $query1-> execute();

            $sql2 ="DELETE FROM `company_portfolio_map` WHERE `company_id`=:comid";
            $query2= $conn -> prepare($sql2);
            $query2-> bindParam(':comid', $delete_id);
            $query2-> execute();

            $sql3 ="DELETE FROM `company_reviews_map` WHERE `company_id`=:comid";
            $query3= $conn -> prepare($sql3);
            $query3-> bindParam(':comid', $delete_id);
            $query3-> execute();

            $sql4 ="DELETE FROM `company_testimonials_map` WHERE `company_id`=:comid";
            $query4= $conn -> prepare($sql4);
            $query4-> bindParam(':comid', $delete_id);
            $query4-> execute();

            

    }
    header("location:companies.php");

?>



