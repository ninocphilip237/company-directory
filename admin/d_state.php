<?php
    include('config.php');
  //print_r($_REQUEST);exit;
	$state_id=$_REQUEST['state_id'];
	if(!empty($_REQUEST['state_id'])) {
        $sql ="SELECT * FROM cities where state_id=:sid and status ='1'";
        $query= $conn -> prepare($sql);
        $query-> bindParam(':sid', $state_id);
        $query-> execute();
        $results=$query->fetchAll();
?>
    
   <option value="">Select City</option>
   <?php
	foreach($results as $city) {
?> 
	<option value="<?php echo $city["id"]; ?>"><?php echo $city["city_name"]; ?></option>
<?php
    }
  }
?>