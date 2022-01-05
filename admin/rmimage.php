<?php
$attachment = $id = $name = $filename = '';
//print_r($_REQUEST);exit;
 //Database Configuration File
include('config.php');
if(isset($_REQUEST['id']))
$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$sql ="SELECT * FROM companies WHERE id=:id";
$query= $conn -> prepare($sql);
$query-> bindParam(':id', $id);
$query-> execute();
$results=$query->fetchAll();
if($query->rowCount() > 0)
{	
	  foreach($results as $row)
	  {
		$attachment=$row['images'];	
      }
}
 $attachment=str_replace($name,"",$attachment);
 $attachment=trim($attachment);
 $attachment=str_replace("||","|",$attachment);
 $attachment=trim($attachment);

 $filename = "uploads/companies/".$name;
 if (file_exists($filename)) {
    unlink($filename);
  }

 $data = [
    'images' => $attachment,
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `companies` SET `images`=:images WHERE id=:id";
   
    $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){
	   echo "Image Removed Successfully !";
	  }
	  else
	  {
	   echo "Error !";
	  }
?>