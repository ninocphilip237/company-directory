<!-- This page Includes repeating content after <body> tag upto including </aside> tag -->

<!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Hire My Developer</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->    
                         <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                     <ul class="navbar-nav mr-auto">
                       
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul> 
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <?php   if(isset($_SESSION['userlogin'])){ ?>
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                       <li class="nav-item dropdown">
                            <!-- <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a> -->
                           <!--  <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                          
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                          
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li> 
                                    <li>
                                        <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                 </ul>     
                             </div> -->
                        </li>  
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item right-side-toggle" title="Logout"> <a class="nav-link  waves-effect waves-light" href="logout.php"><i class="fa fa-power-off"></i></a></li>
                    </ul>
                    <?php  } ?>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User Profile-->
    <?php   if(isset($_SESSION['userlogin'])){ ?>
                <div class="user-profile">
                    <div class="user-pro-body">
                        <div><img src="../assets/images/users/user.jpg" alt="user-img" class="img-circle"></div>
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucfirst($_SESSION['userlogin']);  ?><span class="caret"></span></a>
                            <div class="dropdown-menu animated flipInY">

                                <!-- <div class="dropdown-divider"></div> -->
                                <!-- text-->
                                <a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?>
                <!-- Sidebar navigation-->
				<?php  
				// To Get Current page
				  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
                ?>  
                <?php   if(isset($_SESSION['userlogin'])){ ?> 
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- <li class="nav-small-cap">--- MAIN MENU</li> -->
                        <li <?php if($curPageName=='dashboard_admin.php'||$curPageName=='dashboard_d_entry.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="<?php if($_SESSION['usertype']=='admin'){ echo "dashboard_admin.php";  } else{ echo "dashboard_d_entry.php"; } ?>" aria-expanded="false"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard </a></li>
                        <li <?php if($curPageName=='services.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="services.php" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Services</span></a></li>
						<li <?php if($curPageName=='states.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="states.php" aria-expanded="false"><i class="ti-direction"></i><span class="hide-menu">States</span></a></li>
						<li <?php if($curPageName=='city.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="city.php" aria-expanded="false"><i class="fa fa-flag"></i><span class="hide-menu">Cities</span></a></li>
                        <li <?php if($curPageName=='locations.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="locations.php" aria-expanded="false"><i class="ti-location-pin"></i><span class="hide-menu">Locations</span></a></li>
                        <li <?php if($curPageName=='companies.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="companies.php" aria-expanded="false"><i class="ti-direction-alt"></i><span class="hide-menu">Companies</span></a></li>
                    <?php if($_SESSION['usertype'] == 'admin') { ?>
                        <li <?php if($curPageName=='hourly_rates.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="hourly_rates.php" aria-expanded="false"><i class="ti-money"></i><span class="hide-menu">Hourly Rates</span></a></li>
                        <li <?php if($curPageName=='team_sizes.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="team_sizes.php" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Team Sizes</span></a></li>
						<li <?php if($curPageName=='email_templates.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="email_templates.php" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">Email Template</span></a></li>
						<li <?php if($curPageName=='reviews.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="reviews.php" aria-expanded="false"><i class="ti-star"></i><span class="hide-menu">Reviews</span></a></li>
                        <li <?php if($curPageName=='users.php'){ ?> class="active" <?php } ?> > <a class="waves-effect waves-dark" href="users.php" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Users</span></a></li>
                    <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
                <?php } ?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
		
		