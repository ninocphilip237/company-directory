<?php
session_start();
//Database Configuration File
include('config.php');
// print_r($_FILES);
// error_reporting(0);
if(isset($_GET['id'])){

}
else
{
  echo "<script type=text/javascript>";
  echo "alert('Please Login to access this page !');";
  echo "document.location.href='index.php'";
  
  echo"</script>";
  exit();
}

$id = $customers = $testimonials = $reviews = $attachment = $images = $rph_id = $tz_id = "";
$status = 0;
$p_progress = 0;
$profile_progress = 67;
// if(isset($_SESSION['skip'])==1){
//     $profile_progress = 67;
// }else{
//     $profile_progress = 100;
// }

  if(isset($_GET['id'])){

    //--------------Decrypting id from URL----------------------
   
   $url_id = $_GET['id'];
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
   $id = openssl_decrypt ($url_id, $ciphering,$decryption_key, $options, $decryption_iv);
   
   }

if(isset($_GET['id'])){
    //$id=$_GET['id'];
}
else
{
  echo "<script type=text/javascript>";
  echo "alert('Please Complete Step 1 to access this page !');";
  echo "document.location.href='company_external.php'";
  echo"</script>";
  exit();
}

$sql1 ="SELECT * FROM company_customers_map where company_id = :id";
$query1= $conn -> prepare($sql1);
$query1-> bindParam(':id', $id);
$query1-> execute();
$customers=$query1->fetchAll();

$sql2 ="SELECT * FROM company_testimonials_map where company_id = :id";
$query2= $conn -> prepare($sql2);
$query2-> bindParam(':id', $id);
$query2-> execute();
$testimonials=$query2->fetchAll();

$sql3 ="SELECT * FROM company_reviews_map where company_id = :id";
$query3= $conn -> prepare($sql3);
$query3-> bindParam(':id', $id);
$query3-> execute();
$reviews=$query3->fetchAll();

if($id!='')
{
// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM companies WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
            $images = $data['images'];
            $p_progress = $data['profile_progress'];
            if($p_progress>$profile_progress){
              $profile_progress = $p_progress;
            }
        }
    }
    
}
if(isset($_POST))
{
   if(isset($_POST['update'])){
    $profile_progress = 100;
    if (($_FILES["files0"]["size"][0]) != 0) {
        $n = count($_FILES);
        for ($i = 0; $i < $n; $i++) {
            $file = $_FILES['files' . $i];
            $j    = 0;
            foreach ($file['name'] as $name) {
                //echo $name;
                $path = "./uploads/companies/" . basename($name);
                if (move_uploaded_file($file['tmp_name'][$j], $path)) {
                    // Move succeed.
                } else {
                    // Move failed. Possible duplicate?
                }
                //adding attachment
                $j = $j + 1;
            }
        }
        foreach ($_FILES as $file)
            foreach ($file['name'] as $name)
                $attachment = $attachment . $name . "|";
      }
	  if(isset($_SESSION['skip'])==1){
        $profile_progress = 67;
      }else{
         $profile_progress = 100;
      }
      if(($p_progress==67)&&( $profile_progress == 67)){
        $profile_progress = 100;
     }

     if(($p_progress==33)&&( $profile_progress == 33)){
        $profile_progress = 67;
     }
     if(($p_progress==100)&&( $profile_progress == 100)){
        $profile_progress = 100;
     }
     if(isset($_SESSION['step3'])){
        if($_SESSION['step3']==1)
         $profile_progress = 67;
     }
   $data = [
    'profile_progress' => $profile_progress,
    'images' => $attachment,
    'status' => $status,
	'id' => $id,
    ];
    $sql2 ="UPDATE `companies` SET `profile_progress`=:profile_progress, `images`=:images, `status`=:status WHERE id=:id";
   
    $query2= $conn -> prepare($sql2);

$orig_string = $id;
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
   
   if($query2-> execute($data)){
        $_SESSION['step3'] = 1;
        unset($_SESSION['step2']);
		echo "<script type=text/javascript>";
		echo "alert('Company Updation Completed Successfully...!');";
	   // echo "document.location.href='http://localhost/company-directory/'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='company_external3.php?id=".$encrypt_last_id."'";
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
    <link href="dist/css/pages/tab-page.css" rel="stylesheet">
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
                        <h4 class="text-themecolor">Manage Company Step 3</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Companies</a></li>
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
<?php
  //--------------Encrypting id to URL----------------------
$orig_string = $id;
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
            <!-- Nav tabs -->
            <div class="vtabs customvtab col-12">
                <ul class="nav nav-tabs tabs-vertical" role="tablist">
                    <li class="nav-item"> <a class="nav-link"  href="company_external.php<?php if($id!='') echo '?id='.$encrypt_last_id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 1</span> </a> </li>
                    <li class="nav-item"> <a class="nav-link"  href="company_external2.php<?php if($id!='') echo '?id='.$encrypt_last_id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 2</span></a> </li>
                    <li class="nav-item"> <a class="nav-link active"  href="company_external3.php<?php if($id!='') echo '?id='.$encrypt_last_id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 3</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" >
                    
                        <form class="form-material m-t-40 row"  method="post" enctype="multipart/form-data" >                         
                            <div class="form-group col-md-12 pt-5 pb-3 d-flex justify-content-between">
                                <h5> Customers <span class="text-danger">*</span></h5>
                                <a href="company_customer.php?com_id=<?php echo $encrypt_last_id; ?>" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;Add New</a>                          
                               
                            </div>
                             <?php foreach ($customers as $customer) { ?>
                             <div class="form-group col-md-12 border p-2 d-flex justify-content-between">
                                <div class="col-md-6">
                                    <h5><?php echo $customer['customer_name']; ?></h5>
                                </div>
                        
                                <div class="col-md-6"> 
                           <?php
                                $comp_id = $customer['company_id'];
                                $cust_id = $customer['id'];
                                // Store the cipher method 
                                $ciphering = "AES-128-CTR"; 
                                // Use OpenSSl Encryption method 
                                $iv_length = openssl_cipher_iv_length($ciphering); 
                                $options = 0;  
                                // Non-NULL Initialization Vector for encryption 
                                $encryption_iv = '1234567891098769';  
                                // Store the encryption key 
                                $encryption_key = "vofoxsolutions";
                                $company_id = openssl_encrypt($comp_id, $ciphering,$encryption_key, $options, $encryption_iv);
                                $customer_id = openssl_encrypt($cust_id, $ciphering,$encryption_key, $options, $encryption_iv);
                            ?>
                                    <a href="company_customer.php?com_id=<?php echo $company_id; ?>&id=<?php echo $customer_id; ?>" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp;Edit</a> 

                                    <buttton class="btn btn-info" onclick="deleteCustomer('<?php echo $customer['id'] ?>');" ><i class="fa fa-trash"></i>&nbsp;Delete</button> 
                                            
                                </div>
                                
                            </div>
                            <?php } ?> 

                            <div class="form-group col-md-12 pt-5 pb-3 d-flex justify-content-between">
                                <h5> Testimonials <span class="text-danger">*</span></h5>
                                <a href="company_testimonial.php?com_id=<?php echo $encrypt_last_id; ?>" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;Add New</a>                          
                               
                            </div>
                             <?php foreach ($testimonials as $testimonial) { ?>
                             <div class="form-group col-md-12 border p-2 d-flex justify-content-between">
                                <div class="col-md-6">
                                    <h5><?php echo $testimonial['testimonial_name']; ?></h5>
                                    <i><?php echo $testimonial['testimonial_text']; ?></i>
                                </div>
                                <?php
                                $comp_id        = $testimonial['company_id'];
                                $test_id = $testimonial['id'];
                                // Store the cipher method 
                                $ciphering = "AES-128-CTR"; 
                                // Use OpenSSl Encryption method 
                                $iv_length = openssl_cipher_iv_length($ciphering); 
                                $options = 0;  
                                // Non-NULL Initialization Vector for encryption 
                                $encryption_iv = '1234567891098769';  
                                // Store the encryption key 
                                $encryption_key = "vofoxsolutions";
                                $company_id = openssl_encrypt($comp_id, $ciphering,$encryption_key, $options, $encryption_iv);
                                $testimonial_id = openssl_encrypt($test_id, $ciphering,$encryption_key, $options, $encryption_iv);
                            ?>
                                <div class="col-md-6"> 
                                    
                                    <a href="company_testimonial.php?com_id=<?php echo $company_id; ?>&id=<?php echo $testimonial_id; ?>" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp;Edit</a> 

                                    <buttton class="btn btn-info" onclick="deleteTestimonial('<?php echo $testimonial['id'] ?>');" ><i class="fa fa-trash"></i>&nbsp;Delete</button> 
                                            
                                </div>
                                
                            </div>
                            <?php } ?>  

                            <div class="form-group col-md-12 pt-5 pb-3 d-flex justify-content-between">
                                <h5> Reviews <span class="text-danger">*</span></h5>
                                <a href="company_review.php?com_id=<?php echo $encrypt_last_id; ?>" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;Add New</a>                                
                            </div>
                             <?php foreach ($reviews as $review) { ?>
                             <div class="form-group col-md-12 border p-2 d-flex justify-content-between">
                                <div class="col-md-6">
                                    <h5><?php echo $review['review_name']; ?></h5>
                                    <i><?php echo $review['review_text']; ?></i>
                                    <div class="pt-2">
                                    <span class="heading">User Rating : </span>
                                        <i class="fa <?php if( $review['review_stars']>=1){ echo 'fa-star'; } else { echo 'fa-star-o'; } ?>"></i>
                                        <i class="fa <?php if( $review['review_stars']>=2){ echo 'fa-star'; } else { echo 'fa-star-o'; } ?>"></i>
                                        <i class="fa <?php if( $review['review_stars']>=3){ echo 'fa-star'; } else { echo 'fa-star-o'; } ?>"></i>
                                        <i class="fa <?php if( $review['review_stars']>=4){ echo 'fa-star'; } else { echo 'fa-star-o'; } ?>"></i>
                                        <i class="fa <?php if( $review['review_stars']>=5){ echo 'fa-star'; } else { echo 'fa-star-o'; } ?>"></i>
                                    </div>
                                </div>
                               
                                <?php
                                $comp_id        = $review['company_id'];
                                $rev_id = $review['id'];
                                // Store the cipher method 
                                $ciphering = "AES-128-CTR"; 
                                // Use OpenSSl Encryption method 
                                $iv_length = openssl_cipher_iv_length($ciphering); 
                                $options = 0;  
                                // Non-NULL Initialization Vector for encryption 
                                $encryption_iv = '1234567891098769';  
                                // Store the encryption key 
                                $encryption_key = "vofoxsolutions";
                                $company_id = openssl_encrypt($comp_id, $ciphering,$encryption_key, $options, $encryption_iv);
                                $review_id = openssl_encrypt($rev_id, $ciphering,$encryption_key, $options, $encryption_iv);
                            ?>
                                <div class="col-md-6"> 
                                    
                                    <a href="company_review.php?com_id=<?php echo $company_id; ?>&id=<?php echo $review_id; ?>" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp;Edit</a> 

                                    <buttton class="btn btn-info" onclick="deleteReview('<?php echo $review['id'] ?>');" ><i class="fa fa-trash"></i>&nbsp;Delete</button> 
                                            
                                </div>
                                
                            </div>
                            <?php } ?> 

                            <div class="form-group pt-4 col-md-12">
                                <h5> Add Image / Multiple Images <span class="text-danger">*</span></h5>
                                     
                            </div>
                            <div class="form-group pb-3">
                               <div class="col-sm-12">
                                <?php if($images!=''){ ?>
                                <input type="hidden" name="attach" value="<?php echo $images;?>" id="attach">
                                <div class="d-flex align-content-around flex-wrap">
                                <?php
                                    $t = explode("|", $images);
                                    foreach ($t as $attach) {
                                        $attach = trim($attach);
                                    
                                    if($attach!=NULL){
                                ?>
                                    <span class="card border col-md-3 m-1 pt-3" >
                                    <a href="./uploads/companies/<?php echo $attach;?>" target="_blank" >
                                        <img class="card-img-top" src="./uploads/companies/<?php echo $attach;?>" style="height:185px;" alt="Company Image">
                                        <div class="card-body">
                                            <button class="btn btn-primary" onclick="removeImage('<?php echo $id; ?>','<?php echo $attach;?>');" ><i class="fa fa-remove" ></i> Remove </button>
                                        </div>
                                    </a>
                                    </span>
                                    <!-- </br><a href="./uploads/companies/<?php echo $attach;?>" target="_blank" ><img src="./uploads/companies/<?php echo $attach;?>" height="100" alt="<?php echo $attach;?>" /></a> &nbsp&nbsp <button style="color:red;" onclick="removeImage('<?php echo $id; ?>','<?php echo $attach;?>');"> <i class="fa fa-remove" ></i>Remove </button>  -->
                                    <?php } }} ?>
                                </div>
                                </br></br><strong id="more_files">Image(s) &nbsp&nbsp&nbsp <i  class="fa fa-plus mb-3" ></i> Add More</Strong><br/>
                                <input type='file' name='files0[]' id="files0" multiple>
                                </div>
                            </div>

                            <div class="col-md-12 text-xs-right">
                                <?php  if($id!='') { ?>
                                    <input type="hidden" name="id" value="<?php echo $id?>" >
                                    <button type="submit" name="update" class="btn btn-info">Update & Continue</button>
                                <?php } else { ?>
                                    <button type="submit" name="add" class="btn btn-info">Save & Continue</button>
                                <?php } ?>
                                  &nbsp;  <a href="index.php" class="btn btn-inverse">Skip</a>
                            </div>
                        </form>
                    </div>
                </div>
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
<script>
    $(document).ready(function() {
        localStorage.clear();
      });
    function deleteCustomer(id) {
        var r = confirm("Do you want to delete customer !");
        if (r == true) {   
          $.ajax({
			type: "POST",
			url: "delete_customer.php",
			data:'dlt_id='+id,
			success: function(data){
                alert('Customer deleted Successfully !');
                location.reload();
			}
			});
         
        } 
     
      }
    function deleteTestimonial(id) {
        var r = confirm("Do you want to delete testimonial !");
        if (r == true) {   
          $.ajax({
			type: "POST",
			url: "delete_testimonial.php",
			data:'dlt_id='+id,
			success: function(data){
                alert('Testimonial deleted Successfully !');
                location.reload();
			}
			});
         
        } 
     
      }
      function deleteReview(id) {
        var r = confirm("Do you want to delete Review !");
        if (r == true) {   
          $.ajax({
			type: "POST",
			url: "delete_review.php",
			data:'dlt_id='+id,
			success: function(data){
                alert('Review deleted Successfully !');
                location.reload();
			}
			});
         
        } 
     
      }
      $(document).on('click','#more_files', function() {
        var numOfInputs = 1;
        while($('#files'+numOfInputs).length) { numOfInputs++; }//once this loop breaks, numOfInputs is greater than the # of browse buttons

        $("<input type='file' multiple/>")
            .attr("id", "files"+numOfInputs)
            .attr("name", "files"+numOfInputs+"[]")
            .insertAfter("#files"+(numOfInputs-1));

        $("<br/>").insertBefore("#files"+numOfInputs);
    });
    function removeImage(id,name){
    //alert(id);
    $.ajax({
        type: "POST",
        url: "rmimage.php",
        data:{"id": id, "name": name},
        success: function(data){
        alert(data);
        location.reload();
        }
        });
    }
</script>		
</body>

</html>