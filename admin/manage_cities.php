<?php
session_start();
//Database Configuration File
include('config.php');

// print_r($_FILES);
// error_reporting(0);

$user_id=$_SESSION['uid'];
$id = $l_name = $l_description = $m_title =  $m_description = $m_keywords = $l_image = $state_id = $city_id = $city_slug = $image = $states  = $cities = "";


    if($user_id==1){
        $status = 1;
    }
    else{
        $status = 0;
    }


	$sql1 ="SELECT * FROM states WHERE states.status='1'";
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $states=$query1->fetchAll();
	
	

if(isset($_GET['id'])){
   $id=$_GET['id'];
// Fetch data from database  the basis of username/email and password
   echo $sql ="SELECT * FROM cities  WHERE id=:id ";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$l_name = $data['city_name'];
			$l_description = $data['city_decription']; 
			$m_title = $data['meta_title'];
			$m_description = $data['meta_description'];
			$m_keywords = $data['meta_keywords'];
			$l_image = $data['image'];
            $state_id = $data['state_id'];
            $city_slug = $data['city_slug'];
			
        }
    }
}
if(isset($_POST))
{


    if(isset($_POST['add'])){
        $city_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['city_name'])));
        $sql10 ="SELECT * FROM cities WHERE city_slug=:city_slug";
        $query10= $conn -> prepare($sql10);
        $query10-> bindParam(':city_slug', $city_slug);
        $query10-> execute();
        if($query10->rowCount() > 0)
        {
            echo "<script type=text/javascript>";
            echo "alert('city or Company Name Already in use...!');";
            if($id!=''){
              echo "document.location.href='manage_cities.php?id=".$id."'";
            }
            else
            {
              echo "document.location.href='manage_cities.php'";
            }
            echo"</script>";
            exit();
        }
       }
       else {
        if(isset($_POST['update'])){
         $id = $_REQUEST['id']; 
         $city_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['city_slug']))); 
         $sql10 ="SELECT * FROM cities WHERE city_slug=:city_slug and id!=:id";
        $query10= $conn -> prepare($sql10);
        $query10-> bindParam(':city_slug', $city_slug);
        $query10-> bindParam(':id', $id);
         $query10-> execute(); 
        if($query10->rowCount() > 0)
        {
            echo "<script type=text/javascript>";
            echo "alert('city  or servce Name Already in use...!');";
            if($id!=''){
              echo "document.location.href='manage_cities.php?id=".$id."'";
            }
            else
            {
              echo "document.location.href='manage_cities.php'";
            }
            echo"</script>";
            exit();
        }
        }
       }


   if(isset($_FILES['image']['tmp_name'])) {
	 
    if($_FILES['image']['tmp_name']!=null){  
    $image = $_FILES["image"]["name"];
	// echo '-----------------------------------'.$image;
    $target_dir = "uploads/cities/";
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
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();
		$uploadOk = 0;
	  }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<script type=text/javascript>";
		echo "alert('Uploaded Image File Name Already Exists...!');";
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
	    echo "<script type=text/javascript>";
		echo "alert('File is too large...!');";
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "JPEG"  && $imageFileType != "jpeg"
	&& $imageFileType != "GIF" && $imageFileType != "gif" && $imageFileType != "SVG" && $imageFileType != "svg" && $imageFileType != "BMP" && $imageFileType != "bmp" && $imageFileType != "WEBP" && $imageFileType != "webp") {
	    echo "<script type=text/javascript>";
		echo "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed...!');";
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
     	echo "<script type=text/javascript>";
		echo "alert('Sorry, your file was not uploaded...!');";
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();	  
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		// echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
	  } else {
		echo "<script type=text/javascript>";
		echo "alert('Sorry, there was an error uploading your file...!');";
		echo "document.location.href='manage_cities.php'";
		echo"</script>";
		exit();	
	  }
	}
   }
  }
	
	
	
	
   if(isset($_POST['add'])){
	   
 	$data = [
    'state_id' => $_REQUEST['state'],
    'city_name' => $_REQUEST['city_name'],
	'city_description' => $_REQUEST['city_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
	'status' => $status,
    'added_user' => $_SESSION['uid'],
    'city_slug' => $city_slug,
    ];
    print_r($data);
    $sql2 ="INSERT INTO cities(`state_id`,  `city_name`, `city_decription`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_user`, `city_slug`) VALUES (:state_id,  :city_name, :city_description, :meta_title, :meta_description, :meta_keywords, :image, :status, :added_user, :city_slug )"; 
   $query2= $conn -> prepare($sql2);
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('City Added Successfully...!');";
		echo "document.location.href='city.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_city.php'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
	
   if($image!=''){
   $data = [
    'state_id' => $_REQUEST['state'],
    'city_name' => $_REQUEST['city_name'],
	'city_description' => $_REQUEST['city_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
    'id' => $_REQUEST['id'],
    'city_slug' => $city_slug,
    ];
    $sql2 ="UPDATE `cities` SET `state_id`=:state_id,  `city_name`=:city_name, `city_decription`=:city_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `image`=:image, `city_slug`=:city_slug  WHERE id=:id";
   }
   else
   {
	$data = [
    'state_id' => $_REQUEST['state'],
    'city_name' => $_REQUEST['city_name'],
	'city_description' => $_REQUEST['city_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
    'id' => $_REQUEST['id'],
    'city_slug' => $city_slug,
    ];
    $sql2 ="UPDATE `cities` SET `state_id`=:state_id, `city_name`=:city_name, `city_decription`=:city_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `city_slug`=:city_slug  WHERE id=:id";
   }
   
   $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('City Updated Successfully...!');";
		echo "document.location.href='city.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_cities.php'";
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
    <link href="dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="dist/css/pages/footable-page.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <style>
         .bootstrap-tagsinput{
            width: 100%;
         }
         .an input {

        color: #ffffff;
        }
     </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
                        <h4 class="text-themecolor">Cities</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="city.php">Cities</a></li>
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
                                        City Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="city_name" class="form-control" required data-validation-required-message="This field is required..." value="<?php echo $l_name;?>"> 
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>City Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="city_description" id="city_description" class="form-control" required placeholder="Enter Text" ><?php echo $l_description;?></textarea>
                                        </div>
                                    </div>
									
									
                                    <div class="form-group">
                                        <h5>State <span class="text-danger">*</span></h5>
									    <div class="controls">
                                            <select name="state" id="state" required="" class="form-control custom-select" aria-invalid="false">
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
                                        <h5>Meta Title <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $m_title;?>" name="meta_title" class="form-control" required data-validation-required-message="This field is required"> </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <h5>Meta Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="meta_description" required id="meta_description"  class="form-control" required placeholder="Enter text"><?php echo $m_description;?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Meta Keywords <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" style="color:blue;" data-role="tagsinput" name="meta_keywords" required value="<?php echo $m_keywords;?>" class="form-control" > </div>
                                        
                                    </div>

                                    


                                    <div class="form-group">
                                        <h5>City Image <span class="text-danger">*</span></h5>
                                        <div class="controls">

                                            
                                        <?php 
                                             if($id) { ?>
                                                <p class="sel-image">selected image:</p>
                                                    <?php
                                                        if($l_image==""){?>
                                                            <p>No image uploaded.</p>
                                                        <?php }
                                                        else {?>
                                                            <img src="uploads/cities/<?php echo $l_image?>" height="100"></img>
                                                            <input type="file" name="image"  class="form-control" <?php if ($id != '') {?> style="box-shadow: none;border: none;line-height: initial;"  <?php } else {?> required <?php }?>  >
                                                       <?php }
                                                    ?>
                                              
                                             <?php }
                                             else{?>
<input type="file" name="image"  class="form-control"  >
                                             <?php }
                                            ?>


                                            
                                         </div>
                                    </div>

                                    <?php  if($id!='') { ?>
                                    <div class="form-group">
                                        <h5>Slug <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                        <input type="text" value="<?php echo $city_slug;?>" name="city_slug" class="form-control"  onkeyup='saveValue(this);' required data-validation-required-message="This field is required">
                                         </div>
                                        
                                    </div>
                                    <?php } ?>

                                    <div class="text-xs-right">
									<?php  if($id!='') { ?>
									    <input type="hidden" name="hidden" value="<?php echo $id?>" >
                                        <button type="submit" style="margin-top:0px;" name="update" class="btn btn-info">Update</button>
									<?php } else { ?>
									    <button type="submit" style="margin-top:0px;" name="add" class="btn btn-info">Add</button>
									<?php } ?>
                                        <a href="city.php" class="btn btn-inverse">Cancel</a>
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
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
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
