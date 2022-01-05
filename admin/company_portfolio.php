<?php
session_start();
//Database Configuration File
include('config.php');

// print_r($_FILES);
// error_reporting(0);
// if(isset($_SESSION['userlogin'])){
// if($_SESSION['usertype'] != 'admin'){
//   echo "<script type=text/javascript>";
//   echo "alert('You are not authorized to access this page !');";
//   echo "document.location.href='index.php'";
//   echo"</script>";
//   exit();
// }
// }
// else
// {
//   echo "<script type=text/javascript>";
//   echo "alert('Please Login to access this page !');";
//   echo "document.location.href='index.php'";
//   echo"</script>";
//   exit();
// }

$id = $com_id = $portfolio_title = $image = $p_image = $reference_link = $companies = "";
$status = 1;
	$sql1 ="SELECT * FROM companies";
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $companies=$query1->fetchAll();

if(isset($_GET['com_id'])){
    $url_id = $_GET['com_id'];
    
    // Non-NULL Initialization Vector for decryption 
    $decryption_iv = '1234567891098769'; 
    
    // Store the decryption key 
    $decryption_key = "vofoxsolutions"; 
    // Store the cipher method 
    $ciphering = "AES-128-CTR"; 
    // Use OpenSSl Encryption method 
    $iv_length = openssl_cipher_iv_length($ciphering); 
    $options = 0;
    // Use openssl_decrypt() function to decrypt the data 
    $com_id = openssl_decrypt ($url_id, $ciphering,$decryption_key, $options, $decryption_iv);

}
if(isset($_GET['id'])){
  
   $uid = $_GET['id'];
    
    // Non-NULL Initialization Vector for decryption 
    $decryption_iv = '1234567891098769'; 
    
    // Store the decryption key 
    $decryption_key = "vofoxsolutions"; 
    // Store the cipher method 
    $ciphering = "AES-128-CTR"; 
    // Use OpenSSl Encryption method 
    $iv_length = openssl_cipher_iv_length($ciphering); 
    $options = 0;
    // Use openssl_decrypt() function to decrypt the data 
    $id = openssl_decrypt ($uid, $ciphering,$decryption_key, $options, $decryption_iv);

// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM company_portfolio_map WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$portfolio_title = $data['portfolio_title'];
			$p_image = $data['image'];
            $reference_link = $data['reference_link'];
            $com_id = $data['company_id'];
        }
    }
}
if(isset($_POST))
{
    $orig_string = $com_id;
    // Store the cipher method 
    $ciphering = "AES-128-CTR"; 
    // Use OpenSSl Encryption method 
    $iv_length = openssl_cipher_iv_length($ciphering); 
    $options = 0;  
    // Non-NULL Initialization Vector for encryption 
    $encryption_iv = '1234567891098769';  
    // Store the encryption key 
    $encryption_key = "vofoxsolutions";
    $encrypt_last_id = openssl_encrypt($orig_string, $ciphering,$encryption_key, $options, $encryption_iv);

   if(isset($_FILES['image']['tmp_name'])) {
	 
    if($_FILES['image']['tmp_name']!=null){  
    $image = $_FILES["image"]["name"];
	// echo '-----------------------------------'.$image;
    $target_dir = "uploads/portfolios/";
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
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();
		$uploadOk = 0;
	  }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<script type=text/javascript>";
		echo "alert('Uploaded Image File Name Already Exists...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
	    echo "<script type=text/javascript>";
		echo "alert('File is too large...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "JPEG"  && $imageFileType != "jpeg"
	&& $imageFileType != "GIF" && $imageFileType != "gif" && $imageFileType != "SVG" && $imageFileType != "svg" && $imageFileType != "BMP" && $imageFileType != "bmp" && $imageFileType != "WEBP" && $imageFileType != "webp") {
	    echo "<script type=text/javascript>";
		echo "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();
	  $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
     	echo "<script type=text/javascript>";
		echo "alert('Sorry, your file was not uploaded...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();	  
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		// echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
	  } else {
		echo "<script type=text/javascript>";
		echo "alert('Sorry, there was an error uploading your file...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
		exit();	
	  }
	}
   }
  }
	
	
	
	
   if(isset($_POST['add'])){

    if(isset($_SESSION['uid'])) {

        $log_id = $_SESSION['uid'];
      } else{
          $log_id ='';
      }
	   
	$data = [
    'company_id' => $com_id,
    'portfolio_title' => $_REQUEST['portfolio_title'],
    'image' => $image,
	'reference_link' => $_REQUEST['reference_link'],
	'status' => $status,
	'added_user' => $log_id,
    ];
   $sql2 ="INSERT INTO company_portfolio_map (`company_id`, `portfolio_title`, `image`, `reference_link`, `status`, `added_user`) VALUES (:company_id, :portfolio_title, :image, :reference_link, :status, :added_user)";
   $query2= $conn -> prepare($sql2);
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Portfolio Added Successfully...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
	$uid = $_GET['id'];
    
    // Non-NULL Initialization Vector for decryption 
    $decryption_iv = '1234567891098769'; 
    
    // Store the decryption key 
    $decryption_key = "vofoxsolutions"; 
    // Store the cipher method 
    $ciphering = "AES-128-CTR"; 
    // Use OpenSSl Encryption method 
    $iv_length = openssl_cipher_iv_length($ciphering); 
    $options = 0;
    // Use openssl_decrypt() function to decrypt the data 
    $id = openssl_decrypt ($uid, $ciphering,$decryption_key, $options, $decryption_iv);
   if($image!=''){
    $portfolio_title = $_REQUEST['portfolio_title'];
    $reference_link = $_REQUEST['reference_link'];
   $data = [
    'company_id' => $com_id,
    'portfolio_title' => $_REQUEST['portfolio_title'], 
    'image' => $image,
	'reference_link' => $_REQUEST['reference_link'],
	'id' => $id
    ];
    $sql2 ="UPDATE `company_portfolio_map` SET `company_id`='".$com_id."', `portfolio_title`='".$portfolio_title."',`image`='".$image."',`reference_link`='".$reference_link."' WHERE id='".$id."'";
   }
   else
   {
	$data = [
    'company_id' => $com_id,
    'portfolio_title' => $_REQUEST['portfolio_title'],
    'reference_link' => $_REQUEST['reference_link'],
	'id' =>$id
    ];
     $sql2 ="UPDATE `company_portfolio_map` SET `company_id`='".$com_id."', `portfolio_title`='".$portfolio_title."',`reference_link`='".$reference_link."' WHERE id='".$id."'";
   }
   
   $query2= $conn -> prepare($sql2);
 
   if($query2-> execute($data)){
    if($image!=''){
        $filename = "uploads/portfolios/".$p_image;
        if (file_exists($filename)) {
           unlink($filename);
         }
        }

		echo "<script type=text/javascript>";
		echo "alert('Portfolio Updated Successfully...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='company_external2.php?id=".$encrypt_last_id."'";
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
    <title>Hire My Developer | Manage Portfolio</title>
    <!-- Page CSS -->
	<link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
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
                        <h4 class="text-themecolor">Manage Portfolio</h4>
                    </div>
    <?php
        $orig_string = $com_id;
        // Store the cipher method 
        $ciphering = "AES-128-CTR"; 
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0;  
        // Non-NULL Initialization Vector for encryption 
        $encryption_iv = '1234567891098769';  
        // Store the encryption key 
        $encryption_key = "vofoxsolutions";
        $encrypt_last_id = openssl_encrypt($orig_string, $ciphering,$encryption_key, $options, $encryption_iv);
    ?>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="company_external2.php?id=<?php echo $encrypt_last_id; ?>">Portfolios</a></li>
                                <li class="breadcrumb-item active">Manage Portfolio</li>
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
                <div class="card-body">

                                <form class="m-t-40" method="post" enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <h5>Portfolio Title <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="portfolio_title" class="form-control" required data-validation-required-message="This field is required..." value="<?php echo $portfolio_title;?>"> 
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <h5>Company <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                          <select class="select2 form-control custom-select" id="company" name="company" style="width: 100%; height:36px;" required  readonly >
                                            <option>Select Company</option>
											<?php 
											 foreach($companies as $company){ 
											?>
											<option value="<?php echo $company['id']; ?>" <?php if($com_id==$company['id']) echo "selected"; ?> ><?php echo $company['company_name'] ?></option>
											 <?php } ?>
                                          </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Reference Link <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <textarea name="reference_link" id="reference_link" class="form-control" required placeholder="Enter Text" ><?php echo $reference_link;?></textarea>
                                        </div>
                                    </div>
									
									
                                    <div class="form-group">
                                        <h5>Portfolio Image <span class="text-danger">*</span></h5>
                                        <div class="controls">

                                            <?php 
                                             if($id!='') { ?>
         
                                                <img src="./uploads/portfolios/<?php echo $p_image?>" height="100"></img>
                                             
											 <h5 class="mt-3">Change Image </h5>
											 <?php }
                                            ?>

                                            <input type="file" name="image"  accept='image/*'  class="form-control" <?php if ($id != '') {?> style="box-shadow: none;border: none;line-height: initial;"  <?php } else {?> required <?php }?>  >
                                         </div>
                                    </div>
                                       <input type="hidden" name="com_id" value="<?php echo $com_id?>" >
                                    <div class="text-xs-right">
									<?php  if($id!='') { ?>
									    <input type="hidden" name="id" value="<?php echo $id?>" >
                                        <button type="submit" name="update" class="btn btn-info">Update</button>
									<?php } else { ?>
									    <button type="submit" name="add" class="btn btn-info">Add</button>
									<?php } ?>
                                        <a href="company_external2.php?id=<?php echo $encrypt_last_id; ?>" class="btn btn-inverse">Cancel</a>
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
		<script>
		  // For select 2
        $(".select2").select2( {  disabled: true } );
		</script>
</body>

</html>
