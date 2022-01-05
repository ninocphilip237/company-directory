<?php
include 'config.php';
if (isset($_SESSION['userlogin'])) {
    if (($_SESSION['usertype'] != 'admin') && ($_SESSION['usertype'] != 'd_entry')) {
        echo "<script type=text/javascript>";
        echo "alert('You are not authorized to access this page !');";
        echo "document.location.href='index.php'";
        echo "</script>";
        exit();
    }
}

$status_id = $_GET['id'];
$status = $_GET['flag'];

//Check State Already Assigned to any company
if($status==2){
$sql10 ="SELECT * FROM `company_location_map` WHERE state_id=:id";
$query10= $conn -> prepare($sql10);
$query10-> bindParam(':id', $status_id);
$query10-> execute();
if($query10->rowCount() > 0)
{
    echo "<script type=text/javascript>";
    echo "alert('Status Change Failed...State is Already in use...!');";
    echo "document.location.href='states.php'";
    echo"</script>";
    exit;
}

}




$sql = "UPDATE states SET status=:status WHERE id=:id";
$query = $conn->prepare($sql);
$query->bindParam(':id', $status_id);
$query->bindParam(':status', $status);
$query->execute();

$sqlc = "UPDATE cities SET status=:status WHERE state_id=:id";
$queryc = $conn->prepare($sqlc);
$queryc->bindParam(':id', $status_id);
$queryc->bindParam(':status', $status);
$queryc->execute();

$sqll = "UPDATE locations SET status=:status WHERE state_id=:id";
$queryl = $conn->prepare($sqll);
$queryl->bindParam(':id', $status_id);
$queryl->bindParam(':status', $status);
$queryl->execute();
header("location:states.php");


$sqll ="UPDATE locations SET status=:status WHERE state_id=:id";
    $queryl= $conn -> prepare($sqll);
    $queryl-> bindParam(':id', $status_id); 
	$queryl-> bindParam(':status', $status);
    $queryl-> execute();

    
    echo "<script type=text/javascript>";
    echo "alert('Status Changed Successfully...!');";
    echo "document.location.href='states.php'";
    echo"</script>";



?>
