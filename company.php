<?php
session_start();
include 'admin/config.php';
$s = 1;
$no_data = 0 ;
$sqls ="SELECT * FROM companies WHERE company_list_status=:s";
$querys= $conn -> prepare($sqls);
$querys-> bindParam(':s', $s);
$querys-> execute();
if($querys->rowCount() > 0)
{
    $vofox_data=$querys->fetchAll();
}


$sql1 = "SELECT a.id,a.company_name,a.slug,a.website_url,a.logo FROM ( SELECT companies.id, companies.company_name,companies.slug,companies.website_url,companies.logo FROM companies WHERE companies.profile_progress >= 67 AND  companies.company_list_status=0 AND companies.status='1') a ORDER BY RAND() LIMIT 9";
$query1 = $conn->prepare($sql1);
$query1->execute();
$results1 = $query1->fetchAll();

if(!isset($_REQUEST['slug'])){
      echo "<script type=text/javascript>";
      echo "alert('You are not authorized to access this page !');";
      echo "document.location.href='index.php'";
      echo"</script>";
      exit();
}
else
{
    $id = $slug = $c_name = $c_description = $c_address = $c_url = $c_email = $c_contact = $m_title = $m_description = $m_keywords = $state_id = $city_id = $location_id = $serv_id = $logo = $state  = $city = $location =  $hourly_rates = $team_sizes  = $hourly_rate = $team_size = $rph_id = $tz_id = $attachment = $images = "";
    $service_ids = $services = $service_map = $location_map = $review_map = $customer_map = $portfolio_map = $testimonial_map = [];
    if(isset($_GET['slug'])){
        $slug=$_GET['slug'];
     // Fetch data from database  
         $sql ="SELECT * FROM companies WHERE slug=:slug and companies.status='1'";
         $query= $conn -> prepare($sql);
         $query-> bindParam(':slug', $slug);
         $query-> execute();
         $results=$query->fetchAll();
         if($query->rowCount() > 0)
         {
             foreach ($results as $data) {
                 $id = $data['id'];
                 $c_name = $data['company_name'];
                 $c_description = $data['company_description'];
                 $c_url = $data['website_url'];
                 $c_contact = $data['phone'];
                 $c_email = $data['email'];
                 $c_address = $data['address'];
                 $m_title = $data['meta_title'];
                 $m_description = $data['meta_description'];
                 $m_keywords = $data['meta_keywords'];
                 $logo = $data['logo'];
                 $images = $data['images'];
                //  $state_id = $data['state_id'];
                //  $city_id = $data['city_id'];
                //  $location_id = $data['location_id'];
                 $p_progress = $data['profile_progress'];
                 $rph_id = $data['rate_per_hour'];
                 $tz_id = $data['team_size'];
             }
         }
         else
         {
           $no_data = 1;
         }
         $sql1 ="SELECT * FROM company_customers_map WHERE company_id=:id";
         $query1= $conn -> prepare($sql1);
         $query1-> bindParam(':id', $id);
         $query1-> execute();
         if($query1->rowCount() > 0)
         {
             $customer_map=$query1->fetchAll();
         }
         $sql2 ="SELECT * FROM company_portfolio_map WHERE company_id=:id";
         $query2= $conn -> prepare($sql2);
         $query2-> bindParam(':id', $id);
         $query2-> execute();
         if($query2->rowCount() > 0)
         {
             $portfolio_map=$query2->fetchAll();
         }
         $sql3 ="SELECT * FROM company_reviews_map WHERE company_id=:id";
         $query3= $conn -> prepare($sql3);
         $query3-> bindParam(':id', $id);
         $query3-> execute();
         if($query3->rowCount() > 0)
         {
             $review_map=$query3->fetchAll();
         }
         $sql4 ="SELECT * FROM company_testimonials_map WHERE company_id=:id";
         $query4= $conn -> prepare($sql4);
         $query4-> bindParam(':id', $id);
         $query4-> execute();
         if($query4->rowCount() > 0)
         {
             $testimonial_map=$query4->fetchAll();
         }
         $sql5 ="SELECT * FROM company_service_map WHERE company_id=:id";
         $query5= $conn -> prepare($sql5);
         $query5-> bindParam(':id', $id);
         $query5-> execute();
         $service_map=$query5->fetchAll();
         $service_ids = array();
         foreach ($service_map as $object)
         {
             array_push($service_ids,$object['service_id']);
         }
     
         $sql6 ="SELECT * FROM company_location_map WHERE company_id=:id";
         $query6= $conn -> prepare($sql6);
         $query6-> bindParam(':id', $id);
         $query6-> execute();
         if($query6->rowCount() > 0)
         {
             $location_map=$query6->fetchAll();
         }

         $sql7 ="SELECT * FROM hourly_rates WHERE id=:id";
         $query7= $conn -> prepare($sql7);
         $query7-> bindParam(':id', $rph_id);
         $query7-> execute();
         if($query7->rowCount() > 0)
         {
             $hourly_rates=$query7->fetchAll();
             $hourly_rate = $hourly_rates[0]['text'];
         }
        //  print_r($hourly_rates[0]['text']);
        $sql8 ="SELECT * FROM team_sizes WHERE id=:id";
        $query8= $conn -> prepare($sql8);
        $query8-> bindParam(':id', $tz_id);
        $query8-> execute();
        if($query8->rowCount() > 0)
        {
            $team_sizes=$query8->fetchAll();
            $team_size = $team_sizes[0]['text'];
        }
       

        
        $sql9 ="SELECT * FROM services where services.status ='1'";
        $query9= $conn -> prepare($sql9);
        $query9-> execute();
        $services=$query9->fetchAll();


         
     }

}
    
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo  $m_description; ?> >">
    <meta name="keywords"content="<?php echo $m_keywords; ?> >">  
    <title>Hire My Developer | <?php echo $m_title; ?></title>
    <base href="http://192.168.10.87/company-directory/" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $m_title; ?></title>
    <meta name="Description" content="<?php echo $m_description; ?>">
    <meta name="Keywords" content="<?php echo $m_keywords; ?>">
  </head>
  
  <body>
<!-- ============================================================== -->
<!-- Header -->
<!-- ============================================================== -->  
<?php include('header.php'); ?>
<!-- ============================================================== -->
<!-- End Header -->
<!-- ============================================================== -->
<?php 

if($no_data){
 echo '<h2 class="d-flex justify-content-center p-5">Company Details Not Found !<h2>';
}else{ ?>
<section class="company-main">
 
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-12 left-area">
        <div class="company-profile">
          <div class="logo"><img src="admin/uploads/companies/<?php echo $logo; ?>" alt="Logo"></div>
          <div class="content-area">
            <h3> <?php echo $c_name; ?> </h3>
            <p><?php echo $c_description; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 right-area">
        <div class="contact-area">
          <ul>
            <li><i><img src="img/location.svg" alt=""></i><p><?php echo $c_address; ?></p></li>
            <li><i><img src="img/call.svg" alt=""></i><p><?php echo $c_contact; ?></p></li>
            <li><i><img src="img/mail.svg" alt="" style="width: 15px;"></i><a href="mailto:<?php echo $c_email; ?>"><?php echo $c_email; ?></a></li>
            <li><i><img src="img/web.svg" alt=""  style="width: 15px;"></i><a href="<?php echo $c_url; ?>" target="_blank"><?php echo $c_url; ?></a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-12 center-area">
        <ul>
          <li><img src="img/user.svg" alt=""><span><b><?php echo $team_size; ?></b> Employees</span></li>
          <li><img src="img/time.svg" alt=""><span><b><?php echo $hourly_rate; ?></b></span></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="home-five">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-12">
        <h2 class="head-main text-left mb-5"><span>IT Services in India</span></h2>
      <div class="row" id="left">
     <?php 
        foreach($services as $service) { 
         if (in_array($service['id'], $service_ids)){ 
         ?>     
        <div class="col-lg-6 col-md-6 col-sm-12">
          <a href="service/<?php echo $service['service_slug']?>/IN "> <div class="item"
                  style="background-image: url(admin/uploads/services/<?php echo $service['image'] ?>);">
                  
                  
                  <p 

                      class="pt-0"><?php echo $service['service_name'] ?>
                      <i>
                          <img src="img/right-arrow.svg" alt=""></i></p>

                  <div class="bg-color"></div>
              </div> </a>
          </div>
     <?php } 
        }
     ?>
      </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <h2 class="head-main text-left mb-3"><span>Top 10 Software Companies in India</span> </h2>
         <!-- <ul class="right-listing">
         <?php
                    foreach ($vofox_data as $vofox) {
                 ?>
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
                    }
                ?>
                    </ul> -->
               
              
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

                        <li class="right-list-loop" >
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

<section class="cliens-box gray-bg mb-3 mt-5">
  <div class="container">
    <h3 class="text-center">Portfolios</h3>
    <div class="client-slider">
    <?php foreach ($portfolio_map as $portfolio) { ?>    
      <div class="item">
        <div class="dp"><img src="admin/uploads/portfolios/<?php echo $portfolio['image']; ?>" alt="Portfolio Image"></div>
        <div class="content">
          <b><?php echo $portfolio['portfolio_title']; ?></b></br>
          <a href="<?php echo $portfolio['reference_link']; ?>" target="_blank" ><?php echo $portfolio['reference_link']; ?></a>
        </div>
      </div>
    <?php } ?> 
     
    </div>
  </div>
</section>


<section class="cliens-box">
  <div class="container">
    <h3 class="text-center">Testimonials</h3>
    <div class="client-slider2">
    <?php 
        foreach($testimonial_map as $testimonial) { 
    ?>   
      <div class="item">
        <div class="content"  style="min-height:140px;">
          <p> <?php echo $testimonial['testimonial_text']; ?> </p>
          <p><b> - <?php echo $testimonial['testimonial_name']; ?></b> </p>
        </div>
      </div>
      <?php }  ?>
    </div>
  </div>
</section>

<section class="cliens-box gray-bg mb-3 mt-5">
  <div class="container">
    <h3 class="text-center">Customer Reviews</h3>
    <div class="client-slider">
    <?php foreach ($review_map as $review) { ?>    
      <div class="item">
        <!-- <div class="dp"><img src="img/logo.svg" alt=""></div> -->
        <div class="content" style="min-height:110px; ">
          <b><?php echo $review['review_name']; ?></b>
          <p><?php echo $review['review_text']; ?></p>
          <div class="d-flex">
          <?php 
                $starNumber = $review['review_stars'];
            
                for($x=1;$x<=$starNumber;$x++) {
                    echo '<img src="img/star-fill.png" style="width:20px;margin-right:5px;"/>';
                }
                if (strpos($starNumber,'.')) {
                    echo '<img src="img/star-semi.png"  style="width:20px;margin-right:5px;"/>';
                    $x++;
                }
                while ($x<=5) {
                    echo '<img src="img/star.png" style="width:20px;margin-right:5px;" />';
                    $x++;
                }
           ?>
           </div>
        </div>
      </div>
    <?php } ?> 
     
    </div>
  </div>
</section>
  <section class="cliens-box mb-5 mt-5">
    <div class="container">
      <h3 class="text-center">Company Images</h3>
      <div class="client-slider3 parent-container">
      <?php
            $t = explode("|", $images);
            foreach ($t as $attach) {
                $attach = trim($attach);
            
            if($attach!=NULL){
        ?>    
        <a href="admin/uploads/companies/<?php echo $attach;?>" class="item p-0"><img src="admin/uploads/companies/<?php echo $attach;?>" alt="<?php echo $attach;?>"></a>
      <?php }  } ?>      
      </div>
      </div>
    </div>
</section>
<!-- <div class="container pagenation">
  <nav class="page navigation">
    <span>xsxsx</span>
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="#">Previous</a></li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
  </nav>
</div> -->
     <?php } ?>
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
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script>
      AOS.init();
    </script>
<script>
$('.client-slider').slick({
    slidesToShow: 3,
    autoplay: true,
    pauseOnHover: false,
    autoplaySpeed: 2000,
    draggable: false,
    arrows: false,
    dots: true
});
$('.client-slider2').slick({
    slidesToShow: 3,
    autoplay: true,
    pauseOnHover: false,
    autoplaySpeed: 2000,
    draggable: false,
    arrows: false,
    dots: true
});
$('.client-slider3').slick({
    slidesToShow: 4,
    autoplay: true,
    pauseOnHover: false,
    autoplaySpeed: 2000,
    draggable: false,
    arrows: false,
    dots: true
});

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

$(document).ready(function() {
  $('.parent-container').magnificPopup({
  delegate: 'a', // child items selector, by clicking on it popup will open
  type: 'image'
  // other options
});
});

    </script>

<script type="text/javascript">
	
	var offsetHeight = document.getElementById('left').offsetHeight;
document.getElementById('right').style.height = offsetHeight+'px';
if(offsetHeight==0){
  document.getElementById('right').style.height = '380px';
}
</script>
  </body>
</html>