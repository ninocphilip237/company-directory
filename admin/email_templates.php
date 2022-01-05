<?php
error_reporting(0);
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


if(isset($_POST['save'])){
	 $_REQUEST['area']; 
	 $data = [
    'template' => $_REQUEST['area'],
    'added_user' => $_SESSION['uid']
    ]; 
    

    $sql ="SELECT * FROM email_template ";
    $query= $conn -> prepare($sql);
    $query-> execute();
    $results=$query->fetchAll();
	if($query->rowCount() > 0)
    {
        $sql3 ="UPDATE `email_template` SET `template`=:template, `added_user`=:added_user  WHERE id=1 ";  
        $query3= $conn -> prepare($sql3);
        if($query3-> execute($data)){
             echo "<script type=text/javascript>";
             echo "alert('Template Updated Successfully...!');";
             echo "document.location.href='email_templates.php'";
             echo"</script>";
         }
         else
         {
             echo "<script type=text/javascript>";
             echo "alert('Error...!');";
             echo "document.location.href='email_templates.php'";
             echo"</script>";
         }
  
    }

    else{

        $sql2 ="INSERT INTO email_template(`template`, `added_user`) VALUES (:template, :added_user) ";
        $query2= $conn -> prepare($sql2);
        if($query2-> execute($data)){
             echo "<script type=text/javascript>";
             echo "alert('Template Added Successfully...!');";
             echo "document.location.href='manage_email_templates.php'";
             echo"</script>";
         }
         else
         {
             echo "<script type=text/javascript>";
             echo "alert('Error...!');";
             echo "document.location.href='manage_email_templates.php'";
             echo"</script>";
         }

    }
   		
   }



?>

<?php 
    $sql1 ="SELECT * FROM email_template"; 
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $templates=$query1->fetchAll();

    foreach($templates as $template){
        $a=$template['template']; 
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
    <title>Hire My Developer | Email Templates</title>
    <link rel="stylesheet" href="../assets/node_modules/html5-editor/bootstrap-wysihtml5.css" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <h4 class="text-themecolor">Email Template</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Email Template</li>
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
                            <div class="card-body">
                               
                                <form method="post" action="">
                                
   
                                    <?php
                                    if($a!=""){
                                    
                                        ?>
                                <textarea id="mymce" name="area" value=""><?php echo $a; ?></textarea>
                                <?php }
                                else{  ?>
                                    <textarea id="mymce" name="area" value=""><?php echo $a; ?></textarea>

                              <?php  } ?>
    
                                   
                                    <div class="button-bottom">
                                    <button type="submit" name="save" class="btn btn-info save-button">Save</button>
                                    <a href="email_templates.php" class="btn btn-inverse cancel-button">Cancel</a>
                                    </div>
                                   
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
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
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <!-- Footable -->
        <script src="../assets/node_modules/footable/js/footable.all.min.js"></script>
        <!--FooTable init-->
        <script src="dist/js/pages/footable-init.js"></script>
    
    <script src="../assets/node_modules/tinymce/tinymce.min.js"></script>
    <script>
    $(document).ready(function() {

        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                browser_spellcheck: true,
                
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
    </script> 
</body>

</html>