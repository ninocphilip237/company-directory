<?php
session_start();
//Database Configuration File
include('config.php');
$select_count = 1;
if(isset($_SESSION['userlogin'])){
    if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.location.href='index.php'";
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

$user_id=$_SESSION['uid'];
$id = $l_name = $l_description = $m_title =  $m_description = $m_keywords = $l_image = $state_id = $city_id = $image = $states  = $cities = "";
$status = 1;

if($user_id==1){
    $status = 1;
}
else{ 
    $status = 0;
}
	$sql1 ="SELECT * FROM states WHERE status ='1'";
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $states=$query1->fetchAll();
	
	$sql2 ="SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and  states.status='1' WHERE cities.status='1' ";
    $query2= $conn -> prepare($sql2);
    $query2-> execute();
    $cities=$query2->fetchAll();

if(isset($_GET['id'])){
  $id=$_GET['id']; 
// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM locations WHERE  id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$l_name = $data['location_name'];
			$l_description = $data['location_description']; 
			$m_title = $data['meta_title'];
			$m_description = $data['meta_description'];
			$m_keywords = $data['meta_keywords'];
			$l_image = $data['image'];
			$state_id = $data['state_id'];
			$city_id = $data['city_id'];
        }
    }
}
if(isset($_POST))
{
   if(isset($_FILES['image']['tmp_name'])) {
	 
    if($_FILES['image']['tmp_name']!=null){  
    $image = $_FILES["image"]["name"];
	// echo '-----------------------------------'.$image;
    $target_dir = "uploads/locations/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	  $check = getimagesize($_FILES["image"]["tmp_name"]);
	  if($check !== false) {
		// echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	  } else {
        echo "<script type=text/javascript>";
		echo "alert('File is not Image or No Image choosen...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();
		$uploadOk = 0;
	  }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<script type=text/javascript>";
		echo "alert('Uploaded Image File Name Already Exists...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
	    echo "<script type=text/javascript>";
		echo "alert('File is too large...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "JPEG"  && $imageFileType != "jpeg"
	&& $imageFileType != "GIF" && $imageFileType != "gif" && $imageFileType != "SVG" && $imageFileType != "svg" && $imageFileType != "BMP" && $imageFileType != "bmp" && $imageFileType != "WEBP" && $imageFileType != "webp") {
	    echo "<script type=text/javascript>";
		echo "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
     	echo "<script type=text/javascript>";
		echo "alert('Sorry, your file was not uploaded...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();	  
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		// echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
	  } else {
		echo "<script type=text/javascript>";
		echo "alert('Sorry, there was an error uploading your file...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
		exit();	
	  }
	}
   }
  }
	
	
	
	
   if(isset($_POST['add'])){
	
	$data = [
    'state_id' => $_REQUEST['state'],
    'city_id' => $_REQUEST['city'],
    'location_name' => $_REQUEST['location_name'],
	'location_description' => $_REQUEST['location_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
	'status' => $status,
	'added_user' => $_SESSION['uid'],
    ];
   $sql2 ="INSERT INTO locations(`state_id`, `city_id`, `location_name`, `location_description`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_user`) VALUES (:state_id, :city_id, :location_name, :location_description, :meta_title, :meta_description, :meta_keywords, :image, :status, :added_user)";
   $query2= $conn -> prepare($sql2);
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Location Added Successfully...!');";
		echo "document.location.href='locations.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
	
   if($image!=''){
   $data = [
    'state_id' => $_REQUEST['state'],
    'city_id' => $_REQUEST['city'],
    'location_name' => $_REQUEST['location_name'],
	'location_description' => $_REQUEST['location_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `locations` SET `state_id`=:state_id, `city_id`=:city_id, `location_name`=:location_name, `location_description`=:location_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `image`=:image WHERE id=:id";
   }
   else
   {
	$data = [
    'state_id' => $_REQUEST['state'],
    'city_id' => $_REQUEST['city'],
    'location_name' => $_REQUEST['location_name'],
	'location_description' => $_REQUEST['location_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `locations` SET `state_id`=:state_id, `city_id`=:city_id, `location_name`=:location_name, `location_description`=:location_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords WHERE id=:id";
   }
   
   $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){
         
    if($image!=''){
        $filename = "uploads/locations/".$l_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }
		echo "<script type=text/javascript>";
		echo "alert('Location Updated Successfully...!');";
		echo "document.location.href='locations.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_location.php'";
		echo"</script>";
    }
	   
   }   
   	   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hire My Developer | Manage Location</title>
    <!-- Page CSS -->
	<link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script language="JavaScript" type="text/javascript" src="/js/jquery-1.2.6.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/jquery-ui-personalized-1.5.2.packed.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/sprinkle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <style>
         .bootstrap-tagsinput{
            width: 100%;
         }
         .an input {

color: #ffffff;
}                                                                                                        
     </style>
     <script>
$(document).ready(function(){
    $('#sub').click(function() {
        var x = document.getElementById("meta_keywords");
        var loc_name = document.getElementById("location_name");
        var desc = document.getElementById("location_description");
        var state = document.getElementById("state");
        var city = document.getElementById("city");
        var meta_title = document.getElementById("meta_title");
        var meta_desc = document.getElementById("meta_description");
  if (x == "" ) {
    alert("This field must be filled out!");
    return false;
  }
});
});


</script>
</head>

<body class="skin-default-dark fixed-layout">
         <!-- ============================================================== -->
        <!-- header -->
        <!-- ============================================================== -->
           <?php include('header.php'); ?>
        <!-- ============================================================== -->
        <!-- End header -->
        <!-- ============================================================== -->
       
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Manage Location</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="locations.php">Locations</a></li>
                                <li class="breadcrumb-item active">Manage Location</li>
                            </ol>
                            
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body an">

                                <form class="m-t-40" novalidate method="post" enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <h5>Location Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="location_name" id="location_name" class="form-control" required data-validation-required-message="This field is required" value="<?php echo $l_name;?>"> 
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Location Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="location_description" id="location_description" class="form-control" required data-validation-required-message="This field is required" placeholder="Enter Text" ><?php echo $l_description;?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                    <h5>State <span class="text-danger">*</span></h5>
									    <div class="controls">
                                            <select name="state" id="state" required="" data-validation-required-message="This field is required" onchange="selectState(this.value,<?php echo $select_count; ?>);" class="select2 form-control custom-select" aria-invalid="false">
                                            <option value="" >Select State</option>
											<?php 
											 foreach($states as $state){ 
											?>
											<option value="<?php echo $state['id']; ?>" <?php if($state_id==$state['id']) echo "selected"; ?> ><?php echo $state['state_name'] ?></option>
											 <?php } ?>
                                            </select>
                                        <div class="help-block"></div></div>
                                    </div>

                                    <div class="form-group">
                                    <h5>City <span class="text-danger">*</span></h5>
									    <div class="controls">
                                            <select name="city" id="city" required="" data-validation-required-message="This field is required" class="select2 form-control custom-select" aria-invalid="false">
                                            <option value="" >Select City</option>
											<?php 
											 foreach($cities as $city){ 
											?>
											<option value="<?php echo $city['id']; ?>" <?php if($city_id==$city['id']) echo "selected"; ?> ><?php echo $city['city_name'] ?></option>
											 <?php } ?>
                                            </select>
                                        <div class="help-block"></div></div>
                                    </div>
									

                                    <div class="form-group">
                                        <h5>Meta Title <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="meta_title" value="<?php echo $m_title;?>" name="meta_title" class="form-control" required data-validation-required-message="This field is required" > </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <h5>Meta Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="meta_description"  id="meta_description"  class="form-control" required data-validation-required-message="This field is required" placeholder="Enter text"><?php echo $m_description;?></textarea>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <h5>Meta Keywords <span class="text-danger">*</span></h5>
                                        <div class="controls" >
                                        <input type="text" data-role="tagsinput" name="meta_keywords" value="<?php echo $m_keywords;?>" class="form-control" required data-validation-required-message="This field is required" >  </div>
                                        
                                    </div>


                                    <div class="form-group">
                                        <h5>Location Image <span class="text-danger">*</span></h5>
                                        <div class="controls">

                                        <?php 
                                             if($id) { ?>
                                                <p class="sel-image">Selected Image:</p>
                                                    <?php
                                                        if($l_image==""){?>
                                                            <p>No image uploaded.</p>
                                                        <?php }
                                                        else {?>
                                                            <img src="uploads/locations/<?php echo $l_image?>" height="100"></img>
                                                            <input type="file" name="image"  class="form-control" <?php if ($id != '') {?> style="box-shadow: none;border: none;line-height: initial;"  <?php } else {?> required data-validation-required-message="This field is required" <?php }?>   >
                                                       <?php }
                                                    ?>
                                              
                                             <?php }
                                             else{?>
                                                <input type="file" name="image"  class="form-control" required data-validation-required-message="This field is required" >
                                             <?php }
                                            ?>
                                         </div>
                                    </div>

                                    <div class="text-xs-right">
									<?php  if($id!='') { ?>
									    <input type="hidden" name="id" value="<?php echo $id?>" >
                                        <button type="submit" name="update" class="btn btn-info">Update</button>
									<?php } else { ?>
									    <button type="submit" name="add" id="sub" class="btn btn-info">Add</button>
									<?php } ?>
                                        <a href="locations.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </section>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
       <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
           <?php include('footer.php'); ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
		
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

        <script>
            $("#sample").each(function () {
        $(this).rules('add', {
                required: true,
                validateClass : true,
                messages: {
                    required: "Value is required",
                    validateClass : "Validation failed"
                }
            });
    });
        </script>
		<script>
		  // For select 2
        $(".select2").select2();
        //For Loading Selected State's Cities 
	    function selectState(val) {

			$.ajax({
			type: "POST",
			url: "d_state.php",
			data:'state_id='+val,
			success: function(data){
				$("#city").html(data);
			}
			});
		}
		</script>
</body>

</html>
