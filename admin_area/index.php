<!--
    =========================================================
    * * Black Dashboard - v1.0.1
    =========================================================

    * Product Page: https://www.creative-tim.com/product/black-dashboard
    * Copyright 2019 Creative Tim (https://www.creative-tim.com)


    * Coded by Creative Tim

    =========================================================

    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php 

    session_start();
    include("includes/db.php");

    if(!isset($_SESSION['admin_email'])){

        echo "<script>window.open('login.php','_self')</script>";

    }else{

        $admin_session = $_SESSION['admin_email'];

        $get_admin = "select * from admins where admin_email='$admin_session'";

        $run_admin =  mysqli_query($con,$get_admin);

        $row_admin = mysqli_fetch_array($run_admin);

        $admin_id = $row_admin['admin_id'];

        $admin_name = $row_admin['admin_name'];

        $admin_email = $row_admin['admin_email'];

        $admin_contact = $row_admin['admin_contact'];

        $get_products = "select * from products";

        $run_products = mysqli_query($con,$get_products);

        $count_products = mysqli_num_rows($run_products);

        $get_customers = "select * from customers";

        $run_customers = mysqli_query($con,$get_customers);

        $count_customers = mysqli_num_rows($run_customers);



        ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="dashboard/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="dashboard/assets/img/favicon.png">
  <title>
    Black Dashboard by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <!-- Nucleo Icons -->
  <link href="dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="dashboard/assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="dashboard/assets/demo/demo.css" rel="stylesheet" />

  <!-- datatables -->


</head>

<body class="">
    <div class="wrapper">
        <?php include("includes/sidebar.php"); ?>
        <div class="main-panel">
        <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
                <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle d-inline">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                    </div>
                    <a class="navbar-brand"><img src="admin_images/logo.png" alt="" class="img-thumbnail border-0" width="150px"></a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav ml-auto">
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="photo">
                            <img src="dashboard/assets/img/anime3.png" alt="Profile Photo">
                        </div>
                        <b class="caret d-none d-lg-block d-xl-block"></b>
                        <p class="d-lg-none">
                            Log out
                        </p>
                        </a>
                        <ul class="dropdown-menu dropdown-navbar">
                        <li class="nav-link"><a href="user_profile.php" class="nav-item dropdown-item">Profile</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="nav-link"><a href="logout.php" class="nav-item dropdown-item">Log out</a></li>
                        </ul>
                    </li>
                    <li class="separator d-lg-none"></li>
                    </ul>
                </div>
                </div>
            </nav>
            <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    </div>
                </div>
                </div>
            </div>                        
        <!-- End Navbar -->
        <div class="content">
            
        <?php
                
                if(isset($_GET['view_orders'])){
                    
                    include("view_orders.php");
                    
                }

                if(isset($_GET['dashboard'])){
                    
                    include("dashboard.php");
                    
                }  

                if(isset($_GET['view_products'])){
                    
                    include("view_products.php");
                    
                }  

                
                if(isset($_GET['insert_product'])){

                  include("insert_product.php");

                }

                if(isset($_GET['edit_product'])){

                  include("edit_product.php");

                }

                if(isset($_GET['delete_product'])){

                  include("delete_product.php");

                }

                if(isset($_GET['view_cats'])){
                    
                    include("view_cats.php");
                    
                }

                if(isset($_GET['insert_cat'])){
                    
                  include("insert_cat.php");
                  
                }  

                if(isset($_GET['edit_cat'])){
                    
                include("edit_cat.php");
                
                }  

                if(isset($_GET['delete_cat'])){
                    
                  include("delete_cat.php");
                  
                } 

                if(isset($_GET['view_slides'])){
                    
                  include("view_slides.php");
                  
                }

                if(isset($_GET['insert_slide'])){
                    
                  include("insert_slide.php");
                  
                }

                if(isset($_GET['edit_slide'])){
                    
                  include("edit_slide.php");
                  
                }

                if(isset($_GET['delete_slide'])){
                    
                  include("delete_slide.php");
                  
                }

                if(isset($_GET['user_profile'])){
                    
                    include("user_profile.php");
                    
                }   

                if(isset($_GET['view_customers'])){
                    
                  include("view_customers.php");
                  
              } 

              if(isset($_GET['view_terms'])){
                    
                include("view_terms.php");
                
              }

              if(isset($_GET['insert_terms'])){
                    
                include("insert_terms.php");
                
              }

              if(isset($_GET['edit_term'])){
                    
                include("edit_term.php");
                
              }
              
              if(isset($_GET['delete_term'])){
                    
                include("delete_term.php");
                
              }

              if(isset($_GET['view_pro_cat'])){
                    
                include("view_pro_cat.php");
                
              }

              if(isset($_GET['insert_pro_cat'])){
                    
                include("insert_pro_cat.php");
                
              }

              if(isset($_GET['edit_pro_cat'])){
                    
                include("edit_pro_cat.php");
                
              }
              
              if(isset($_GET['delete_pro_cat'])){
                    
                include("delete_pro_cat.php");
                
              }

              if(isset($_GET['view_hsn'])){
                    
                include("view_hsn.php");
                
              }

              if(isset($_GET['insert_hsn'])){
                    
                include("insert_hsn.php");
                
              }

              if(isset($_GET['edit_hsn'])){
                    
                include("edit_hsn.php");
                
              }
              
              if(isset($_GET['delete_hsn'])){
                    
                include("delete_hsn.php");
                
              }

            
            ?>

        </div>
        <footer class="footer">
            <div class="container-fluid">
            <ul class="nav">
            
            </ul>
            
            </div>
        </footer>
        </div>
    </div>
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title"> Sidebar Background</li>
            <li class="adjustments-line">
            <a href="javascript:void(0)" class="switch-trigger background-color">
                <div class="badge-colors text-center">
                <span class="badge filter badge-primary active" data-color="primary"></span>
                <span class="badge filter badge-info" data-color="blue"></span>
                <span class="badge filter badge-success" data-color="green"></span>
                </div>
                <div class="clearfix"></div>
            </a>
            </li>
            <li class="adjustments-line text-center color-change">
            <span class="color-label">LIGHT MODE</span>
            <span class="badge light-badge mr-2"></span>
            <span class="badge dark-badge ml-2"></span>
            <span class="color-label">DARK MODE</span>
            </li>
            <!-- <li class="button-container">
            <a href="https://www.creative-tim.com/product/black-dashboard" target="_blank" class="btn btn-primary btn-block btn-round">Download Now</a>
            <a href="https://demos.creative-tim.com/black-dashboard/docs/1.0/getting-started/introduction.html" target="_blank" class="btn btn-default btn-block btn-round">
                Documentation
            </a>
            </li> -->
            <!-- <li class="header-title">Thank you for 95 shares!</li>
            <li class="button-container text-center">
            <button id="twitter" class="btn btn-round btn-info"><i class="fab fa-twitter"></i> &middot; 45</button>
            <button id="facebook" class="btn btn-round btn-info"><i class="fab fa-facebook-f"></i> &middot; 50</button>
            <br>
            <br>
            <a class="github-button" href="https://github.com/creativetimofficial/black-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
            </li> -->
        </ul>
    </div>
    </div>
  <!--   Core JS Files   -->
  <script src="dashboard/assets/js/core/jquery.min.js"></script>
  <script src="dashboard/assets/js/core/popper.min.js"></script>
  <script src="dashboard/assets/js/core/bootstrap.min.js"></script>
  <script src="dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="dashboard/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="dashboard/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="dashboard/assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="dashboard/assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
</body>

</html>

    <?php } ?>