<?php
session_start();
//Database Configuration File
include('config.php');

// print_r($_FILES);
// error_reporting(0);
 
$user_id=$_SESSION['uid']; 
$id = $l_name = $m_title = $m_keywords =  $m_password = "";
if ($user_id == 1) {
    $status = 1;
    } else {
    $status = 0;
    }

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



if(isset($_GET['id'])){
   $id=$_GET['id'];
// Fetch data from database  the basis of username/email and password
    $sql ="SELECT * FROM users WHERE id=:id";
    $query= $conn -> prepare($sql);
    $query-> bindParam(':id', $id);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        foreach ($results as $data) {
            $l_name = $data['username'];
            $m_title = $data['email'];
            $m_keywords = $data['user_role'];
            $m_password = $data['password']; 
			
        }
    }
}

	
	
   if(isset($_POST['add'])){
	   
	$data = [
    
    'username' => $_REQUEST['username'],
    'email' => $_REQUEST['email'],
    'password' => base64_encode($_REQUEST['password']),
    'role' => $_REQUEST['role'],
    'status' => $status,
    
	
    ];
   $sql2 ="INSERT INTO users(`username` ,`email` ,`password`, `user_role`,user_status ) VALUES (:username , :email ,:password ,:role ,:status)";
   $query2= $conn -> prepare($sql2);
   if($query2-> execute($data)){
		echo "<script type=text/javascript>";
		echo "alert('User Added Successfully...!');";
		echo "document.location.href='users.php'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_users.php'";
		echo"</script>";
    }		
   }
   if(isset($_POST['update'])){
	
    
     $data = [
     'username' => $_REQUEST['username'],
     'email' => $_REQUEST['email'],
     'password' => base64_encode($_REQUEST['password']),
     'role' => $_REQUEST['role'],
     'id' => $_REQUEST['id'],
     ];
     $sql2 ="UPDATE `users` SET  `username`=:username , `email`=:email , `password`=:password , `user_role`=:role WHERE id=:id";
    
    
    $query2= $conn -> prepare($sql2);
    
    if($query2-> execute($data)){
         echo "<script type=text/javascript>";
         echo "alert('User Updated Successfully...!');";
         echo "document.location.href='users.php'";
         echo"</script>";
     }
     else
     {
         echo "<script type=text/javascript>";
         echo "alert('Error...!');";
         echo "document.location.href='manage_users.php'";
         echo"</script>";
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
    <title>Hire My Developer | Manage Users</title>
    <!-- Page CSS -->
    <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="dist/css/pages/footable-page.css" rel="stylesheet">
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
                    <h4 class="text-themecolor">Users</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                            <li class="breadcrumb-item active">Manage users</li>
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
                <div class="login-register"
                    style="background-image:url(../assets/images/background/login-register.jpg);">
                    <div class="login-box card">
                        <div class="card-body">

                            <form class="m-t-40" novalidate method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <h5>User Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="username" class="form-control" required
                                            data-validation-required-message="This field is required..."
                                            value="<?php echo $l_name;?>">
                                    </div>

                                </div>



                                <div class="form-group">
                                    <h5>Email <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}"
                                            value="<?php echo $m_title;?>" name="email" class="form-control" required
                                            data-validation-required-message="This field is required"> </div>

                                </div>
                                <div class="form-group">
                                    <h5>Password <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="password" value="<?php echo base64_decode($m_password);?>"
                                            name="password" class="form-control" required
                                            data-validation-required-message="This field is required"> </div>

                                </div>



                                <div class="form-group">
                                    <h5>Role <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="role" id="role" required="" class="form-control custom-select"
                                            aria-invalid="false">
                                            <?php if($id == ''){?>
                                            <option value="">Select Role</option>
                                            <?php }?>
                                            <option value="admin" <?php if($m_keywords=='admin') echo "selected"; ?>>
                                                Admin</option>
                                            <option value="d_entry"
                                                <?php if($m_keywords=='d_entry') echo "selected"; ?>>Data entry Operator
                                            </option>


                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>



                                <div class="text-xs-right">
                                    <?php  if($id!='') { ?>
                                    <input type="hidden" name="hidden" value="<?php echo $id?>">
                                    <button type="submit" name="update" class="btn btn-info">Update</button>
                                    <?php } else { ?>
                                    <button type="submit" name="add" class="btn btn-info">Add</button>
                                    <?php } ?>
                                    <a href="users.php" class="btn btn-inverse">Cancel</a>
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
    $(".select2").select2();
    //For Loading Selected State's Cities 
    function selectState(val) {

        $.ajax({
            type: "POST",
            url: "d_state.php",
            data: 'state_id=' + val,
            success: function(data) {
                $("#city").html(data);
            }
        });
    }
    </script>
</body>

</html>