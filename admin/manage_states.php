<?php
session_start();
//Database Configuration File
include 'config.php';

// print_r($_FILES);
// error_reporting(0);

$user_id = $_SESSION['uid'];
$id = $l_name = $l_description = $m_title = $m_description = $m_keywords = $l_image = $state_slug = $state_id = $city_id = $image = $states = $cities = "";

if ($user_id == 1) {
    $status = 1;
} else {
    $status = 0;
}
$sql1 = "SELECT * FROM states";
$query1 = $conn->prepare($sql1);
$query1->execute();
$states = $query1->fetchAll();

$sql2 = "SELECT * FROM cities";
$query2 = $conn->prepare($sql2);
$query2->execute();
$cities = $query2->fetchAll();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
// Fetch data from database  the basis of username/email and password
    $sql = "SELECT * FROM states WHERE id=:id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $results = $query->fetchAll();
    if ($query->rowCount() > 0) {
        foreach ($results as $data) {
            $l_name = $data['state_name'];
            $m_title = $data['meta_title'];
            $m_description = $data['meta_description'];
            $m_keywords = $data['meta_keywords'];
            $l_image = $data['image'];
            $state_slug = $data['state_slug'];

        }
    }
}
if (isset($_POST)) {
    if (isset($_POST['add'])) {
        $state_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['state_name'])));
        $sql10 = "SELECT * FROM states WHERE state_slug=:state_slug";
        $query10 = $conn->prepare($sql10);
        $query10->bindParam(':state_slug', $state_slug);
        $query10->execute();
        if ($query10->rowCount() > 0) {
            echo "<script type=text/javascript>";
            echo "alert('state slug or State Name Already in use...!');";
            if ($id != '') {
                echo "document.location.href='manage_states.php?id=" . $id . "'";
            } else {
                echo "document.location.href='manage_states.php'";
            }
            echo "</script>";
            exit();
        }
    } else {
        if (isset($_POST['update'])) {
            $state_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_REQUEST['state_slug'])));
            $sql10 = "SELECT * FROM states WHERE state_slug=:state_slug and id!=:id";
            $query10 = $conn->prepare($sql10);
            $query10->bindParam(':state_slug', $state_slug);
            $query10->bindParam(':id', $id);
            $query10->execute();
            if ($query10->rowCount() > 0) {
                echo "<script type=text/javascript>";
                echo "alert('state slug or State Name Already in use...!');";
                if ($id != '') {
                    echo "document.location.href='manage_states.php?id=" . $id . "'";
                } else {
                    echo "document.location.href='manage_states.php'";
                }
                echo "</script>";
                exit();
            }
        }
    }
    if (isset($_POST)) {
        if (isset($_FILES['image']['tmp_name'])) {
            if ($_FILES['image']['tmp_name'] != null) {
                $image = $_FILES["image"]["name"];
                // echo '-----------------------------------'.$image;
                $target_dir = "uploads/states/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if ($image != "") {
                    $filename = "uploads/states/" . $image;
                    if (file_exists($filename)) {
                        unlink($filename);
                    }
                }

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    // echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "<script type=text/javascript>";
                    echo "alert('File is not Image or No Image choosen...!');";
                    echo "document.location.href='manage_states.php'";
                    echo "</script>";
                    exit();
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "<script type=text/javascript>";
                    echo "alert('Uploaded Image File Name Already Exists...!');";
                    echo "document.location.href='manage_states.php'";
                    echo "</script>";
                    exit();
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["image"]["size"] > 500000) {
                    echo "<script type=text/javascript>";
                    echo "alert('File is too large...!');";
                    echo "document.location.href='manage_states.php'";
                    echo "</script>";
                    exit();
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "<script type=text/javascript>";
                    echo "alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed...!');";
                    echo "document.location.href='manage_states.php'";
                    echo "</script>";
                    exit();
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<script type=text/javascript>";
                    echo "alert('Sorry, your file was not uploaded...!');";
                    echo "document.location.href='manage_states.php'";
                    echo "</script>";
                    exit();
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                    } else {
                        echo "<script type=text/javascript>";
                        echo "alert('Sorry, there was an error uploading your file...!');";
                        echo "document.location.href='manage_states.php'";
                        echo "</script>";
                        exit();
                    }
                }
            }
        }

        if (isset($_POST['add'])) {
            $data = [

                'state_name' => $_REQUEST['state_name'],
                'meta_title' => $_REQUEST['meta_title'],
                'meta_description' => $_REQUEST['meta_description'],
                'meta_keywords' => $_REQUEST['meta_keywords'],
                'image' => $image,
                'status' => $status,
                'state_slug' => $state_slug,
                'added_user' => $_SESSION['uid'],
            ];
            $sql2 = "INSERT INTO states(`state_name` ,`meta_title` , `meta_description` , `meta_keywords` ,`image`,`status`, `added_user` ,`state_slug`) VALUES (:state_name , :meta_title , :meta_description,:meta_keywords ,:image ,:status , :added_user ,:state_slug)";
            $query2 = $conn->prepare($sql2);
            if ($query2->execute($data)) {
                echo "<script type=text/javascript>";
                echo "alert('State Added Successfully...!');";
                echo "document.location.href='states.php'";
                echo "</script>";
            } else {
                echo "<script type=text/javascript>";
                echo "alert('Error...!');";
                echo "document.location.href='manage_states.php'";
                echo "</script>";
            }
        }
        if (isset($_POST['update'])) {
            if ($image != '') {
                $data = [

                    'state_name' => $_REQUEST['state_name'],
                    'meta_title' => $_REQUEST['meta_title'],
                    'meta_description' => $_REQUEST['meta_description'],
                    'meta_keywords' => $_REQUEST['meta_keywords'],
                    'image' => $image,
                    'state_slug' => $state_slug,
                    'id' => $_REQUEST['hidden'],
                ];
                $sql2 = "UPDATE `states` SET  `state_name`=:state_name,  `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `image`=:image , `state_slug`=:state_slug WHERE id=:id";
            } else {
                $data = [
                    'state_name' => $_REQUEST['state_name'],
                    'meta_title' => $_REQUEST['meta_title'],
                    'meta_description' => $_REQUEST['meta_description'],
                    'meta_keywords' => $_REQUEST['meta_keywords'],
                    'state_slug' => $state_slug,
                    'id' => $_REQUEST['hidden'],
                ];
                $sql2 = "UPDATE `states` SET `state_name`=:state_name,  `meta_title`=:meta_title, `meta_description`=:meta_description, `meta_keywords`=:meta_keywords, `state_slug`=:state_slug WHERE id=:id";
            }

            $query2 = $conn->prepare($sql2);

            if ($query2->execute($data)) {
                echo "<script type=text/javascript>";
                echo "alert('State Updated Successfully...!');";
                echo "document.location.href='states.php'";
                echo "</script>";
            } else {
                echo "<script type=text/javascript>";
                echo "alert('Error...!');";
                echo "document.location.href='manage_states.php'";
                echo "</script>";
            }
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
    <title>Hire My Developer | Manage State</title>
    <!-- Page CSS -->
    <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="dist/css/pages/footable-page.css" rel="stylesheet">
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
                    <h4 class="text-themecolor">States</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="states.php">States</a></li>
                            <li class="breadcrumb-item active">Manage States</li>
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

                            <form class="m-t-40" method="post" id="form" novalidate enctype="multipart/form-data">
                                <div class="form-group">
                                    <h5>State Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="state_name" class="form-control" required
                                            data-validation-required-message="This field is required..."
                                            value="<?php echo $l_name; ?>">
                                    </div>

                                </div>



                                <div class="form-group">
                                    <h5>Meta Title <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $m_title; ?>" name="meta_title"
                                            class="form-control" required
                                            data-validation-required-message="This field is required"> </div>

                                </div>

                                <div class="form-group">
                                    <h5>Meta Description <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <textarea name="meta_description" id="meta_description" class="form-control"
                                            required placeholder="Enter text"><?php echo $m_description; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Meta Keywords <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" data-role="tagsinput" id="meta_keywords" value="<?php echo $m_keywords; ?>"  
                                        name="meta_keywords"
                                             class="form-control" required
                                            data-validation-required-message="This field is required"> </div>


                                </div>
                                <?php if ($id != '') {?>
                                <div class="form-group" id="state_slug11">
                                    <h5>State Slug<span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="state_slug" value="<?php echo $state_slug; ?>"
                                            class="form-control" required
                                            data-validation-required-message="This field is required"> </div>

                                </div>
                                <?php }?>
                                



                                <div class="form-group">
                                    <h5>State Image <span class="text-danger">*</span></h5>
                                    
                                    <div class="controls">
                                    <?php
                            if ($id != '') {?>
                                        

                                        <img src="./uploads/states/<?php echo $l_image ?>" height="100"></img>

                                        <h5 class="mt-3">Change Image </h5>
                                        <?php }
                                      ?>

                                        <input type="file" name="image" id="myFile" accept='image/*' 
                                        
                                            class="form-control" <?php if ($id != '') {?> style="box-shadow: none;border: none;line-height: initial;"  <?php } else {?> required <?php }?> >
                                    </div>
                                </div>

                                <div class="text-xs-right">
                                    <?php if ($id != '') {?>
                                    <input type="hidden" name="hidden" value="<?php echo $id ?>">
                                    <button type="submit" name="update" class="btn btn-info">Update</button>
                                    <?php } else {?>
                                    <button type="submit" name="add" class="btn btn-info">Add</button>
                                    <?php }?>
                                    <a href="states.php" class="btn btn-inverse">Cancel</a>
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
    <?php include 'footer.php';?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->

    <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script>

var keyword = $("#meta_keywords");

$('.btn').click(function () {



if(keyword.val().length===0){
$('.bootstrap-tagsinput').addClass("errorInput");
}
else{
$('.bootstrap-tagsinput').removeClass("errorInput");
}


});

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