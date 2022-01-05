<?php
session_start();
//Database Configuration File
include('config.php');
// print_r('-----------------------------------'.$_REQUEST['meta_keywords']);
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

$id = $services = $hourly_rates = $team_sizes = $portfolios = $rph_id = $tz_id = "";
$status = 0;
if($_SESSION['usertype'] == 'admin')
$status = 1;
$p_progress = 0;
$profile_progress = 33;


if(isset($_GET['id'])){
    $id=$_GET['id'];
}
else
{
  echo "<script type=text/javascript>";
  echo "alert('Please Complete Step 1 to access this page !');";
  echo "document.location.href='manage_company.php'";
  echo"</script>";
  exit();
}

$sql1 ="SELECT * FROM hourly_rates where status ='1'";
$query1= $conn -> prepare($sql1);
$query1-> execute();
$hourly_rates=$query1->fetchAll();

$sql2 ="SELECT * FROM team_sizes where status ='1'";
$query2= $conn -> prepare($sql2);
$query2-> execute();
$team_sizes=$query2->fetchAll();

$sql3 ="SELECT * FROM company_portfolio_map where company_id = :id and status ='1'";
$query3= $conn -> prepare($sql3);
$query3-> bindParam(':id', $id);
$query3-> execute();
$portfolios=$query3->fetchAll();

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
			$rph_id = $data['rate_per_hour'];
            $tz_id = $data['team_size'];
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
    if(($p_progress==67)&&( $profile_progress == 67)){
       $profile_progress = 100;
    }
    if(($p_progress==67)&&( $profile_progress == 33)){
        $profile_progress = 67;
     }
     if(($p_progress==33)&&( $profile_progress == 33)){
        $profile_progress = 67;
     }
     if(isset($_SESSION['step2'])){
        if($_SESSION['step2']==1)
         $profile_progress = 67;
     }
   $data = [
    'profile_progress' => $profile_progress,
    'rate_per_hour' => $_REQUEST['hourly_rate'],
    'team_size' => $_REQUEST['team_size'],
    'status' => $status,
	'id' => $_REQUEST['id'],
    ];
    $sql2 ="UPDATE `companies` SET `profile_progress`=:profile_progress, `rate_per_hour`=:rate_per_hour, `team_size`=:team_size, `status`=:status WHERE id=:id";
   
    $query2= $conn -> prepare($sql2);
   
   if($query2-> execute($data)){
        $_SESSION['step2'] = 1;
        unset($_SESSION['skip']);
        unset($_SESSION['step3']);
		echo "<script type=text/javascript>";
		echo "alert('Company Step2 Updated Successfully...!');";
		echo "document.location.href='manage_company3.php?id=".$id."'";
		echo"</script>";
    }
    else
    {
	    echo "<script type=text/javascript>";
		echo "alert('Error...!');";
		echo "document.location.href='manage_company2.php?id=".$id."'";
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
                        <h4 class="text-themecolor">Manage Company Step 2</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item"><a href="companies.php">Companies</a></li>
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
                    <li class="nav-item"> <a class="nav-link"  href="manage_company.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 1</span> </a> </li>
                    <li class="nav-item"> <a class="nav-link active"  href="manage_company2.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 2</span></a> </li>
                    <li class="nav-item"> <a class="nav-link"  onclick="myfun();"  href="manage_company3.php<?php if($id!='') echo '?id='.$id; ?>" ><span class="hidden-sm-up"><i class="ti-control-forward"></i></span> <span class="hidden-xs-down">Step 3</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" >
                    
                        <form class="form-material m-t-40 row"  method="post" enctype="multipart/form-data" >

                            <div class="col-md-6 d-flex flex-column bd-highlight mb-3 border p-4">
                                <h5 class="p-2 bd-highlight">Hourly Rate <span class="text-danger">*</span></h5>
                                <?php if($_SESSION['usertype'] == 'admin') { ?>
                                  <a href="hourly_rates.php" target="_blank" class="p-2 bd-highlight btn btn-info ml-5 mr-5 mt-2 mb-3">Add/Edit</a>
                                <?php } ?>
                                <ul class="list-group p-2 bd-highlight">

                                <?php 
                                     foreach($hourly_rates as $hr){ 
                                ?>
                                    <li class="list-group-item">
                                         <div class="custom-control custom-radio">
                                            <input type="radio" name="hourly_rate" class="custom-control-input" id="hr<?php echo $hr['id']; ?>"  value="<?php echo $hr['id']; ?>" <?php if($hr['id']==$rph_id) echo "checked" ?> required >
                                            <label class="custom-control-label" for="hr<?php echo $hr['id']; ?>"> <?php echo $hr['text']; ?> </label>
                                        </div>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                            
                            <div class="col-md-6 d-flex flex-column bd-highlight mb-3 border p-4">
                                <h5 class="p-2 bd-highlight">Team Size <span class="text-danger">*</span></h5>
                                <?php if($_SESSION['usertype'] == 'admin') { ?>
                                  <a href="team_sizes.php" target="_blank" class="p-2 bd-highlight btn btn-info ml-5 mr-5 mt-2 mb-3">Add/Edit</a>
                                <?php } ?>
                                <ul class="list-group p-2 bd-highlight">

                                <?php 
                                     foreach($team_sizes as $tz){ 
                                ?>
                                    <li class="list-group-item">
                                         <div class="custom-control custom-radio">
                                            <input type="radio" name="team_size" class="custom-control-input" id="tz<?php echo $tz['id']; ?>"  value="<?php echo $tz['id']; ?>" <?php if($tz['id']==$tz_id) echo "checked" ?> required >
                                            <label class="custom-control-label" for="tz<?php echo $tz['id']; ?>"> <?php echo $tz['text']; ?> </label>
                                        </div>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>

                           
                            
                            <div class="form-group col-md-12 pt-5 pb-3 d-flex justify-content-between">
                                <h5> Portfolio/Projects Completed </h5>
                                <a href="manage_portfolio.php?com_id=<?php echo $id; ?>" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;Add New</a>                          
                            </div>
                        <?php foreach ($portfolios as $portfolio) { ?>
                             <div class="form-group col-md-12 border pb-3">
                                <div class="col-md-12 p-3">
                                    <h5><?php echo $portfolio['portfolio_title']; ?></h5>
                                </div>
                        
                                <div class="col-md-12 d-flex"> 
                                        
                                      <img src="./uploads/portfolios/<?php echo $portfolio['image']; ?>"  class="col-md-2"></img>
                                                                     
                                      <div class="col-md-10">
                                        <h5>Reference Link :  <a href="<?php echo $portfolio['reference_link']; ?>"  target="_blank" > <?php echo $portfolio['reference_link']; ?> </a> </h5>
                                    
                                        <a href="manage_portfolio.php?com_id=<?php echo $portfolio['company_id']; ?>&id=<?php echo $portfolio['id']; ?>" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp;Edit</a> 
                                        <buttton class="btn btn-info" onclick="deletePortfolio('<?php echo $portfolio['id'] ?>');" ><i class="fa fa-trash"></i>&nbsp;Delete</button> 
                                    </div>
                                   
                                </div>
                                
                            </div>
                        <?php } ?> 

                            <div class="col-md-12 text-xs-right">
                                <?php  if($id!='') { ?>
                                    <input type="hidden" name="id" value="<?php echo $id?>" >
                                    <button type="submit" name="update" class="btn btn-info">Update & Continue</button>
                                <?php } else { ?>
                                    <button type="submit" name="add" class="btn btn-info">Save & Continue</button>
                                <?php } ?>
                                  &nbsp;  <a href="manage_company3.php<?php if($id!='') echo '?id='.$id; ?>" onclick="myfun();" class="btn btn-inverse">Skip</a>
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
      function deletePortfolio(id) {
        var r = confirm("Do you want to delete portfolio !");
        if (r == true) {   
          $.ajax({ 
			type: "POST",
			url: "delete_portfolio.php",
			data:'dlt_id='+id,
			success: function(data){
                alert('Portfolio deleted Successfully !');
                location.reload();
			}
			});
         
        } 
     
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
    </script>
</body>

</html>