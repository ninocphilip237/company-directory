<?php
session_start();
//Database Configuration File
include('config.php');

// print_r($_FILES);
// error_reporting(0);
if(isset($_SESSION['userlogin'])){
if($_SESSION['usertype'] != 'admin'){
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

$id = $com_id = $customer_name = $companies = "";
$status = 1;
	$sql1 ="SELECT * FROM companies";
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $companies=$query1->fetchAll();

if(isset($_GET['com_id'])){
  $com_id = $_GET['com_id'];
}
if(isset($_GET['id'])){
   $id=$_GET['id'];
// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM company_customers_map WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
			$customer_name = $data['customer_name'];
            $com_id = $data['company_id'];
        }
    }
}
if(isset($_POST))
{
	
   if(isset($_POST['add'])){
	   
	$data = [
    'company_id' => $com_id,
    'customer_name' => $_REQUEST['customer_name'],
	'added_user' => $_SESSION['uid'],
    ];
   $sql2 ="INSERT INTO `company_customers_map`(`company_id`, `customer_name`, `added_user`) VALUES (:company_id, :customer_name, :added_user)";
   $query2= $conn -> prepare($sql2);
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Customer Added Successfully...!');";
		echo "document.location.href='manage_company3.php?id=".$com_id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_company3.php?id=".$com_id."'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
	
   $data = [
    'company_id' => $com_id,
    'customer_name' => $_REQUEST['customer_name'],
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `company_customers_map` SET `company_id`=:company_id, `customer_name`=:customer_name WHERE id=:id";
  
   $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('Customer Updated Successfully...!');";
		echo "document.location.href='manage_company3.php?id=".$com_id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_company3.php?id=".$com_id."'";
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
    <title>Hire My Developer | Manage Customer</title>
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
                        <h4 class="text-themecolor">Manage Customer</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="manage_company3.php?id=<?php echo $com_id; ?>">Manage Company</a></li>
                                <li class="breadcrumb-item active">Manage Customer</li>
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
                                        <h5>Customer Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="customer_name" class="form-control" required data-validation-required-message="This field is required..." value="<?php echo $customer_name;?>"> 
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

                                    
                                       <input type="hidden" name="com_id" value="<?php echo $com_id?>" >
                                    <div class="text-xs-right">
									<?php  if($id!='') { ?>
									    <input type="hidden" name="id" value="<?php echo $id?>" >
                                        <button type="submit" name="update" class="btn btn-info">Update</button>
									<?php } else { ?>
									    <button type="submit" name="add" class="btn btn-info">Add</button>
									<?php } ?>
                                        <a href="manage_company3.php?id=<?php echo $com_id; ?>" class="btn btn-inverse">Cancel</a>
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
