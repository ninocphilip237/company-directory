<?php
include 'admin/config.php';

if(isset($_POST['stateId'])){
    $stId = $_POST['stateId'];
    $serId = $_POST['service'];
    $sql = "SELECT * FROM cities WHERE state_slug = '$stId' and  cities.status='1' ";
 
     $query2 = $conn->prepare($sql);
     $query2->execute();
     $results3 = $query2->fetchAll();
     //return $results;
?>   
 

<div class="card-body" id="fetchCity">
        <ul>
            <?php
            foreach ($results3 as $result) {
                ?>
                <li>
                <input type="checkbox" value="<?php echo $result['city_slug'] ?>" id="ck21<?php echo $result['city_slug'] ?>">
                <label for="ck21"><a onclick="statct('<?php echo $result['state_slug'] ?>','<?php echo $result['city_slug'] ?>','<?php echo $serId ?>')"><?php echo $result['city_name'] ?></label>
            </li>
            <?php
                }
                ?>

        </ul>
    </div>


<?php


}
else{
    echo $q= "Select State";
    return $q;
}

?>