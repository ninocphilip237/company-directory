<?php
session_start();
//Database Configuration File
include 'config.php';
// error_reporting(0);

if (isset($_SESSION['userlogin'])) {
    if (($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')) {
        echo "<script type=text/javascript>";
        echo "alert('You are not authorized to access this page !');";
        echo "document.company.href='index.php'";
        echo "</script>";
        exit();
    }
} else {
    echo "<script type=text/javascript>";
    echo "alert('Please Login to access this page !');";
    echo "document.location.href='index.php'";
    echo "</script>";
    exit();
}
$user_id = $_SESSION['uid'];
$user_type = $_SESSION['usertype'];
if ($user_type == 'admin') {
    $sql = "SELECT * FROM states ORDER BY status";
    $query = $conn->prepare($sql);

    $query->execute();
    $results = $query->fetchAll();
} else {
    $sql = "SELECT states.* FROM states INNER JOIN users ON  states.added_user = users.id WHERE
    users.id=$user_id ";
    $query = $conn->prepare($sql);

    $query->execute();
    $results = $query->fetchAll();
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
    <title>Hire My Developer | States</title>
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
    <?php include 'header.php';?>
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
                    <h4 class="text-themecolor">States</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">States</li>
                        </ol>
                        <a onclick='myFunction();' href="manage_states.php">
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
                                <table id="demo-foo-addrow2" class="table m-t-30 table-hover no-wrap contact-list"
                                    data-page-size="5">
                                    <thead>
                                        <tr>
                                            <th>ID #</th>
                                            <th>Image</th>
                                            <th>State Name</th>
                                            <th>Meta Description</th>
                                            <!--      <th>Meta Description</th> -->
                                            <!-- <th>Meta Keywords</th> -->
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
                                                    <input id="demo-input-search2" type="text" placeholder="Search"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tbody>
                                        <?php
$i = 1;
foreach ($results as $result) {
    ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>

                                            <td>
                                                <?php
if ($result['image']) {
        ?>
                                                <img src="./uploads/states/<?php echo $result['image']; ?>"
                                                    alt="No Image" />
                                                <?php
}
    ?>
                                            </td>

                                            <td><?php echo $result['state_name'] ?></td>

                                            <td><?php echo $result['meta_description'] ?></td>
                                            <!--
												<td>
												    <i class="font-weight-bold">Title : </i><?php //echo $result['meta_title']; ?> </br>
												    <i class="font-weight-bold">Description : </i><?php //echo $result['meta_description']; ?></br>
													<i class="font-weight-bold">Keywords : </i><?php //echo $result['meta_keywords']?>
												</td>
											-->
                                            <td>
                                            <?php
if ($result['added_user'] == 1) {
        if ($result['status'] == 1) {?>
                                                            <span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span>
                                                         <?php } else if ($result['status'] == 2) {?>
                                                             <span class="label label-table label-danger">Disabled</span>
                                                         <?php } else {?>
                                                             <span class="label label-table label-warning">Not Approved</span>
                                                           <?php }
    } else {
        if ($result['status'] == 1) {?>
                                                            <span class="label label-table label-success"><i class="fa fa-check"> </i> Approved</span>
                                                         <?php } else if ($result['status'] == 2) {?>
                                                             <span class="label label-table label-danger">Rejected</span>
                                                         <?php } else {?>
                                                             <span class="label label-table label-warning">Not Approved</span>
                                                           <?php }
    }
    ?>
                                            </td>

                                            <td>

                                            <?php
if ($user_type == 'admin') {
        if ($result['added_user'] == 1) {
            if ($result['status'] == 0) {?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeStateStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php } else if ($result['status'] == 1) {?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeStateStatus1('<?php echo $result['id'] ?>',2);" >Disable</a>
                                                            <?php } else {?>
                                                                 <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeStateStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                           <?php }
        } else {
            if ($result['status'] == 0) {?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeStateStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                            <?php } else if ($result['status'] == 1) {?>
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-danger" onclick="changeStateStatus1('<?php echo $result['id'] ?>',2);" >Reject</a>
                                                            <?php } else {?>
                                                                 <a href="javascript:void(0)" class="btn btn-xs btn-rounded btn-outline-success" onclick="changeStateStatus('<?php echo $result['id'] ?>',1);" >Approve</a>
                                                           <?php }
        }
    }

    ?>

                                                <?php
if ($user_type != 'admin') {
        if ($result['status'] == 0) {?>
                                                   <a href="manage_states.php?id=<?php echo $result['id'] ?>">
													<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_states.php?id=<?php echo $result['id'] ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    </a>

                                                    <button type="button" onclick="deleteState('<?php echo $result['id'] ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                        <?php }
    } else {?>
                                                        <a href="manage_states.php?id=<?php echo $result['id'] ?>">
													<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Edit"><a href="manage_states.php?id=<?php echo $result['id'] ?> "><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    </a>

                                                    <button type="button" onclick="deleteState('<?php echo $result['id'] ?>');" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                                   <?php }
    ?>

                                            </td>
                                        </tr>
                                        <?php
}
?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <!-- <a href="manage_location.php" class="btn btn-info btn-rounded">Add New Location</button> -->
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
    <?php include 'footer.php';?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->


    <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!-- Footable -->
    <script src="../assets/node_modules/footable/js/footable.all.min.js"></script>
    <!--FooTable init-->
    <script src="dist/js/pages/footable-init.js"></script>
    <script>
    function deleteState(id) {
        var r = confirm("Do you want to delete state ? all the datas related to state will also deleted !");
        if (r == true) {
            document.location.href = 'delete_states.php?dlt_id=' + id;
        }

    }

    function changeStateStatus(id, flag) {
        var r = confirm("Do you want to activate this state !");
        if (r == true) {
            document.location.href = 'status_state.php?id=' + id + '&flag=' + flag;
        }

    }

    function changeStateStatus1(id, flag) {
        var r = confirm("Do you want to disable this state !");
        if (r == true) {
            document.location.href = 'status_state.php?id=' + id + '&flag=' + flag;
        }

    }

    </script>
</body>

</html>