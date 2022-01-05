<?php
    include('config.php');
  //print_r($_REQUEST);exit;
	$city_id=$_REQUEST['city_id'];
	if(!empty($_REQUEST['city_id'])) {
        $sql ="SELECT * FROM locations where city_id=:cid and status ='1'";
        $query= $conn -> prepare($sql);
        $query-> bindParam(':cid', $city_id);
        $query-> execute();
        $results=$query->fetchAll();
?>
    
   <option value="">Select Location</option>
   <?php
	foreach($results as $location) {
?> 
	<option value="<?php echo $location["id"]; ?>"><?php echo $location["location_name"]; ?></option>
<?php
    }
  }
?>