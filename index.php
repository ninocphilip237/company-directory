<?php
$s=$page = 1;
$back=$next=$start=0;
include 'admin/config.php';
$s = 1;
$sqls ="SELECT * FROM companies WHERE company_list_status=:s";
$querys= $conn -> prepare($sqls);
$querys-> bindParam(':s', $s);
$querys-> execute();
if($querys->rowCount() > 0)
{
    $vofox_data=$querys->fetchAll();
}



// Fetch companies from database   

$sql1 = "SELECT a.id,a.company_name,a.slug,a.website_url,a.logo FROM ( SELECT companies.id, companies.company_name,companies.slug,companies.website_url,companies.logo FROM companies WHERE companies.profile_progress >= 67 AND  companies.company_list_status=0 AND companies.status='1') a ORDER BY RAND() LIMIT 9";
$query1 = $conn->prepare($sql1);
$query1->execute();
$results1 = $query1->fetchAll();


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
   <title>Hire My Developer | Hire Dedicated Developers, Programmers, Experts &amp; Specialist From India</title>
    <meta charset="utf-8">
    <meta value="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
                    <h2 class="head-main text-left mb-5"><span>IT Services in India</span></h2>
                    <div class="row" id="left">
 <?php
error_reporting(0);
$page_name = "index.php"; //  If you use this code with a different page ( or file ) name then change this
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

$nume = $conn->query("select count(id) from services where services.status ='1' ")->fetchColumn();

$query = " SELECT * FROM services where services.status ='1'  limit $eu, $limit ";
$exe = $conn->prepare($query);
$exe->execute();
$results = $exe->fetchAll();

foreach ($conn->query($query) as $row) {
    $m = $i % 2; // required for alternate color of rows matching to style class
    $i = $i + 1; //  increment for alternate color of rows

}

?>

                        <?php
foreach ($results as $result) {
    ?>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                        <a href="service/<?php echo $result['service_slug']  ?>/IN "> <div class="item"
                                style="background-image: url(admin/uploads/services/<?php echo $result['image'] ?>);">
                                <input type="hidden" name ="stateval" id="stateval"/>
                                <input type="hidden" name ="cityval" id="cityval"/>
                                
                                <p 

                                    class="pt-0"><?php echo $result['service_name'] ?>
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




    <div class="container pagenation">
        <nav class="page navigation">
            <?php

if ($nume > $limit) { // Let us display bottom links if sufficient records are there for paging
    // echo "<table align = 'center' width='100%'><tr><td  align='left' width='90%'>";

    if ($back >= 0) {
        print "<a href='page-$back'><font face='Verdana' size='2' class='page-link page-item'>PREV</font></a>";
    }

    echo "</td><td align=center width='20%'>";

    $i = 0;
    $l = 1;
    for ($i = 0; $i < $nume; $i = $i + $limit) {
        if ($i != $eu) {
            echo " <a href='page-$l'><font face='Verdana' size='2' class='page-link page-item'>$l</font></a> ";
        } else {echo "<font face='Verdana' size='4' color=red class='page-link page-item'>$l</font>";}
/// Current page is not displayed as link and given font color red
        $l = $l + 1;
    }

    echo "</td><td  align='right' width='30%'>";
   
    if ($this1 < $nume) {
        print "<a href='page-$next'><font face='Verdana' size='2' class='page-link page-item'>NEXT</font></a>";}
    echo "</td></tr></table>";

} // end of if checking sufficient records are there to display bottom navigational link.
?>
            </ul>
        </nav>
    </div>



<!-- ============================================================== -->
<!-- Footer -->
<!-- ============================================================== -->
<?php include('footer.php'); ?>
<!-- ============================================================== -->
<!-- End Footer -->
<!-- ============================================================== -->



<script>


function statpg(sr){

//sr = '<?php echo $_REQUEST['service'] ?>';

    window.location.assign("companies.php?service_slug="+sr);

}

</script>

    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 100) {
            $("header").addClass("active");
        } else {
            $("header").removeClass("active");
        }
    });
    $(".enq-fix-box .btn-box").click(function() {
        $(".enq-fix-box").toggleClass("active");
    });
    </script>

<script type="text/javascript">
	
	var offsetHeight = document.getElementById('left').offsetHeight;
document.getElementById('right').style.height = offsetHeight+'px';
</script>
</body>


</html>