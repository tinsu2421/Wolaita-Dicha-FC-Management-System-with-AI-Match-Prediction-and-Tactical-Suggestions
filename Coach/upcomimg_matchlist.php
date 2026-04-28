
<?php 

  session_start();
  if (isset($_SESSION['sessionID'])) {
    // code...
  }else{
    echo "<script>window.location='../pages_login.php?login&error=Session Timeout try again.';</script>";
  }

  require __DIR__.'/performCoachAction.php';
  $isPerformCoachOBJ = new isperformCoachAction();
  require __DIR__.'/../CommonFunction/CommenForEveryUserFunction.php';
  $CommonOBJ = new CommonFunction();

  // Coaches only have view access - no delete functionality needed

  $dataQ = $isPerformCoachOBJ->getSessionUser($_SESSION['sessionID']);
  $rowQ = $isPerformCoachOBJ->getSessionUser($_SESSION['sessionID']);
      // Initialize variables with default values
  $fullname = '';
  $role = '';
  $AccountState = '';
  $lastlogintime = '';
  $url = '';
  $urlId = '';
  
  foreach ($dataQ as $key => $value) {
        // code...
        $fullname = $value['fullname'];
        $role = $value['role'];
        $AccountState = $value['account_status'];
        $url = $value['profile_picture_url'];
        $lastlogintime = $value['last_login_time'];
      }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Wolaita Dicha - FC</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!--Organization Favicons -->
  <link href="../assets/img/dichaLogo.jpg" rel="icon">
  <link href="../assets/img/dichaLogo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../dashboard/assets/css/style.css" rel="stylesheet">
  <link href="../dashboard/assets/css/logo.css" rel="stylesheet">

  <!-- =======================================================
  * Folder Super/Admin
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard" class="logo d-flex align-items-center">
        <img src="../assets/img/dichaLogoCurrent1.jpg" alt="" style="max-height: 60PX; max-width: 60px;">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        <!-- End Search Icon-->

        <!-- Notification Bar Here start -->

        <!-- Notification Bar Here end -->

        <!-- Messsage Bar Here end -->
        <!-- Messsage Bar Here end -->

        
        <!-- End Messages Nav -->

      <?php include __DIR__.'/profileModal.php';  ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <!-- Include aside bar for super admin -->
  <?php 
    require __DIR__.'/Component/Asidebar.php';
    // require __DIR__.'/Component/Logoutmodal.php';
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
<?php 
    require __DIR__.'/Component/Logoutmodal.php';
?>
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home (<?=$role; ?>)</a></li>
          <li class="breadcrumb-item active">Last login date : <?= $lastlogintime; ?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

      <section class="section dashboard">
      <div class="row">

        <!-- <div class="col-md-1"></div> -->
        <div class="col-lg-12 col-md-8 d-flex flex-column align-items-center justify-content-center pt-2">
          <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Upcoming Matches<span>| View Only</span></h5>
                  <p class="text-info text-center mb-3" style="font-size: 12px; font-style: italic;">
                    <i class="bi bi-info-circle me-1"></i>
                    Coaches have view-only access to upcoming matches. Contact Secretary for match modifications.
                  </p>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Home </th>
                        <th scope="col">Away</th>
                        <th scope="col">Comp</th>
                        <th scope="col">Venue</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                        $dataQMatchResult = $CommonOBJ->fetchUpcomingResult();
                        $rowQMatch = $CommonOBJ->fetchUpcomingResult();
                        if ($rowQMatch > 0) {
                          // code...
                          $x = 0;
                          foreach ($dataQMatchResult as $key => $value) {
                            // code...
                            $x++; ?>
                      <tr>
                        <th scope="row"><a href="#"><?= $x; ?></a></th>
                        <td><?= date('M d, Y', strtotime($value['match_date'])); ?></td>
                        <td><?= $value['home_club']; ?></td>
                        <td><?= $value['away_club']; ?></td>
                        <td><?= $value['competition']; ?></td>
                        <td><?= $value['venue']; ?></td>
                        
                      
                      <td>
                          <button 
                                class="btn btn-success btn-sm"
                                style="border-radius:3px;height:25px;font-size:10px;">
                                <?= $value['status']; ?>
                          </button>
                      
                      </td>

                      </tr>
                         <?php } }else{ ?>

                       <?php } ?>
                      
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->
        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer" style="margin-top: 150px;">
    <div class="copyright">
      &copy; Copyright <strong><span>Wolaita Dicha FC</span></strong>.All right reserved.
    </div>
    <div class="credits">
     
      Powered By <a href="https://t.me/+qEQkBeElRQYxODM0">Cs Students</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dashboard/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../dashboard/assets/vendor/quill/quill.min.js"></script>
  <script src="../dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../dashboard/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../dashboard/assets/js/main.js"></script>

</body>

</html>