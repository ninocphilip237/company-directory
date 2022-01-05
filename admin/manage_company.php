<?php
session_start();
//Database Configuration File
include('config.php');
// echo '-------------------';
//  print_r($_REQUEST);
// print_r($_FILES);
// error_reporting(0);
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

$id = $c_name = $c_description = $c_address = $c_url = $c_email = $c_contact = $m_title = $m_description = $m_keywords = $slug =  $serv_id = $logo = $logo_new = $states  = $cities = $locations = $services = $service_map = $location_map = $selected_states = $selected_cities = $selected_locations = "";
$service_ids = $selected_serv = [];
$status = $state_id = $city_id = $location_id = 0;
if($_SESSION['usertype'] == 'admin')
$status = 1;
$flag = $p_progress = 0;
$profile_progress = 0;

if(isset($_GET['flag'])){
    $flag=$_GET['flag'];
}

if(isset($_REQUEST['state'])){
    $selected_states=$_REQUEST['state'];
}

if(isset($_REQUEST['city'])){
    $selected_cities=$_REQUEST['city'];
}

if(isset($_REQUEST['location'])){
    $selected_locations=$_REQUEST['location'];
}


$sql1 ="SELECT * FROM states where status ='1'";
$query1= $conn -> prepare($sql1);
$query1-> execute();
$states=$query1->fetchAll();

$sql2 ="SELECT * FROM cities where status ='1'";
$query2= $conn -> prepare($sql2);
$query2-> execute();
$cities=$query2->fetchAll();

$sql3 ="SELECT * FROM locations where status ='1'";
$query3= $conn -> prepare($sql3);
$query3-> execute();
$locations=$query3->fetchAll();

$sql4 ="SELECT * FROM services where status ='1'";
$query4= $conn -> prepare($sql4);
$query4-> execute();
$services=$query4->fetchAll();

if(isset($_REQUEST['id'])){
   $id=$_REQUEST['id'];
// Fetch data from database  
    $sql ="SELECT * FROM companies WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$c_name = $data['company_name'];
            $c_description = $data['company_description'];
            $c_url = $data['website_url'];
            $c_contact = $data['phone'];
            $c_email = $data['email'];
            $c_address = $data['address'];
			$m_title = $data['meta_title'];
			$m_description = $data['meta_description'];
			$m_keywords = $data['meta_keywords'];
			$logo = $data['logo'];
			// $state_id = $data['state_id'];
            // $city_id = $data['city_id'];
            // $location_id = $data['location_id'];
            $p_progress = $data['profile_progress'];
            $slug = $data['slug'];
            if($p_progress > $profile_progress){
              $profile_progress = $p_progress;
            }
        }
    }
    $sql5 ="SELECT * FROM company_service_map WHERE company_id=:id";
    $query5= $conn -> prepare($sql5);
    $query5-> bindParam(':id', $id);
    $query5-> execute();
    $service_map=$query5->fetchAll();
    $service_ids = array();
    foreach ($service_map as $object)
    {
        array_push($service_ids,$object['service_id']);
    }

    $sql6 ="SELECT * FROM company_location_map WHERE company_id=:id";
    $query6= $conn -> prepare($sql6);
    $query6-> bindParam(':id', $id);
    $query6-> execute();
    if($query6->rowCount() > 0)
    {
        $location_map=$query6->fetchAll();
    }
    
}
if(isset($_POST))
{
//   echo '---------------------------------';
//   print_r($_REQUEST); exit;
   if(isset($_POST['add'])){
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['company_name'])));
    $sql10 ="SELECT * FROM companies WHERE slug=:slug";
    $query10= $conn -> prepare($sql10);
    $query10-> bindParam(':slug', $slug);
    $query10-> execute();
    if($query10->rowCount() > 0)
    {
        echo "<script type=text/javascript>";
        echo "alert('Slug or Company Name Already in use...!');";
        if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
    }
   }
   else {
    if(isset($_POST['update'])){
     $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['slug'])));
     $sql10 ="SELECT * FROM companies WHERE slug=:slug and id!=:id";
    $query10= $conn -> prepare($sql10);
    $query10-> bindParam(':slug', $slug);
    $query10-> bindParam(':id', $id);
    $query10-> execute();
    if($query10->rowCount() > 0)
    {
        echo "<script type=text/javascript>";
        echo "alert('Slug or Company Name Already in use...!');";
        if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
    }
    }
   }
  
    


   if(isset($_FILES['logo']['tmp_name'])) {
	 
    if($_FILES['logo']['tmp_name']!=null){  
    $logo_new = $_FILES["logo"]["name"];
	// echo '-----------------------------------'.$logo;
    $target_dir = "uploads/companies/";
	$target_file = $target_dir . basename($_FILES["logo"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	  $check = getimagesize($_FILES["logo"]["tmp_name"]);
	  if($check !== false) {
		// echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	  } else {
        echo "<script type=text/javascript>";
        echo "alert('File is not Image or No Image choosen...!');";
        if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
		$uploadOk = 0;
	  }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<script type=text/javascript>";
		echo "alert('Uploaded Image File Name Already Exists...!');";
		if($id!=''){
         echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
         echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["logo"]["size"] > 1000000) {
	    echo "<script type=text/javascript>";
		echo "alert('File is too large...!');";
		if($id!=''){
         echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
         echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "JPEG"  && $imageFileType != "jpeg"
	&& $imageFileType != "GIF" && $imageFileType != "gif" && $imageFileType != "SVG" && $imageFileType != "svg" && $imageFileType != "BMP" && $imageFileType != "bmp" && $imageFileType != "WEBP" && $imageFileType != "webp") {
	    echo "<script type=text/javascript>";
		echo "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed...!');";
		if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
     	echo "<script type=text/javascript>";
		echo "alert('Sorry, your file was not uploaded...!');";
		if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();	  
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
		// echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
	  } else {
		echo "<script type=text/javascript>";
		echo "alert('Sorry, there was an error uploading your file...!');";
		if($id!=''){
          echo "document.location.href='manage_company.php?id=".$id."'";
        }
        else
        {
          echo "document.location.href='manage_company.php?flag=0'";
        }
		echo"</script>";
		exit();	
	  }
	}
   }
  }
	

	
	
   if(isset($_POST['add'])){
    $profile_progress = 33; 
	$data = [
    'company_name' => $_REQUEST['company_name'],
    'company_description' => $_REQUEST['company_description'],
    'profile_progress' => $profile_progress,
    'logo' => $logo_new,
    'website_url' => $_REQUEST['url'],
    'address' => $_REQUEST['address'],
    'email' => $_REQUEST['email'],
    'phone' => $_REQUEST['phone'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
	'meta_keywords' => $_REQUEST['meta_keywords'],
    'status' => $status,
    'slug' => $slug,
    'added_user' => $_SESSION['uid'],
    ];
   $sqls ="INSERT INTO `companies`(`company_name`, `company_description`, `profile_progress`, `logo`, `website_url`, `address`, `email`, `phone`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `slug`, `added_user`) VALUES ( :company_name, :company_description, :profile_progress, :logo, :website_url, :address, :email, :phone, :meta_title, :meta_description, :meta_keywords, :status, :slug, :added_user)";
   $querys= $conn -> prepare($sqls);
   if($querys-> execute($data)){
        $last_id = $conn ->lastInsertId();
        $selected_serv =  $_REQUEST['service'];
        foreach ($selected_serv as $serv){
            $sql6 ="INSERT INTO `company_service_map` (`service_id`, `company_id`) VALUES (:servid, :comid)";
            $query6= $conn -> prepare($sql6);
            $query6-> bindParam(':servid', $serv);
            $query6-> bindParam(':comid', $last_id);
            $query6-> execute();
        }
        foreach ( $selected_locations as $key => $value ){

            $sql7 ="INSERT INTO `company_location_map` (`company_id`, `state_id`, `city_id`, `location_id`) VALUES (:comid, :sid , :cid, :lid)";
            $query7= $conn -> prepare($sql7);
            $query7-> bindParam(':comid', $last_id);
            $query7-> bindParam(':sid', $selected_states[$key]);
            $query7-> bindParam(':cid', $selected_cities[$key]);
            $query7-> bindParam(':lid', $selected_locations[$key]);
            $query7-> execute();

            // echo '-------------------'.$selected_states[$key];
          
        }
        include('company_mail.php');  //  Sent mail to company authority  
		echo "<script type=text/javascript>";
        echo "alert('Company Step 1  Completed Successfully...!');";

        

		echo "document.location.href='manage_company2.php?id=".$last_id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_company.php?flag=0'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
   if($logo_new!=''){
   $data = [
    'company_name' => $_REQUEST['company_name'],
    'company_description' => $_REQUEST['company_description'],
    'logo' => $logo_new,
    'website_url' => $_REQUEST['url'],
    'address' => $_REQUEST['address'],
    'email' => $_REQUEST['email'],
    'phone' => $_REQUEST['phone'],
	'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
    'meta_keywords' => $_REQUEST['meta_keywords'],
    'status' => $status,
    'slug' => $slug,
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `companies` SET  `company_name`=:company_name, `company_description`=:company_description, `logo`=:logo, `website_url`=:website_url, `address`=:address, `email`=:email, `phone`=:phone, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `status`=:status, `slug`=:slug WHERE id=:id";
   }
   else
   {
	$data = [
    'company_name' => $_REQUEST['company_name'],
    'company_description' => $_REQUEST['company_description'],
    'website_url' => $_REQUEST['url'],
    'address' => $_REQUEST['address'],
    'email' => $_REQUEST['email'],
    'phone' => $_REQUEST['phone'],
    'meta_title' => $_REQUEST['meta_title'],
    'meta_description' => $_REQUEST['meta_description'],
    'meta_keywords' => $_REQUEST['meta_keywords'],
    'status' => $status,
    'slug' => $slug,
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `companies` SET  `company_name`=:company_name, `company_description`=:company_description, `website_url`=:website_url, `address`=:address, `email`=:email, `phone`=:phone, `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `status`=:status, `slug`=:slug WHERE id=:id";
   }
   
   $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){

    $selected_serv =  $_REQUEST['service'];
    $id = $_REQUEST['id'];
    $sql7 ="DELETE FROM `company_service_map` WHERE `company_id`=:comid";
    $query7= $conn -> prepare($sql7);
    $query7-> bindParam(':comid', $id);
    $query7-> execute();
    foreach ($selected_serv as $serv){
        $sql6 ="INSERT INTO `company_service_map` (`service_id`, `company_id`) VALUES (:servid, :comid)";
        $query6= $conn -> prepare($sql6);
        $query6-> bindParam(':servid', $serv);
        $query6-> bindParam(':comid', $id);
        $query6-> execute();
    }
    $sql8 ="DELETE FROM `company_location_map` WHERE `company_id`=:comid";
    $query8= $conn -> prepare($sql8);
    $query8-> bindParam(':comid', $id);
    $query8-> execute();
    
    foreach ( $selected_locations as $key => $value ){

        $sql9 ="INSERT INTO `company_location_map` (`company_id`, `state_id`, `city_id`, `location_id`) VALUES (:comid, :sid , :cid, :lid)";
        $query9= $conn -> prepare($sql9);
        $query9-> bindParam(':comid', $id);
        $query9-> bindParam(':sid', $selected_states[$key]);
        $query9-> bindParam(':cid', $selected_cities[$key]);
        $query9-> bindParam(':lid', $selected_locations[$key]);
        $query9-> execute();

        // echo '-------------------'.$selected_states[$key];
        
    }
        
      
    if($logo_new!=''){
    $filename = "uploads/companies/".$logo;
    if (file_exists($filename)) {
       unlink($filename);
     }
    }


		echo "<script type=text/javascript>";
		echo "alert('Company Step1 Updated Successfully...!');";
		echo "document.location.href='manage_company2.php?id=".$id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_company.php?id=".$id."'";
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
    <title>Hire My Developer | Manage Company</title>
    <!-- Page CSS -->
	<link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/pages/tab-page.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/node_modules/html5-editor/bootstrap-wysihtml5.css" />
    <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
         .bootstrap-tagsinput{
            width: 100%;
            /* border-color: #e46a76 !important; */
         }
         .bootstrap-tagsinput input  {

        /* color: #ffffff !important; */
        color: #FFF !important;
        }
        .errorInput{
            border-color: #e46a76 !important;   
        }
</style>
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
                        <h4 class="text-themecolor">Manage Company Step 1</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="companies.php" onclick="clearStorage();" > Companies</a></li>
                                <li class="breadcrumb-item active">Manage Company</li>
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
    <div class="card">
        <div class="card-body">
        
                <h4 class="card-title">Company Details</h4>
                <h6 class="card-subtitle">Enter the following details</h6>
                <div class="col-md-4 float-right">
                    <h5 class="m-t-30">Profile Progress<span class="pull-right"><?php echo $profile_progress; ?>%</span></h5>
                    <div class="progress">
                        <div class="progress-bar bg-info wow animated progress-animated" style="width: <?php echo $profile_progress; ?>%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                    </div>
                </div>
            <!-- Nav tabs -->
            <div class="vtabs customvtab col-12">
                <ul class="nav nav-tabs tabs-vertical" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" href="manage_company.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 1</span> </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="manage_company2.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 2</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" href="manage_company3.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 3</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" >
                    
                        <form id="yourform" class="form-material m-t-40 row"   method="post" enctype="multipart/form-data" >
                         
                            <div class="form-group col-md-6">
                                <h5>Company Logo <span class="text-danger">*</span></h5>
                                <div class="controls d-flex align-items-center">

                                    <?php 
                                        if($id!='') { ?>
                                    
                                        <img src="./uploads/companies/<?php echo $logo; ?>" height="100" class="mr-3"></img>
                                        
                                        <!-- <h5 class="mt-3">Change Image </h5> -->
                                        <?php }
                                    ?>

                                    <input type="file" name="logo"  id="logo" accept='image/*' onchange='saveValue(this);'  class="form-control" <?php if ($id != '') {?> style="box-shadow: none;border: none;line-height: initial;"  <?php } else {?> required data-validation-required-message="This field is required" <?php }?> >
                                    </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <h5>Company Name <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="company_name" id="company_name" required onkeyup='saveValue(this);' class="form-control"  data-validation-required-message="This field is required" value="<?php echo $c_name;?>"> 
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <h5>Website URL <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="url" id="url"  onkeyup='saveValue(this);' class="form-control" required data-validation-required-message="This field is required" value="<?php echo $c_url;?>"> 
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <h5>Address <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <textarea name="address" id="address"  class="form-control"  onkeyup='saveValue(this);'  required data-validation-required-message="This field is required" ><?php echo $c_address;?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <h5>Email <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" id="email" class="form-control"  onkeyup='saveValue(this);'  required  value="<?php echo $c_email;?>"> 
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <h5>Phone Number/Contact Info <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="number" name="phone" id="phone" class="form-control"  onkeyup='saveValue(this);'  required data-validation-required-message="This field is required" value="<?php echo $c_contact;?>"> 
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <h5>Locations <span class="text-danger">*</span></h5> 
                            </div>
                            <div class="form-group col-md-4">
                                <h5>State <span class="text-danger">*</span></h5>
                            </div>
                            <div class="form-group col-md-4">
                                <h5>City <span class="text-danger">*</span></h5>
                            </div>
                            <div class="form-group col-md-4  d-flex ">
                                <h5>Location <span class="text-danger">*</span></h5>
                                <a href="manage_company.php<?php $flag++; if($id!=''){ echo '?id='.$id.'&flag='.$flag; } else { echo  '?flag='.$flag; } ?>" class="add_button btn btn-primary ml-5" title="Add New Location"><i class="fa fa-plus"></i> &nbsp;Add New</a>
                            </div>

                    <?php 
                     $select_count = 1;
                    if($location_map==''){ ?>
                        <div class="form-group col-md-4">
                                <!-- <h5>State <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="state<?php echo $select_count; ?>" name="state[]" style="width: 100%; height:36px;" required=""   onchange="selectState(this.value,<?php echo $select_count; ?>);" >
                                    <option value="">Select State</option>
                                    <?php 
                                        foreach($states as $state){ 
                                    ?>
                                    <option value="<?php echo $state['id']; ?>" <?php if($state_id==$state['id']) echo "selected"; ?> ><?php echo $state['state_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <!-- <h5>City <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="city<?php echo $select_count; ?>" name="city[]" style="width: 100%; height:36px;"  required data-validation-required-message="This field is required"   onchange="selectCity(this.value,<?php echo $select_count; ?>);" >
                                    <option>Select City</option>
                                    <?php 
                                        foreach($cities as $city){ 
                                    ?>
                                    <option value="<?php echo $city['id']; ?>" <?php if($city_id==$city['id']) echo "selected"; ?> ><?php echo $city['city_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                           
                            </div>
                      
                            <div class="form-group col-md-4">
                                <!-- <h5>Location <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="location<?php echo $select_count; ?>" name="location[]" style="width: 100%; height:36px;"    required data-validation-required-message="This field is required"  >
                                    <option value="">Select Location</option>
                                    <?php 
                                        foreach($locations as $location){ 
                                    ?>
                                    <option value="<?php echo $location['id']; ?>" <?php if($location_id==$location['id']) echo "selected"; ?>  ><?php echo $location['location_name'] ?></option>
                                        <?php }  $select_count++; ?>
                                    </select>  
                            
                                </div>
                            </div>

                    <?php
                       } 
                  
                      if($location_map!=''){
                      foreach($location_map as $mlocation){ 
                        // print_r($mlocation['city_id']);
                        ?>
                            <div class="form-group col-md-4">
                                <!-- <h5>State <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="state<?php echo $select_count;  ?>" name="state[]" style="width: 100%; height:36px;"  required=""  onchange="selectState(this.value,<?php echo $select_count; ?>);" >
                                    <option value="">Select State</option>
                                    <?php 
                                        foreach($states as $state){ 
                                    ?>
                                    <option value="<?php echo $state['id']; ?>" <?php if($mlocation['state_id']==$state['id']) echo "selected"; ?> ><?php echo $state['state_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <!-- <h5>City <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                <select class="select2 form-control custom-select" id="city<?php echo $select_count; ?>" name="city[]" style="width: 100%; height:36px;"  required data-validation-required-message="This field is required"   onchange="selectCity(this.value,<?php echo $select_count; ?>);" >
                                    <option>Select City</option>
                                    <?php 
                                        foreach($cities as $city){ 
                                    ?>
                                    <option value="<?php echo $city['id']; ?>" <?php if($mlocation['city_id']==$city['id']) echo "selected"; ?> ><?php echo $city['city_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                           
                            </div>
                      
                            <div class="form-group col-md-4">
                                <!-- <h5>Location <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select required" id="location<?php echo $select_count;?>" name="location[]"   style="width: 100%; height:36px;" required data-validation-required-message="This field is required" >
                                    <option value="" >Select Location</option>
                                    <?php 
                                        foreach($locations as $location){ 
                                    ?>
                                    <option value="<?php echo $location['id']; ?>" <?php if($mlocation['location_id']==$location['id']) echo "selected"; ?>  ><?php echo $location['location_name'] ?></option>
                                        <?php }   ?>
                                    </select>  
                            
                                </div>
                            </div>
                <?php  $select_count++;  }  }  
                if(isset($_REQUEST['flag'])){ 
                
                for ($x = 1; $x < $flag; $x++) {
                 ?>
                            <div class="form-group col-md-4">
                                <!-- <h5>State <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="state<?php echo $select_count; ?>" name="state[]" style="width: 100%; height:36px;" required=""  onchange="selectState(this.value,<?php echo $select_count; ?>);" >
                                    <option value="">Select State</option>
                                    <?php 
                                        foreach($states as $state){ 
                                    ?>
                                    <option value="<?php echo $state['id']; ?>" <?php if($state_id==$state['id']) echo "selected"; ?> ><?php echo $state['state_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <!-- <h5>City <span class="text-danger">*</span></h5> -->
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="city<?php echo $select_count; ?>" name="city[]" style="width: 100%; height:36px;" required data-validation-required-message="This field is required"   onchange="selectCity(this.value,<?php echo $select_count; ?>);" >
                                    <option>Select City</option>
                                    <?php 
                                        foreach($cities as $city){ 
                                    ?>
                                    <option value="<?php echo $city['id']; ?>" <?php if($city_id==$city['id']) echo "selected"; ?> ><?php echo $city['city_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                           
                            </div>
                      
                            <div class="form-group col-md-4">
                                <!-- <h5>Location <span class="text-danger">*</span></h5> -->
                                <div class="controls ">
                                    <select class="select2 form-control custom-select" id="location<?php echo $select_count;?>" name="location[]"   style="width: 100%; height:36px;" required  data-validation-required-message="This field is required">
                                    <option value="">Select Location</option>
                                    <?php 
                                        foreach($locations as $location){ 
                                    ?>
                                    <option value="<?php echo $location['id']; ?>" <?php if($location_id==$location['id']) echo "selected"; ?>  ><?php echo $location['location_name'] ?></option>
                                        <?php } ?>
                                    </select>                         
                                </div>
                            </div>
                       <?php  $select_count++; } } ?>         
                            <div class="form-group col-md-8">
                                <h5>Services </h5>
                                <div class="controls">
                                    <select class="select2 form-control custom-select" id="service" name="service[]"  required data-validation-required-message="This field is required" multiple style="width: 100%; height:36px;" >
                                    <!-- <option value="">Select Service</option> -->
                                    <?php 
                                        foreach($services as $service){ 
                                    ?>
                                    <option value="<?php echo $service['id']; ?>" <?php if (in_array($service['id'], $service_ids)) echo "selected"; ?>  ><?php echo $service['service_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <h5> &nbsp; </h5>
                                <div class="controls">
                                   <a href="manage_services.php" target="_blank" class="btn btn-inverse">Add New Service</a>
                                </div>
                            </div>

                            <div class="form-group col-md-10">
                                <h5>Company Description <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <textarea name="company_description" rows="10" id="company_description" class="textarea_editor form-control" required data-validation-required-message="This field is required" onchange='saveValue(this);'  placeholder="Enter Text Here..." style="border:1px solid #4F5467;" ><?php echo $c_description;?></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-2 d-flex align-items-center justify-content-center">
                                <div class="controls">
                                   <a href="javascript:void(0)" class="btn btn-inverse"  onclick="checkPlagiarism();" >Check Plagiarism</a>
                                </div>
                            </div>
                            <?php  if($id!='') { ?>
                            <div class="form-group col-md-6">
                                <h5>Slug <span class="text-danger"></span></h5>
                                <div class="controls">
                                    <input type="text" value="<?php echo $slug;?>" name="slug" class="form-control"  onkeyup='saveValue(this);' required data-validation-required-message="This field is required"> 
                                </div>                              
                            </div>
                            <?php } ?>
                            <div class="form-group col-md-6">
                                <h5>Meta Title <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" value="<?php echo $m_title;?>" name="meta_title" id="meta_title" class="form-control"  onkeyup='saveValue(this);' required data-validation-required-message="This field is required"> 
                                </div>                              
                            </div>

                            <div class="form-group col-md-6">
                                <h5>Meta Keywords <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text"    data-role="tagsinput" name="meta_keywords" id="meta_keywords" required data-validation-required-message="This field is required" value="<?php echo $m_keywords;?>"  onkeyup='saveValue(this);' class="form-control w-100"   > 
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <h5>Meta Description <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <textarea name="meta_description" rows="5" id="meta_description"  onkeyup='saveValue(this);' class="form-control" required data-validation-required-message="This field is required" placeholder="Enter Text Here..."  ><?php echo $m_description;?></textarea>
                                </div>
                            </div>
                            <div class="text-xs-right">
                                <?php  if($id!='') { ?>
                                    <input type="hidden" name="id" value="<?php echo $id?>" >
                                    <button type="submit" id="update" name="update" class="btn btn-info" >Update & Continue</button>
                                <?php } else { ?>
                                    <button type="submit" id="add" name="add" class="btn btn-info" >Save & Continue</button>
                                <?php } ?>
                                  &nbsp;  <a href="companies.php" onclick="clearStorage();" class="btn btn-inverse" >Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                   
    </section>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-light">Plagiarisms...</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="results-count text-light"></p>
        <span class="results text-light"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
         <!-- wysuhtml5 Plugin JavaScript -->
        <script src="../assets/node_modules/html5-editor/wysihtml5-0.3.0.js"></script>
        <script src="../assets/node_modules/html5-editor/bootstrap-wysihtml5.js"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

		<script>
    // var keyword = $("#meta_keywords");
    let flag = 0;
     flag = <?php $flag= 0; if(isset($_REQUEST['flag'])) $flag=$_REQUEST['flag']; echo $flag; ?>;
     flag++;
     
        // $('.btn-info').click(function () {

        // if(keyword.val().length===0){
        //   $('.bootstrap-tagsinput').addClass("errorInput");
        // }
        // else{
        //   $('.bootstrap-tagsinput').removeClass("errorInput");
        // }


        // });

         $(document).ready(function() {

            // $('.textarea_editor').wysihtml5();
             
                $('#service').change(function() {
                
                    var selected = []; // create an array to hold all currently selected motivations

                    // loop through each available motivation
                    $('#service option').each(function() {
                        // if it's selected, add it to the array above
                        if (this.selected) {
                            selected.push(this.value);
                        }
                    });

                    // store the array of selected options
                    localStorage.setItem('services', JSON.stringify(selected));
                });
                <?php if((isset($_REQUEST['flag']))&&(!isset($_REQUEST['id']))) { ?>
                // check for stored motivations
                var stored_motivations = JSON.parse(localStorage.getItem('services'));
                if (stored_motivations !== null) {
                    $('#service option').each(function() {
                        for (var i = 0; i < stored_motivations.length; i++) {
                            if (this.value == stored_motivations[i]) {
                                this.selected = true;
                            }
                        }
                    });
                }
                $("#service").select2();
            <?php  } ?> 
        for (let i = 1; i <= flag; i++) {
        <?php if((isset($_REQUEST['flag']))&&(!isset($_REQUEST['id']))) { ?>
            var selval1 = localStorage.getItem("select2State"+i);
             if(selval1){
                $("#state"+i).val(selval1);
            }
            var selval2 = localStorage.getItem("select2City"+i);
             if(selval2){
                $("#city"+i).val(selval2);
            }
            var selval3 = localStorage.getItem("select3Location"+i);
             if(selval3){
                $("#location"+i).val(selval3);
            }
        <?php } ?> 
            $("#state"+i).select2();
            $("#state"+i).on("change", function (evt) {
                var selval1 = $(evt.target).val();
                localStorage.setItem("select2State"+i, selval1);
            })
           
            $("#city"+i).select2();
            $("#city"+i).on("change", function (evt) {
                var selval2 = $(evt.target).val();
                localStorage.setItem("select2City"+i, selval2);
            })
           
            $("#location"+i).select2();
            $("#location"+i).on("change", function (evt) {
                var selval3 = $(evt.target).val();
                localStorage.setItem("select3Location"+i, selval3);
            })
            
        }  

        
        });
		  // For select 2
        $(".select2").select2();
        //For Loading Selected State's Cities 
        function selectState(val,count) {
            $.ajax({
                type: "POST",
                url: "d_state.php",
                data:'state_id='+val,
                success: function(data){
                    $("#city"+count).html(data);
                }
            });
        
        }

        function clearStorage(){
            // debugger
            localStorage.clear();
        }
        function myfun() {
          //alert("here");
         let skip = 1;
        
        $.ajax({
            type: "POST",
            url: "setVal.php",
            data:'sval='+skip,
            success: function(data){
               
                // alert("You are skipping step 2");
                        
            }
            });
      }
        //For Loading Selected City's Locations 
	    function selectCity(val,count) {
            $.ajax({
                type: "POST",
                url: "d_city.php",
                data:'city_id='+val,
                success: function(data){
                    $("#location"+count).html(data);
                }
            });
        
        }
        // Function to get plagiarism
        function checkPlagiarism() {
        let  text = $('.textarea_editor').val();
        $.ajax({
			type: "POST",
			url: "chk_plag.php",
			data:'text='+text,
			success: function(data){
              if(data==null){
                alert("Error !");
              }
              else{
              let obj = JSON.parse(data);
              //debugger
              let percent = obj.plagPercent;
              let results = obj.details;
              let plag_length = results.length;
              let desc = '';
              desc+='<b>'+percent+'% of Plagiarism Found... </b>';
              desc+='</br><b>'+plag_length+' Plagiarism(s) Query(s) / Result(s) Found... </b>';
              let i = 1;
              results.forEach(element => {
                desc+='</br><b>'+i+' . </b>';
                desc+='</br><b>Query : </b>'+element.query;
                if(element.display!==null){
                desc+='</br><b>URL : </b>'+element.display.url;
                desc+='</br><b>Content : </b>'+element.display.des;
                }
                i++;
              });
              $( "span.results" ).html(desc);
              $('#myModal').modal("show");
              }
			}
        });
        // alert(text);
        }

        
        //Save the value function - save it to localStorage as (ID, VALUE)
        function saveValue(e){
        //   alert(e);
        debugger
            var id = e.id;  // get the sender's id to save it . 
            var val = e.value; // get the value. 
            if(id=='company_description'){
              val=  $('.textarea_editor').val();
            }

            if(id=='logo'){
                localStorage.setItem('file', e.files);   
            }
           
            localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override . 
                
         }
        //get the saved value function - return the value of "v" from localStorage. 
        function getSavedValue  (v){
        if (!localStorage.getItem(v)) {
            return "";// You can change this to your defualt value. 
        }
        return localStorage.getItem(v);
        }

        $('.textarea_editor').wysihtml5({
        "events": {
            "blur": function() {
            $('.textarea_editor').trigger('change');
            }
            }

        });
        $('input').on('itemAdded', function(event) {
            let val=$('#meta_keywords').val();
            localStorage.setItem('meta_keywords', val);
         });
        </script>
    <?php if((isset($_REQUEST['flag']))&&(!isset($_REQUEST['id']))) { ?>
        <script type="text/javascript">
        // document.getElementById("logo").value = getSavedValue("logo");    // set the value to this input
        // document.getElementById("logo").files = getSavedValue("file");    // set the value to this input
        document.getElementById("company_name").value = getSavedValue("company_name");   // set the value to this input
        document.getElementById("url").value = getSavedValue("url");    // set the value to this input
        document.getElementById("address").value = getSavedValue("address");   // set the value to this input
        document.getElementById("email").value = getSavedValue("email");    // set the value to this input
        document.getElementById("phone").value = getSavedValue("phone");   // set the value to this input
        document.getElementById("meta_title").value = getSavedValue("meta_title");   // set the value to this input
        document.getElementById("meta_keywords").value = getSavedValue("meta_keywords");   // set the value to this input
        $('#company_description').val(getSavedValue("company_description"));  // set the value to this input
        document.getElementById("meta_description").value = getSavedValue("meta_description");   // set the value to this input
        /* Here you can add more inputs to set value. if it's saved */
        
      </script>
    <?php } ?>
</body>

</html>
