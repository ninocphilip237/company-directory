<?php
session_start();
//Database Configuration File
include('config.php');

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
$user_id=$_SESSION['uid'];
$user_type = $_SESSION['usertype'];
if($user_type == 'admin'){
    $sql ="SELECT * FROM services ORDER BY status";
    $query= $conn -> prepare($sql);
    
    $query-> execute();
    $results=$query->fetchAll();
} 
else{
    $sql ="SELECT services.* FROM services INNER JOIN users ON  services.added_user = users.id WHERE
    users.id=$user_id "; 
    $query= $conn -> prepare($sql);
    
    $query-> execute();
    $results=$query->fetchAll();
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
    <!-- Footable CSS -->
    <link href="../assets/node_modules/footable/css/footable.core.css" rel="stylesheet">
    <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <!-- Page CSS -->
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
                        <h4 class="text-themecolor">Services</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Manage Services</li>
                            </ol>
                            <a href="manage_services.php">
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Create New</button></a>
                            
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
                                
                                <div class="table-responsive">
                                    <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Image</th>
                                                <th>Service name</th>
                                                <th>Service description</th>
                                                <!-- <th>Meta title</th>
                                                <th>Meta description</th>
                                                <th>Meta keywords</th> -->
                                                <th>Status</th>
                                                <th>Action</th>
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
                                          <?php
                                                $i=1;
                                                foreach ($results as $result) {
                                                     $id = $result['id']; 
                                                     $sname = $result['service_name']; 
                                                     $sdescription = $result['service_description'];
                                                     $meta_title = $result['meta_title'];
                                                     $meta_description = $result['meta_description'];
                                                     $meta_keywords = $result['meta_keywords'];
                                                     $status = $result['status'];
                                                     $image_service   = $result['image'];
                                                    ?>


                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <?php 
                                                if($image_service!=""){?>
                                                    <td><img src="uploads/services/<?php echo $image_service?>"></img></td>
                                                <?php }
                                                else{?>
                                                    <td>Nil</td>
                                               <?php }
                                                ?>
                                                
                                                <td><?php echo $sname;?></td>
                                                <td><?php echo $sdescription; ?></td>
                                                <!-- <td></?php echo $meta_title ; ?></td> -->
                                                <!-- <td></?php echo $meta_description ;?> </td>
                                                <td></?php echo $meta_keywords ;?></td> -->
                                                <?php
                                                if($result['added_user']==1) {
                                                    if ($status==1){?>
                                                        <td><span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span></td>
                                                     <?php }
                                                      else if($status==2){?>
                                                        <td><span class="label label-table label-danger">Disabled</span></td>
                                                     <?php }
                                                     else{?>
                                                      <td>  <span class="label label-table label-warning">Not Approved</span></td>
                                                    <?php }

                                                }
                                                else {
                                                    if ($status==1){?>
                                                        <td><span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span></td>
                                                     <?php }
                                                      else if($status==2){?>
                                                        <td><span class="label label-table label-danger">Rejected</span></td>
                                                     <?php }
                                                     else{?>
                                                       <td> <span class="label label-table label-warning">Not Approved</span></td>
                                                    <?php }
                                                }
                                                  
                                                ?>
                                                                                          
                                                <td>
                                                 <?php
                                                    if($user_type == 'admin') {

                                                        if($result['added_user']==1){
                                                            if($status==0){ ?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeServiceStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php } else if($result['status']==1) { ?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeServiceStatus('<?php echo $result['id'] ?>',2);" >Disable</a>
                                                            <?php }
                                                            else{?>
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeServiceStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                           <?php }
                                                        }
                                                        else{
                                                            if($status==0){ ?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeServiceStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php } else if($result['status']==1) { ?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeServiceStatus('<?php echo $result['id'] ?>',2);" >Reject</a>
                                                            <?php }
                                                            else{?>
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeServiceStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                           <?php }
                                                        }
                                                        


                                                    }
                                                 ?>
                                                <?php
                                                    if($user_type != 'admin') {
                                                        if($status==0) {?>
                                                    													
													<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_services.php?id=<?php echo $id ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    </a>
													
                                                    <button type="button" onclick="deleteLocation('<?php echo $id ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                        <?php }
                                                    }
                                                    else{?>
													<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_services.php?id=<?php echo $id ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    </a>
													
                                                    <button type="button" onclick="deleteLocation('<?php echo $id ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                   <?php }
                                                ?>
                                                    
                                                    
                                                </td>

                                            </tr>

                                                <?php }

                                          ?>


                                            

                                        
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                   
                                                </td>
                                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <from class="form-horizontal form-material">
                                                                    <div class="form-group">
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Type name"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Email"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Phone"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Designation"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Age"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Date of joining"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <input type="text" class="form-control" placeholder="Salary"> </div>
                                                                        <div class="col-md-12 m-b-20">
                                                                            <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                                <input type="file" class="upload"> </div>
                                                                        </div>
                                                                    </div>
                                                                </from>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
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
       
    <!-- </div> -->
   
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php include('footer.php'); ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->





        
    <!-- <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>-->
    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="../assets/node_modules/popper/popper.min.js"></script> -->
    <!-- <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script> --> 
   
    <!--Wave Effects -->
    <!-- <script src="dist/js/waves.js"></script> -->
    <!--Menu sidebar -->
    <!-- <script src="dist/js/sidebarmenu.js"></script> -->
    <!--stickey kit -->
    <!-- <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script> -->
    <!-- <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script> -->
    <!--Custom JavaScript -->
    <!-- <script src="dist/js/custom.min.js"></script> -->

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!-- Footable -->
    <script src="../assets/node_modules/footable/js/footable.all.min.js"></script>
    <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="dist/js/pages/footable-init.js"></script>

    <script>
      function deleteLocation(id) {
        var r = confirm("Do you want to delete the service !");
        if (r == true) {   
          alert('Service deleted Successfully !');
          document.location.href='delete_services.php?dlt_id='+id;
        } 
     
      }
	  function changeServiceStatus(id,flag) {
        var r = confirm("Approve/Reject this Service !");
        if (r == true) {   
          alert('Service Status Changed Successfully !');
          document.location.href='status_services.php?id='+id+'&flag='+flag;
        } 
     
      }
   </script>
</body>

</html>