<?php
session_start();
//Database Configuration File
include('config.php');

// print_r($_FILES);
// error_reporting(0);
$user_id=$_SESSION['uid'];

$id = $s_name = $s_description = $m_title =  $m_description = $m_keywords = $service_slug = $s_image = $image  = "";

if($user_id==1){
    $status = 1;
}
else{
    $status = 0;
}


	
	
if(isset($_GET['id'])){
   $id=$_GET['id'];
// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM services WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$s_name = $data['service_name'];
			$s_description = $data['service_description']; 
			$m_title = $data['meta_title'];
			$m_description = $data['meta_description'];
			$m_keywords = $data['meta_keywords'];
            $s_image = $data['image'];
            $service_slug = $data['service_slug'];
			
        }
    }
}
if(isset($_POST))
{

    if(isset($_POST['add'])){
        $service_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['service_name'])));
        $sql10 ="SELECT * FROM services WHERE service_slug=:service_slug";
        $query10= $conn -> prepare($sql10);
        $query10-> bindParam(':service_slug', $service_slug);
        $query10-> execute();
        if($query10->rowCount() > 0)
        {
            echo "<script type=text/javascript>";
            echo "alert('service_slug or Company Name Already in use...!');";
            if($id!=''){
              echo "document.location.href='manage_company.php?id=".$id."'";
            }
            else
            {
              echo "document.location.href='manage_company.php'";
            }
            echo"</script>";
            exit();
        }
       }
       else {
        if(isset($_POST['update'])){
         $id = $_REQUEST['hidden']; 
         $service_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['service_slug']))); 
         $sql10 ="SELECT * FROM services WHERE service_slug=:service_slug and id!=:id";
        $query10= $conn -> prepare($sql10);
        $query10-> bindParam(':service_slug', $service_slug);
        $query10-> bindParam(':id', $id);
         $query10-> execute(); 
        if($query10->rowCount() > 0)
        {
            echo "<script type=text/javascript>";
            echo "alert('service_slug or servce Name Already in use...!');";
            if($id!=''){
              echo "document.location.href='manage_services.php?id=".$id."'";
            }
            else
            {
              echo "document.location.href='manage_services.php'";
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
    $target_dir = "uploads/services/";
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
		echo "document.location.href='manage_services.php'";
		echo"</script>";
		exit();
		$uploadOk = 0;
	  }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<script type=text/javascript>";
		echo "alert('Uploaded Image File Name Already Exists...!');";
		echo "document.location.href='manage_services.php'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
	    echo "<script type=text/javascript>";
		echo "alert('File is too large...!');";
		echo "document.location.href='manage_services.php'";
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
    
    // $service_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['service_name'])));
    // $sql10 ="SELECT * FROM services WHERE service_slug=:service_slug";
    // $query10= $conn -> prepare($sql10);
    // $query10-> bindParam(':service_slug', $service_slug);
    // $query10-> execute();
    // if($query10->rowCount() > 0)
    // {
    //     echo "<script type=text/javascript>";
    //     echo "alert('service_slug or Service Name Already in use...!');";
    //     if($id!=''){
    //       echo "document.location.href='manage_services.php?id=".$id."'";
    //     }
    //     else
    //     {
    //       echo "document.location.href='manage_services.php'";
    //     }
	// 	echo"</script>";
	// 	exit();
    // }

	$data = [
    'service_name' => $_REQUEST['service_name'],
	'service_description' => $_REQUEST['service_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
	'status' => $status,
    'added_user' => $_SESSION['uid'],
    'service_slug' => $service_slug,
    ];
    
    $sql2 ="INSERT INTO services( `service_name`, `service_description`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `status`, `added_user`,`service_slug`) VALUES (:service_name, :service_description, :meta_title, :meta_description, :meta_keywords, :image, :status, :added_user, :service_slug)"; 

   $query2= $conn -> prepare($sql2); 
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Services Added Successfully...!');";
		echo "document.location.href='services.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_services.php'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
   
   if($image!=''){
   $data = [
    
    'service_name' => $_REQUEST['service_name'],
	'service_description' => $_REQUEST['service_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
	'image' => $image,
    'id' => $_REQUEST['hidden'],
    'service_slug' => $service_slug,
    ];
    $sql2 ="UPDATE `services` SET  `service_name`=:service_name, `service_description`=:service_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `image`=:image,`service_slug`=:service_slug WHERE id=:id";
   }
   else
   {
    
	$data = [

    'service_name' => $_REQUEST['service_name'],
	'service_description' => $_REQUEST['service_description'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
    'id' => $_REQUEST['hidden'],
    'service_slug' => $service_slug,
    ];




    

    $sql2 ="UPDATE `services` SET  `service_name`=:service_name, `service_description`=:service_description, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `service_slug`=:service_slug  WHERE id=:id";
   }
   
    $query2= $conn -> prepare($sql2); 
   
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Service Updated Successfully...!');";
		echo "document.location.href='services.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_services.php'";
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
    <title>Hire My Developer | Services</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
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
                        <h4 class="text-themecolor">Add New Service</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Services</li>
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Add New Service</a></li>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body an">
                               
                                <form class="m-t-40" novalidate method="post" action="manage_services.php" 
                                enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <h5>Service name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="service_name" class="form-control" required data-validation-required-message="This field is required" value="<?php echo $s_name;?>"> 
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Service Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="service_description" id="service_description" class="form-control" required placeholder="Textarea text" ><?php echo $s_description;?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Meta Title <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $m_title;?>" name="meta_title" class="form-control" required data-validation-required-message="This field is required"> </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <h5>Meta Description <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="meta_description" id="service_description"  class="form-control" required placeholder="Textarea text"><?php echo $m_description;?></textarea>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <h5>Meta Keywords <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                        <input type="text" data-role="tagsinput" name="meta_keywords" value="<?php echo $m_keywords;?>" class="form-control" required data-validation-required-message="This field is required">  </div>
                                        
                                    </div>

                                  


                                    <div class="form-group">
                                        <h5>Service Image <span class="text-danger">*</span></h5>
                                        <div class="controls">

                                            <?php 
                                             if($id) { ?>
                                                <p>selected image:</p>
                                                    <?php
                                                        if($s_image==""){?>
                                                            <p>No image uploaded.</p>
                                                        <?php }
                                                        else {?>
                                                            <img src="uploads/services/<?php echo $s_image?>" height="100"></img>
                                                            <input type="file" name="image"  class="form-control"  >
                                                       <?php }
                                                    ?>
                                              
                                             <?php }
                                             else{?>
<input type="file" name="image"  class="form-control" required data-validation-required-message="This field is required" >
                                             <?php }
                                            ?>

                                            
                                         </div>
                                    </div>
                                    <?php  if($id!='') { ?>
                                    <div class="form-group">
                                        <h5>Slug <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                        <input type="text" value="<?php echo $service_slug;?>" name="service_slug" class="form-control"  onkeyup='saveValue(this);' required data-validation-required-message="This field is required">
                                         </div>
                                        
                                    </div>
                                    <?php } ?>
                                <div>
                                    <input type="hidden" name="hidden" value="<?php echo $s_id?>" ?>
                                    <input type="hidden" name="anu" value="<?php echo $id?>" ?>
                                </div>
                                <div class="text-xs-right">
									<?php  if($id!='') { ?>
									    <input type="hidden" name="hidden" value="<?php echo $id?>" >
                                        <button type="submit" name="update" class="btn btn-info">Update</button>
									<?php } else { ?>
									    <button type="submit" name="add" class="btn btn-info">Add</button>
									<?php } ?>
                                        <a href="services.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php include('footer.php'); ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <script src="dist/js/pages/validation.js"></script>
    <script>
    ! function(window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);
    </script>
</body>

</html>