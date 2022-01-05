<?php
include 'admin/config.php';
$s=$page = 1;
$back=$next=$start=0;
$meta_title = $meta_description = $meta_keywords = "";
$location = $service_slug = $statenm =""; $citynm= ""; $sty_slug ="";$cty_slug ="";
$sqls ="SELECT * FROM companies WHERE company_list_status=:s AND status=1";
$querys= $conn -> prepare($sqls);
$querys-> bindParam(':s', $s); 
$querys-> execute();
if($querys->rowCount() > 0)
{
    $vofox_data=$querys->fetchAll();
}

$sr=''; 
if(isset($_REQUEST['service_slug'])) 
$sr=$_REQUEST['service_slug'];


// For Paging 

if(isset($_REQUEST['page'])){
    $page=$_REQUEST['page'];
    $page = str_replace("page-","",$page);
    
}
$limit = 4;
if($page > 1){
    $eu = ($page * $limit)-$limit;
}
else{
    $eu=0;
}
$back = $page - 1;
$next = $page + 1;

if(isset($_REQUEST['location_slug']))
$location = $_REQUEST['location_slug'];


// error_reporting(0);

// Fetch companies from database

$sql1 = "SELECT a.id,a.company_name,a.slug,a.website_url,a.logo FROM ( SELECT companies.id, companies.company_name,companies.slug,companies.website_url,companies.logo FROM companies WHERE companies.profile_progress >= 67 AND  companies.company_list_status=0 AND companies.status='1') a ORDER BY RAND() LIMIT 9";
$query1 = $conn->prepare($sql1);
$query1->execute();
$results1 = $query1->fetchAll();


//Service only

if(isset($_GET['service_slug']))
{
    $sty_slug="";
    $cty_slug ="";

    $serset='Y';

    $service_slug =$_GET['service_slug'];
    $sqlst = "SELECT services.id,services.meta_title,services.meta_description,services.meta_keywords FROM services WHERE  service_slug ='".$service_slug."' and  status='1' ";
    $sqlstq = $conn->prepare($sqlst);
    $sqlstq->execute();
    $sqlstr = $sqlstq->fetchAll();
    foreach ($sqlstr as $result) {

        $service = $result['id'];
        $meta_title = $result['meta_title'];
        $meta_description = $result['meta_description'];
        $meta_keywords = $result['meta_keywords'];

    }
}
else{
    $service_slug ="";
    $serset='N';
    
}

if(isset($_GET['location_slug'])){

    $sq1 = "SELECT * FROM states WHERE state_slug = '".$_GET['location_slug']."' and states.status='1'";
    $sqs = $conn->prepare($sq1);
    $sqs->execute();
    

    if($sqs->rowCount() > 0)
    {
        $sqls = $sqs->fetchAll();
        foreach ($sqls as $results) {

            $sty = $results['id'];
            $sty_slug = $results['state_slug'];
            $sql3 = "SELECT * FROM cities WHERE state_id = '$sty' and cities.status='1' " ;

            
        }
    }
    else{
        $sq1 = "SELECT * FROM cities WHERE city_slug = '".$_GET['location_slug']."' and cities.status='1'";
        $sqs = $conn->prepare($sq1);
        $sqs->execute();
        $sqls = $sqs->fetchAll();
        foreach ($sqls as $results) {

            $cty = $results['id'];
            $cty_slug = $results['city_slug'];
           
            
        }
    }

}


//State & service

if(($sty_slug!='')&&($service_slug!=''))
{
    $statset ='Y';
   $cty_slug ="";
   $sql2 = "SELECT * FROM states WHERE 1 and  states.status='1'";
    $sql3 = "SELECT * FROM cities WHERE state_id = '".$sty."' and cities.status='1' " ;

    $sqlst = "SELECT state_name,states.meta_title as state_meta_title,states.meta_description as state_meta_description,states.meta_keywords as state_meta_keywords,services.meta_title,services.meta_description,services.meta_keywords FROM states INNER JOIN services  ON services.id ='".$service."' WHERE states.id ='".$sty."' and states.status='1'";
    $sqlstq = $conn->prepare($sqlst);
    $sqlstq->execute();
    $sqlstr = $sqlstq->fetchAll();
  // echo "<pre>"; print_r($sqlstr);
    foreach ($sqlstr as $result) {

        $statenm=$result['state_name'];
        $citynm='';

        $meta_title = $result['state_meta_title'].",".$result['meta_title'];
        $meta_description = $result['state_meta_description'].",".$result['meta_description'];
        $meta_keywords = $result['state_meta_keywords'].",".$result['meta_keywords'];
       

    }
}

 //City & service 

 else if(($cty_slug!='')&&($service_slug!=''))
{
    $sty_slug ="";
    $cityset='Y';
   
   $sql2 = "SELECT * FROM states WHERE 1 and  states.status='1'";
   $sql3 = "SELECT * FROM cities WHERE cities.status='1' " ;

     $sqlst = "SELECT state_name,city_name,states.meta_title as state_meta_title,states.meta_description as state_meta_description,states.meta_keywords as state_meta_keywords,cities.meta_title as city_meta_title,cities.meta_description as city_meta_description,cities.meta_keywords as city_meta_keywords,services.meta_title,services.meta_description,services.meta_keywords FROM cities  INNER JOIN states  ON states.id = cities.state_id INNER JOIN services  ON services.id ='".$service."' WHERE cities.id = '".$cty."' and cities.status='1'";

    
    $sqlstq = $conn->prepare($sqlst);
    $sqlstq->execute();
    $sqlstr = $sqlstq->fetchAll();
    foreach ($sqlstr as $result) {
        
        $citynm=", ".$result['city_name'];
        $statenm = $result['state_name'];

        $meta_title = $result['state_meta_title'].",".$result['city_meta_title'].",".$result['meta_title'];
        $meta_description = $result['state_meta_description'].",".$result['city_meta_description'].",".$result['meta_description'];
        $meta_keywords = $result['state_meta_keywords'].",".$result['city_meta_keywords'].",".$result['meta_keywords'];

        if($result==''){
            $statenm='India';
            $citynm="";

        }

    }
}

 //------------------------------------------------------------Normal cases-------------------------------------------->

//Only State  Without service

else if(($sty_slug!='')&&($service_slug==''))
{
    $cty_slug = "";
    $stateset='Y';
    //$state_slug=$_GET['state_slug'];
    
    $sql1 = "SELECT states.state_name,states.id,states.meta_title as state_meta_title,states.meta_description as state_meta_description,states.meta_keywords as state_meta_keywords FROM states WHERE state_slug = '".$sty_slug."' and states.status='1' " ;
    $sql = $conn->prepare($sql1);
    $sql->execute();
    $sqls = $sql->fetchAll();
    foreach ($sqls as $result) {

        $state_id = $result['id'];
        $meta_title = $result['state_meta_title'];
        $meta_description = $result['state_meta_description'];
        $meta_keywords = $result['state_meta_keywords'];

   $sql2 = "SELECT * FROM states WHERE 1 and  states.status='1'";
   $sql3 = "SELECT * FROM cities WHERE state_id = '$sty' and cities.status='1' " ;


        $citynm=" ";
        $statenm = $result['state_name'];

        
    }
}

 //Only City Without service

 else if(($cty_slug!='')&&($service_slug==''))
 {
    $sty_slug ="";
    $cityset='Y';
   
    $sqlst = "SELECT state_name,city_name,states.meta_title as state_meta_title,states.meta_description as state_meta_description,states.meta_keywords as state_meta_keywords,cities.meta_title as city_meta_title,cities.meta_description as city_meta_description,cities.meta_keywords as city_meta_keywords FROM cities  INNER JOIN states  ON states.id = cities.state_id  WHERE cities.id = '".$cty."' and cities.status='1'";



   $sql2 = "SELECT * FROM states WHERE 1 and  states.status='1'";
   $sql3 = "SELECT * FROM cities WHERE cities.status='1' " ;

    $sqlstq = $conn->prepare($sqlst);
    $sqlstq->execute();
    $sqlstr = $sqlstq->fetchAll();
   //echo "<pre>"; print_r( $sqlstr);
    foreach ($sqlstr as $result) {
        
        $citynm=", ".$result['city_name'];
        $statenm = $result['state_name'];

        $meta_title = $result['state_meta_title'].",".$result['city_meta_title'];
        $meta_description = $result['state_meta_description'].",".$result['city_meta_description'];
        $meta_keywords = $result['state_meta_keywords'].",".$result['city_meta_keywords'];


    }
}


else{

    $statset='N';
    $sql2 = "SELECT * FROM states WHERE 1 and states.status='1'";
    $sql3 = "SELECT * FROM cities WHERE 1 and cities.status='1' " ;

    $statenm='India';
    $citynm='';
}

// Fetch states from database

//$sql2 = "SELECT * FROM states WHERE 1";
$query2 = $conn->prepare($sql2);
$query2->execute();
$results2 = $query2->fetchAll();

 // Fetch cities from database

$queryt = $conn->prepare($sql3);
$queryt->execute();
$results3 = $queryt->fetchAll();


$sql4 = "SELECT * FROM services WHERE 1 and  services.status='1'" ;
$query4 = $conn->prepare($sql4);
$query4->execute();
$results4 = $query4->fetchAll();

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <title>Hire My Developer</title> -->
    <title>Hire My Developer | IT Services In India, <?php echo $meta_title;  ?></title>
    <meta value="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo  $meta_description; ?> >">
    <meta name="keywords"content="<?php echo $meta_keywords; ?> >">  
     <base href="http://192.168.10.87/company-directory/" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
  </head>
  <body>
<!-- ============================================================== -->
<!-- Header -->
<!-- ============================================================== -->  
<?php include('header.php'); ?>
<!-- ============================================================== -->
<!-- End Header -->
<!-- ============================================================== -->
<section class="home-five">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-12">
      <?php  //$statenm =""; $citynm= "";  ?>
        <h2 class="head-main text-left mb-5"><span>IT Companies in <span style=" font-size:28px;">
              <?php echo $statenm.$citynm;  ?></span></span></h2>
      <div class="row" id="left">
      <?php
                        // $service=$_GET['service'];
                        //  echo $service;
                       // $state=$_GET['state'];
                        if(isset($_GET['service_slug']))
                        {

                            $serset='Y';
                           // $service=$_GET['service'];
                        }
                        else{
                            $serset='N';
                        }

                        if(isset($sty))
                        {
                            $statset='Y';
                         //   $state=$_GET['state'];
                        }
                        else{
                            $statset='N';
                        }
                        if(isset($cty))
                        {
                            $cityset='Y';
                         //   $city=$_GET['city'];
                        }
                        else{
                            $cityset='N';
                        }


                        // echo $state;
// error_reporting(0);
// $page_name = "companies.php"; //  If you use this code with a different page ( or file ) name then change this
// $start = $_GET['start'];

// $eu = ($start - 0);
// $limit = 9; // No of records to be shown per page.
// $this1 = $eu + $limit;
// $back = $eu - $limit;
// $next = $eu + $limit;

$nume = $conn->query("select count(id) from companies where companies.status ='1' ")->fetchColumn();
$query='';
$query.= "SELECT distinct 
companies.id as com_id,
companies.slug,
companies.company_name,
companies.logo
FROM
companies
INNER JOIN
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
company_location_map.company_id = company_service_map.company_id
 
WHERE companies.status ='1' and  1   ";

if(($serset=='Y')&&($statset=='N')&&($cityset=='N'))
{
    $query.=" and services.id = '$service'";
}

else if(($serset=='N')&&($statset=='N')&&($cityset=='Y'))
{
    $query.=" and company_location_map.city_id = '$cty'";
}
else if(($serset=='N')&&($statset=='Y')&&($cityset=='Y'))
{
    $query.=" and company_location_map.state_id = '$sty' and company_location_map.city_id = '$cty' ";
}
else if(($serset=='N')&&($statset=='Y')&&($cityset=='N'))
{
    $query.=" and company_location_map.state_id = '$sty'";
}
else if(($statset=='Y')&&($serset=='Y')&&($cityset=='N'))
{
    $query.=" and company_location_map.state_id = '$sty'  and services.id = '$service'";
}
else if(($cityset=='Y')&&($serset=='Y')&&($statset=='N'))
{  
    $query.=" and company_location_map.city_id = '$cty'  and services.id = '$service'";
}
else if(($statset=='Y')&&($cityset=='Y')&&($serset=='Y'))
{
    $query.=" and company_location_map.state_id = '$sty' and company_location_map.city_id = '$cty'  and services.id = '$service'";
}
else
{ 
    // $query.=" limit $eu, $limit ";
}

//echo $query;

$sql9 = $conn->prepare($query);
$sql9->execute();
// echo $query;
$r=$conn->query($query);

// $nume = $conn->query("select count(id) from services where companies.status ='1' ")->fetchColumn();
$nume = $r->rowCount();


$query.=" limit $eu, $limit ";



$exe = $conn->prepare($query);
$exe->execute();
$results = $exe->fetchAll();

// foreach ($conn->query($query) as $row) {
//     $m = $i % 2; // required for alternate color of rows matching to style class
//     $i = $i + 1; //  increment for alternate color of rows

// }

?>

<?php
foreach ($results as $result) {
    // print_r($result);
    ?>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <a href="IN/company/<?php echo $result['slug']; ?>"> <div class="item"
                style="background-image: url(admin/uploads/companies/<?php echo $result['logo'] ?>);">
                <input type="hidden" name ="stateval" id="stateval"/>
                <input type="hidden" name ="cityval" id="cityval"/>
                <input type="hidden" name ="serv-val" id="serv-val"/>
                <!-- <a onclick="statpg('<?php //echo $result['id']?>')" -->
                <p
               
                    class="pt-0"><?php echo $result['company_name'] ?>
                    <i>
                        <img src="img/right-arrow.svg" alt=""></i></p>

                <div class="bg-color"></div>
            </div></a>
        </div>

        <?php
}
?>
       </div>
      </div>


      <div class="col-lg-4 col-md-4 col-sm-12">
      <h2 class="head-main text-left mb-5"><span>Filter By</span></h2>

                    <div class="filter">
                        <div id="accordion">
                            <div class="card fit-box">
                                <div class="card-hed" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            State
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul>
                                        <?php
                                       foreach ($results2 as $result) {
                                            ?>
                                            <li>

                                                <input type="checkbox" name="one" value="<?php echo $result['state_slug'] ?>" id="ck11<?php echo $result['state_slug'] ?>" checked="checked">
                                                <!--label for="ck11"><a href="page2.php?state=<?php echo $result['id'] ?>"><?php echo $result['state_name'] ?></a></label-->

                                                 <label for="ck11">
                                                   <a onclick="stat('<?php echo $result['state_slug'] ?>','<?php echo $sr; ?>')">
                                                   <?php echo $result['state_name'] ?>
                                                  </a>
                                                 </label>
                                            </li>
                                            <?php
                                          }
                                          ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card fit-box">
                                <div class="card-hed" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            City 
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <ul>
                                        <?php 
                                foreach ($results3 as $result) {
                                    ?> 
                                           <li>
                                                <input type="checkbox" value="<?php echo $result['city_slug'] ?>" id="ck21<?php echo $result['city_slug'] ?>"
                                                >
                                                <label for="ck21">
                                                  <a onclick="statct('<?php echo $result['city_slug'] ?>','<?php echo $sty_slug ?>','<?php echo $sr; ?>')" >
                                                <?php echo $result['city_name'] ?>
                                                </a>
                                                </label>
                                            </li>
                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                                       
                            <div class="card fit-box">
                                <div class="card-hed" id="headingFour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapse4" aria-expanded="false"
                                            aria-controls="collapse4">
                                            Services
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse4" class="collapse" aria-labelledby="headingFour"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <ul>
                                        <?php
                                foreach ($results4 as $result) {
                                    ?>
                                           <li>
                                                <input type="checkbox" value="<?php echo $result['service_slug'] ?>" id="ck31<?php echo $result['service_slug'] ?>">
                                                <label for="ck31">
                                                  <a onclick="selServ('<?php echo $result['service_slug'] ?>','<?php echo $sty_slug ?>','<?php echo $cty_slug ?>')">
                                                  <?php echo $result['service_name'] ?>
                                                  </a>
                                                  </label>
                                            </li>
                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <h2 class="head-main text-left mb-2"><span>Top 10 Software Companies in India</span> </h2>

                    <?php
                    foreach ($vofox_data as $vofox) {
                 ?>
                    <ul class="right-listing">
                        <!-- <li>
                            <a href="IN/company/<?php echo $vofox['slug']; ?>">
                                <span><img src="./admin/uploads/companies/<?php echo $vofox['logo']; ?>"
                                        alt=""></span>

                                <span>
                                    <?php echo $vofox['company_name'] ?>
                                    <i><?php echo $vofox['website_url'] ?></i>
                                </span>
                            </a>
                        </li> -->

                    </ul>
                <?php
                    }
                ?>
                <ul class="right-listing" id="right">
                <li class="right-list-loop">
                            <a href="IN/company/<?php echo $vofox['slug']; ?>">
                                <span><img src="./admin/uploads/companies/<?php echo $vofox['logo']; ?>"
                                        alt=""></span>

                                <span>
                                    <?php echo $vofox['company_name'] ?>
                                    <i><?php echo $vofox['website_url'] ?></i>
                                </span>
                            </a>
                        </li>
                    <?php
foreach ($results1 as $result1) {
    ?>
                    
                        <li>
                            <a href="IN/company/<?php echo $result1['slug']; ?>">
                                <span><img src="./admin/uploads/companies/<?php echo $result1['logo']; ?>"
                                        alt=""></span>

                                <span>
                                    <?php echo $result1['company_name'] ?>
                                    <i><?php echo $result1['website_url'] ?></i>
                                </span>
                            </a>
                        </li>
                        <?php
}
?>

                    </ul>


                </div>
            </div>
        </div>

    </section>

<script>
var url = window.location.href;   
//Document.getElementById('url') = url;


</script>


    <div class="container pagenation">
        <nav class="page navigation">
            <?php

if ($nume > $limit) { // Let us display bottom links if sufficient records are there for paging
   

    if ($back >= 1) {
        if(($location!='')&&($sr!='')){
            print "<a href='service/$sr/IN/$location/page-$back'><font face='Verdana' size='2' class='page-link page-item'>PREV</font></a>";
        }
        else if(($location=='')&&($sr!='')){
            print "<a href='service/$sr/IN/page-$back'><font face='Verdana' size='2' class='page-link page-item'>PREV</font></a>";
        }
        else if(($location!='')&&($sr=='')){ 
            print "<a href='service/IN/$location/page-$back'><font face='Verdana' size='2' class='page-link page-item'>PREV</font></a>";
        }
        else{
            // echo "No Cond";
        }
    }
   
    $j=1;
    $j = ceil($nume/$limit);
    for ($i = 1; $i <= $j; $i++) {
         if($i == $page){
            if(($location!='')&&($sr!='')){
             //  echo "one";
              echo "<a href='service/".$service_slug."/IN/".$location."/page-".$i."'><font face='Verdana' size='4' class='page-link page-item'> ".$i." </font></a> ";
            }
            else if(($location=='')&&($service_slug!='')){
                // echo "two";
                echo " <a href='service/".$service_slug."/IN/page-".$i."'><font face='Verdana' size='4' class='page-link page-item'> ".$i." </font></a> ";
            }
            else if(($location!='')&&($service_slug=='')){ 
                // echo "three";
                echo " <a href='service/IN/".$location."/page-".$i."'><font face='Verdana' size='4' class='page-link page-item'> ".$i." </font></a> ";
            }
            else{
                // echo "No Cond";
            }
         }
         else
         {
            if(($location!='')&&($service_slug!='')){
                // echo "one";
                echo " <a href='service/$service_slug/IN/$location/page-$i'><font face='Verdana' size='2' class='page-link page-item'>$i</font></a> ";
              }
              else if(($location=='')&&($service_slug!='')){
                // echo "two";
                 echo " <a href='service/$service_slug/IN/page-$i'><font face='Verdana' size='2' class='page-link page-item'>$i</font></a> ";
              }
              else if(($location!='')&&($service_slug=='')){ 
                // echo "htree";
                  echo " <a href='service/IN/$location/page-$i'><font face='Verdana' size='2' class='page-link page-item'>$i</font></a> ";
              }
              else{
                // echo "No Cond";
            }
         }

      
    }


    if ($page < ($nume/$limit)) {
        if(($location!='')&&($service_slug!='')){
            print "<a href='service/$service_slug/IN/$location/page-$next'><font face='Verdana' size='2' class='page-link page-item'>NEXT</font></a>";
        }
        else if(($location=='')&&($service_slug!='')){
            print "<a href='service/$service_slug/IN/page-$next'><font face='Verdana' size='2' class='page-link page-item'>NEXT</font></a>";
        }
        else if(($location!='')&&($service_slug=='')){ 
            print "<a href='service/IN/$location/page-$next'><font face='Verdana' size='2' class='page-link page-item'>NEXT</font></a>";

        }
        else{
            // echo "No Cond";
        }

     }
 

} // end of if checking sufficient records are there to display bottom navigational link.
?>
           
        </nav>
    </div>




<!-- ============================================================== -->
<!-- Footer -->
<!-- ============================================================== -->
<?php include('footer.php'); ?>
<!-- ============================================================== -->
<!-- End Footer -->
<!-- ============================================================== -->




    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function stat(st,ct,sr){
        

        var vx="ck11"+st;
        vl=document.getElementById(vx).value;
        sr = '<?php echo $sr;  ?>';
        ct = '<?php echo $cty_slug;?>';
        
        $.ajax({
            type: "POST",
            url: "fetchCity.php",
            data:'stateId='+vl+'&service='+sr,
            success: function(data){
               
                $("#fetchCity").html(data);
                        
            }
            });
            
        
        //alert(vl);
        
         if((ct=='')&&(sr=='')&&(vl!=''))
        {   
            //document.getElementById('cityval').value=ct; 
            window.location.assign("service/IN/"+vl);
        }
        else if((vl!='')&&(sr!=''))
        {
            window.location.assign("service/"+sr+"/IN/"+vl);
            
        }
        else if((vl!='')&&(sr!='')&&(ct==''))
        {   
            window.location.assign("service/"+sr+"/IN/"+vl);
           
        }
        
        else if((vl!='')&&(sr=='')&&(ct!=''))
        {   
            window.location.assign("service/IN/"+vl);
           
        }
        else{
            window.location.assign("service/"+sr+"/IN/"+vl);
        }
    
    }
    function statct(ct,sr){



        var vx="ck21"+ct;


        ct =document.getElementById(vx).value;
        st='<?php echo $sty_slug;?>';
         sr = '<?php echo $sr;  ?>';
        //alert(vl);

        if(ct=='')
        {
            
        // window.location.assign("home.php?state="+st);

        // alert('Select City');

        document.getElementById('cityval').value=ct;       
        }
        else if((st!='')&&(sr=='')&&(ct!=''))
        {   
           // window.location.assign("companies.php?state_slug="+st+"&city_slug="+ct);
           window.location.assign("service/IN/"+ct);
        }
        else if((st=='')&&(sr=='')&&(ct!=''))
        {   
           // document.getElementById('cityval').value=ct; 
            window.location.assign("service/IN/"+ct);
        }
        else if((st=='')&&(sr!='')&&(ct!=''))
        {   
            window.location.assign("service/"+sr+"/IN/"+ct);
           
        }
        else
        {
            window.location.assign("service/"+sr+"/IN/"+ct);

            //window.location.assign("companies.php?city_slug="+ct+"&service_slug="+sr);
        }
        // alert(st);alert(sr);


    }

    function selServ(ct,sr){

    
        var vx="ck31"+ct;


        sr=document.getElementById(vx).value;

         st='<?php echo $sty_slug; ?>';

         ct='<?php echo $cty_slug;?>';


        
    // window.location.assign("index.php?state="+st);

        if((st=='')&&(ct==''))
        {
            
        // window.location.assign("home.php?state="+st);

        // alert('Select state');
        document.getElementById('stateval').value=st; 

        window.location.assign("service/"+sr+"/IN"); 
        
        }
        else if((st!='')&&(ct=='')){

        //alert('Select CIty');
        
        //document.getElementById('cityval').value=ct; 

        window.location.assign("service/"+sr+"/IN/"+st);
        
        }
        else if((st=='')&&(ct!='')){
            
            
            window.location.assign("service/"+sr+"/IN/"+ct);

        }
        else 
        {
            window.location.assign("service/"+sr+"/IN/"+ct);
        }
        // alert(st);alert(sr);


    }

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 100) {
        $("header").addClass("active");
    } else {
        $("header").removeClass("active");
    }
});
$(".enq-fix-box .btn-box").click(function(){
  $(".enq-fix-box").toggleClass("active");
});

    </script>
<input type="hidden" id="url" name="url" value="">

<script type="text/javascript">
	var a = 230;
	var offsetHeight = document.getElementById('left').offsetHeight;
document.getElementById('right').style.height = offsetHeight-a+'px';
</script>

  </body>
</html>