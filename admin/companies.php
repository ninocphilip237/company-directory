<?php
session_start();
//Database Configuration File
include('config.php');
// error_reporting(0);
// print_r($_REQUEST);
if(isset($_SESSION['userlogin'])){
if(($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')){
  echo "<script type=text/javascript>";
  echo "alert('You are not authorized to access this page !');";
  echo "document.company.href='index.php'";
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

    $states=$cities=$locations=$services=$state_id=$city_id=$loc_id=$serv_id=$user_id='';

    if(isset($_SESSION['uid']))
    $user_id=$_SESSION['uid'];

    // Fetch data from database 
    $sql ="SELECT distinct companies.* FROM companies INNER JOIN
    company_service_map
    ON
    company_service_map.company_id = companies.id
    INNER JOIN
    services
    ON
    services.id = company_service_map.service_id
    INNER JOIN
    company_location_map
    ON
    company_location_map.company_id = companies.id where 1 ";

    if(isset($_POST))
    {
     if(isset($_POST['service'])&&$_POST['service']!='')
     {
      $serv_id = $_POST['service'];
      // $sql = $sql.' and service_id=:serid';
      $sql = $sql.' and services.id ='.$serv_id;
     }
     if(isset($_POST['state'])&&$_POST['state']!='')
     {
      $state_id = $_POST['state'];
      $sql = $sql.' and company_location_map.state_id='.$state_id;
     }
     if(isset($_POST['city'])&&$_POST['city']!='')
     {
      $city_id = $_POST['city'];
      $sql = $sql.' and company_location_map.city_id='.$city_id;
     }
     if(isset($_POST['location'])&&$_POST['location']!='')
     {
      $loc_id = $_POST['location'];
      $sql = $sql.' and company_location_map.location_id='.$loc_id;
     }
        
    }
    $sql .= ' ORDER BY companies.status';
    //echo $sql;
    $query= $conn -> prepare($sql);

    if(isset($_POST))
    {
    //  if(isset($_POST['service'])&&$_POST['service']!='')
    //  {
    //     $query-> bindParam(':serid', $_POST['service']);
    //  }
     if(isset($_POST['state'])&&$_POST['state']!='')
     {
        $query-> bindParam(':sid', $_POST['state']);
        $state_id =  $_POST['state'];
        $sql1 = "SELECT * FROM states WHERE  states.status='1'";
        $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and states.status='1' WHERE cities.status='1'" ;
     }else{
        $sql1 ="SELECT * FROM states WHERE states.status='1'";

       // $sql2 ="SELECT * FROM cities WHERE cities.status='1'";
       $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON  states.id = cities.state_id and  states.status='1'  WHERE cities.status='1' " ;

       $sql3 = "SELECT DISTINCT locations.* FROM locations INNER JOIN states  ON states.id = locations.state_id  INNER JOIN cities  ON cities.id = locations.city_id and states.status=1 and cities.status=1  WHERE locations.status ='1' ";
     }
     if(isset($_POST['city'])&&$_POST['city']!='')
     {
        $query-> bindParam(':cid', $_POST['city']);
        $city_id =  $_POST['city'];
        $sql1 = "SELECT * FROM states WHERE   states.status='1'";
        $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and states.status='1' WHERE cities.status='1' " ;

     }else{
        $sql1 = "SELECT * FROM states WHERE   states.status='1'";

        $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and  states.status='1' WHERE cities.status='1' " ;

        $sql3 = "SELECT DISTINCT locations.* FROM locations INNER JOIN states  ON states.id = locations.state_id  INNER JOIN cities  ON cities.id = locations.city_id and states.status=1 and cities.status=1  WHERE locations.status ='1' ";
     }
     
     if(isset($_POST['location'])&&$_POST['location']!='')
     {
        $query-> bindParam(':lid', $_POST['location']);
        $sql1 = "SELECT * FROM states WHERE  states.status='1'";

        $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and states.status='1' WHERE cities.status='1' " ;

        $sql3 = "SELECT DISTINCT locations.* FROM locations INNER JOIN states  ON states.id = locations.state_id  INNER JOIN cities  ON cities.id = locations.city_id and states.status=1 and cities.status=1  WHERE locations.status ='1' " ;

     } 
    // //   else if($state_id!=''){
    // //     $sql3 = "SELECT * FROM locations WHERE state_id = '$state_id '";
       
    // //  }
     else{
        $sql2 = "SELECT DISTINCT cities.* FROM cities  INNER JOIN states  ON states.id = cities.state_id and  states.status='1' WHERE cities.status='1' " ;

        $sql3 ="SELECT DISTINCT locations.* FROM locations INNER JOIN states  ON states.id = locations.state_id  INNER JOIN cities  ON cities.id = locations.city_id and states.status=1 and cities.status=1  WHERE locations.status ='1' ";
        
     }
    }

    // $query-> bindParam(':usname', $uname);
    $query-> execute();
    $results=$query->fetchAll();

    
    $query1= $conn -> prepare($sql1);
    $query1-> execute();
    $states=$query1->fetchAll();
	
	
    $query2= $conn -> prepare($sql2);
    $query2-> execute();
    $cities=$query2->fetchAll();

   // $sql3 ="SELECT * FROM locations";
    $query3= $conn -> prepare($sql3);
    $query3-> execute();
    $locations=$query3->fetchAll();
	
	$sql4 ="SELECT * FROM services";
    $query4= $conn -> prepare($sql4);
    $query4-> execute();
    $services=$query4->fetchAll();


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
    <title>Hire My Developer | Companies</title>
    <!-- Footable CSS -->
    <link href="../assets/node_modules/footable/css/footable.core.css" rel="stylesheet">
    <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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
                        <h4 class="text-themecolor">Companies</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Companies</li>
                            </ol>
                            <a href="manage_company.php">
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button></a>
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
                                <form method="post" >
                                    <div class="d-flex">
                                        <div class="form-group col-3">
                                            <h5>Services </h5>
                                            <div class="controls">
                                                <select class="select2 form-control custom-select" id="service" name="service" style="width: 100%; height:36px;" >
                                                <option value="">Select Service</option>
                                                <?php 
                                                    foreach($services as $service){ 
                                                ?>
                                                <option value="<?php echo $service['id']; ?>" <?php if($serv_id==$service['id']) echo "selected"; ?>  ><?php echo $service['service_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <h5>State </h5>
                                            <div class="controls">
                                                <select class="select2 form-control custom-select" id="state" name="state" style="width: 100%; height:36px;"   onchange="selectState(this.value);" >
                                                <option value="">Select State</option>
                                                <?php 
                                                    foreach($states as $state){ 
                                                ?>
                                                <option value="<?php echo $state['id']; ?>" <?php if($state_id==$state['id']) echo "selected"; ?>  ><?php echo $state['state_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <h5>City </h5>
                                            <div class="controls">
                                                <select class="select2 form-control custom-select" id="city" name="city" style="width: 100%; height:36px;"   onchange="selectCity(this.value);" >
                                                <option value="">Select City</option>
                                                <?php 
                                                    foreach($cities as $city){ 
                                                ?>
                                                <option value="<?php echo $city['id']; ?>" <?php if($city_id==$city['id']) echo "selected"; ?> ><?php echo $city['city_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <h5>Location </h5>
                                            <div class="controls d-flex align-items-center justify-content-center">
                                                <select class="select2 form-control custom-select" id="location" name="location" style="width: 100%; height:36px;"  >
                                                <option value="">Select Location</option>
                                                <?php 
                                                    foreach($locations as $location){ 
                                                ?>
                                                <option value="<?php echo $location['id']; ?>" <?php if($loc_id==$location['id']) echo "selected"; ?>  ><?php echo $location['location_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                &nbsp;  &nbsp;
                                                                                        
                                            <button type="submit" class="btn btn-md btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Filter Results"><i class="ti-filter" aria-hidden="true"></i></button>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </form>

                    
                                <div class="table-responsive">
                                    <table id="demo-foo-addrow2" class="table m-t-30 table-hover no-wrap contact-list" data-page-size="5">
                                        <thead>
                                            <tr>
                                                <th data-type="numeric" data-sort-initial="true">Sl.no</th>
												<th class="logo_th">Logo</th>
                                                <th>Company Name</th>
												<th>Description</th>
                                          <!--      <th>Meta Data</th> -->
                                                <th data-type="numeric" >Progress</th>
                                                <th>Status</th>
												<th>Actions</th>

                                            </tr>
                                        </thead>
									 <div class="m-t-40">
                                        <div class="d-flex">
                                            <div class="mr-auto">
                                                 <label class="form-inline">Show &nbsp;
													<select id="demo-show-entries">
														<option value="5">5</option>
														<option value="10">10</option>
														<option value="15">15</option>
														<option value="20">20</option>
												    </select> 
												 &nbsp; entries </label>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="form-group">
                                                    <input id="demo-input-search2" type="text" placeholder="Search" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
								     </div>
                                        <tbody>
                                        <?php $i=0;
                                                foreach ($results as $result)
                                                {  $i++;
                                                    if($serv_id!=''){
                                                    
                                                //     $sqls = "SELECT * FROM `company_service_map` WHERE `service_id`=:serid and `company_id`=:com_id";
                                                //     $querys = $conn->prepare($sqls);
                                                //     $querys->bindParam(':serid', $serv_id);
                                                //     $querys->bindParam(':com_id', $result['id']);
                                                //     $querys->execute();
                                                  //   $s = $querys->fetchAll();
                                                  // if ($querys->rowCount() > 0) {
                                                    $query-> execute();
                                                    $results=$query->fetchAll();
                                                    if ($query->rowCount() > 0) {
                                                       
                                                ?>
                                            <tr>
                                                <td><?php // echo $result['id']; 
                                                echo $i; 
                                                     ?></td>
												
												<td>
													<?php 
														if($result['logo']){
														?>
														<img src="./uploads/companies/<?php echo $result['logo']; ?>" alt="No Logo" />
														<?php
														}		
													?>
												</td>
                                                
                                                <td><?php echo $result['company_name']?></td>
												
												 <td><?php echo wordwrap($result['company_description'],50,"<br>\n"); ?></td>
                                             <!-- 
												<td>
												    <i class="font-weight-bold">Title : </i><?php //echo $result['meta_title']; ?> </br> 
												    <i class="font-weight-bold">Description : </i><?php //echo $result['meta_description']; ?></br>
													<i class="font-weight-bold">Keywords : </i><?php //echo $result['meta_keywords']?>
												</td>
                                            -->
                                                <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" style="width: <?php echo $result['profile_progress']; ?>%; height:15px;" role="progressbar"><?php echo $result['profile_progress']; ?>%</div>
                                                </div>
                                                </td>
                                                <td>
												<?php if($result['status']==1){ ?>
												   <span class="label label-table label-success"><i class="fa fa-check"> </i> Active</span>
												<?php } else { ?>
                                                    <span class="label label-table label-danger">Deactivated</span>
                                                <?php } ?>												 
												</td>
                                                
                                                <td>
												    <?php if($result['status']==0){ ?>
												        <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeLocationStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
													<?php } else { ?>
														<a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeLocationStatus('<?php echo $result['id'] ?>',0);" >Deactivate</a>
													<?php } ?>	
                                                    <a href="manage_company.php?id=<?php echo $result['id']?>" >													
													<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    </a>
													
                                                    <button type="button" onclick="deleteLocation('<?php echo $result['id'] ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                    
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                              }
                                             else{
                                            ?>
                                                 
                                                 <tr>
                                                <td><?php echo $i; //echo $result['id']; ?></td>
												
												<td>
													<?php 
														if($result['logo']){
														?>
														<img src="./uploads/companies/<?php echo $result['logo']; ?>" alt="No Logo" />
														<?php
														}		
													?>
												</td>
                                                
                                                <td><?php echo $result['company_name']?></td>
												
												 <td><?php echo wordwrap($result['company_description'],50,"<br>\n"); ?></td>
                                             <!-- 
												<td>
												    <i class="font-weight-bold">Title : </i><?php //echo $result['meta_title']; ?> </br> 
												    <i class="font-weight-bold">Description : </i><?php //echo $result['meta_description']; ?></br>
													<i class="font-weight-bold">Keywords : </i><?php //echo $result['meta_keywords']?>
												</td>
                                            -->
                                                <td data-sort-value="<?php echo $result['profile_progress']; ?>">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" style="width: <?php echo $result['profile_progress']; ?>%; height:15px;" role="progressbar"><?php echo $result['profile_progress']; ?>%</div>
                                                </div>
                                                </td>
                                                <td>
                                                <?php
                                                    $status = $result['status'];
                                                    if($result['added_user']==1) {
                                                        if ($status==1){?>
                                                            <span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span>
                                                        <?php }
                                                        else if($status==2){?>
                                                            <span class="label label-table label-danger">Disabled</span>
                                                        <?php }
                                                        else{?>
                                                            <span class="label label-table label-warning">Not Approved</span>
                                                        <?php }

                                                    }
                                                    else {
                                                        if ($status==1){?>
                                                            <span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span>
                                                        <?php }
                                                        else if($status==2){?>
                                                            <span class="label label-table label-danger">Rejected</span>
                                                        <?php }
                                                        else{?>
                                                            <span class="label label-table label-warning">Not Approved</span>
                                                        <?php }
                                                    }
                                                    
                                                ?>												 
												</td>
                                                
                                                <td>
                                                    <?php
                                                        if($user_id==1) {

                                                            if($result['added_user']==1){
                                                                if($status==0){ ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                                <?php } else if($result['status']==1) { ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',2);" >Disable</a>
                                                                <?php }
                                                                else{?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php }
                                                            }
                                                            else{
                                                                if($status==0){ ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                                <?php } else if($result['status']==1) { ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',2);" >Reject</a>
                                                                <?php }
                                                                else{?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeCompanyStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php }
                                                            }
                                                            


                                                        }
                                                    ?>
                                                    <?php
                                                        if($user_id!=1) {
                                                            if($status==0) {?>
                                                        <a href="manage_company.php?id=<?php echo $result['id']?>" >													
                                                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_company.php?id=<?php echo  $result['id'];  ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                        </a>
                                                        
                                                        <button type="button" onclick="deleteCompany('<?php echo  $result['id'];  ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                            <?php }
                                                            else{ 
                                                              if($result['profile_progress']!=100) {  
                                                                ?>
                                                                <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_company.php?id=<?php echo  $result['id'];  ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                          <?php } }
                                                         
                                                        }
                                                        else{?>
                                                           
                                                            <a href="manage_company.php?id=<?php echo $result['id']?>" >													
                                                        <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_company.php?id=<?php echo  $result['id'];  ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                        </a>
                                                        
                                                        <button type="button" onclick="deleteCompany('<?php echo  $result['id'];  ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                    <?php }
                                                    ?>
                                                    
                                                </td>
                                            </tr>

                                            <?php
                                             }
                                             
                                            }
                                            
                                             ?>

                                        </tbody>
                                        <tfoot>
                                            <tr> 
                                                <td colspan="2">
												  <!-- <a href="manage_company.php" class="btn btn-info btn-rounded">Add New Location</button> -->
                                                </td>												
                                                <td colspan="6">
                                                    <div class="text-right">
                                                        <ul class="pagination"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
  
 
    <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
	<!-- Footable -->
    <script src="../assets/node_modules/footable/js/footable.all.min.js"></script>
	 <!--FooTable init-->
    <script src="dist/js/pages/footable-init.js"></script>
	<script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
                                <script>
        // For select 2
        $(".select2").select2();
        $(document).ready(function() {
            setTimeout(function(){  $(".logo_th .footable-sort-indicator").hide(); }, 1000);
            localStorage.clear();
        });
       
      function deleteCompany(id) {
        var r = confirm("Do you want to delete company !");
        if (r == true) {   
          alert('Company deleted Successfully !');
          document.location.href='delete_company.php?dlt_id='+id;
        } 
     
      }
	  function changeCompanyStatus(id,flag) {
        var r = confirm("Do you want to change the status of this company?");
        if (r == true) {   
          alert('Company Status Changed Successfully !');
          document.location.href='status_company.php?id='+id+'&flag='+flag;
        } 
     
      }
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
        //For Loading Selected City's Locations 
	    function selectCity(val) {
            $.ajax({
                type: "POST",
                url: "d_city.php",
                data:'city_id='+val,
                success: function(data){
                    $("#location").html(data);
                }
            });
        
        }
   </script>
</body>

</html>
