
<?php 

  session_start();
  if (isset($_SESSION['sessionID'])) {
    // code...
  }else{
    echo "<script>window.location='../pages_login.php?login&error=Session Timeout try again.';</script>";
  }

  require __DIR__.'/performSecAction.php';
  $isPerformSecOBJ = new isPerformSecAction();
  require __DIR__.'/../CommonFunction/CommenForEveryUserFunction.php';
  $CommonOBJ = new CommonFunction();

  $dataQ = $isPerformSecOBJ->getSessionUser($_SESSION['sessionID']);
  $rowQ = $isPerformSecOBJ->getSessionUser($_SESSION['sessionID']);
      foreach ($dataQ as $key => $value) {
        // code...
        $fullname = $value['fullname'];
        $role = $value['role'];
        $AccountState = $value['account_status'];
        // $url = $value['profile_picture_url'];
        $lastlogintime = $value['last_login_time'];
        $url = $value['profile_picture_url'];
      }


 $congratsModalBool = $CommonOBJ->congratsModalBool($_SESSION['sessionID']);

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
  * Folder Super/Sec
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard" class="logo d-flex align-items-center">
        <img src="../assets/img/dichaLogoCurrent1.jpg" alt="" style="max-height: 60PX; max-width: 60px;">
        <!-- <span class="d-none d-lg-block">Honda</span> -->
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
        <?php if (isset($_GET['success'])) { ?>
        <div class="col-12">
          <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #198754; color: white;">
                 Hi, &nbsp; <?= $fullname; ?> ! &nbsp;<i class="bi-hand-thumbs-up"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      <?php } ?>
        <!-- Left side columns -->
       <div class="col-lg-12">
        <div class="row">

          <!-- Total Fans Card -->
          <div class="col-xxl-6 col-md-6 col-lg-6">
            <div class="card info-card sales-card">
              <?php  $CommonOBJ->confirmStatus($_SESSION['sessionID']); ?>
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
                <h5 class="card-title">Total Fans <span>| Today</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="ps-3">
                    <?php
                          $param = 1;
                          $QtyFans = $CommonOBJ->getFansQty();
                    ?>
                    <h6><?= $Q = $QtyFans ? $QtyFans : 0  ?></h6>
                    <span class="text-success small pt-1 fw-bold"><?php //echo $totalFans ? $totalFans : 0 ?></span> 
                    <span class="text-muted small pt-2 ps-1">All Fans</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Total Fans Card -->

          <!-- Total Players Card -->
          <div class="col-xxl-6 col-md-6 col-lg-6">
            <div class="card info-card revenue-card">

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
                <h5 class="card-title">Total Players <span>| This Month</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-badge-fill"></i>
                  </div>
                  <div class="ps-3">
                     <?php
                          $param = 1;
                          $QtyFans = $CommonOBJ->getTotalPlayers();
                    ?>
                    <h6><?= $Q = $QtyFans ? $QtyFans : 0  ?></h6>
                    <span class="text-muted small pt-2 ps-1">Players</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Total Players Card -->

          <!-- Total Admins Card -->
          <div class="col-xxl-6 col-xl-6">
            <div class="card info-card customers-card">

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
                <h5 class="card-title">Admins <span>| This Year</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-shield-lock-fill"></i>
                  </div>
                  <div class="ps-3">
                    <?php
                          $param = 1;
                          $QtyAdmins = $CommonOBJ->getTotalAdmins();
                    ?>
                    <h6><?= $Q = $QtyAdmins ? $QtyAdmins : 0  ?></h6>
                    <span class="text-muted small pt-2 ps-1">Admins</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Admins Card -->

          <!-- Total Matches Card -->
          <div class="col-xxl-6 col-xl-6">
            <div class="card info-card customers-card">

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
                <h5 class="card-title">Matches Played <span>| This Year</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-trophy-fill"></i>
                  </div>
                  <div class="ps-3">
                    <?php
                      //$totalMatches = $CommonOBJ->getTotalMatches();
                    ?>
                    <h6><?php //echo $totalMatches ? $totalMatches : 0 ?></h6>
                    <span class="text-muted small pt-2 ps-1">Matches</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Matches Card -->

        </div>
      </div>



      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer" style="margin-top: 150px;">
    <div class="copyright">
      &copy; Copyright <strong><span>Wolaita Dich FC</span></strong>.All right reserved.
    </div>
    <div class="credits">
     
      Powered By <a href="https://t.me/+qEQkBeElRQYxODM0">CS Students</a>
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
 <?php if ($congratsModalBool == 0): ?>
<div class="modal fade" id="firstLoginModal" tabindex="-1" aria-labelledby="firstLoginTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content neon-modal p-4 border-0 rounded position-relative">

      <!-- Logo Top Center -->
      <div class="text-center mb-3">
        <img src="../assets/img/dichaLogoCurrent1.jpg" alt="Wolaita Dicha FC" style="max-height: 60px; max-width: 60px;">
      </div>

      <div class="modal-header border-0 justify-content-center">
        <h5 class="modal-title" id="firstLoginTitle">Welcome!  <strong><?= htmlspecialchars($fullname) ?></strong>! 🎉</h5>
      </div>

      <div class="modal-body text-center">
        <p>Your account has been successfully created at <strong>Wolaita Dicha FC</strong>, Enjoy your account and explore all the features! ⚽️</p>

        <small class="text-muted d-block mt-3">This system is proudly powered by Dev <strong>Group 4</strong>.</small>
      </div>

      <div class="modal-footer justify-content-center border-0">
        <form action="" method="post">
          <input type="hidden" name="email" value="<?= $_SESSION['sessionID']; ?>">
          <button type="submit" class="btn btn-primary" name="confirmCongrats">OK</button>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
/* Neon spinning border for modal */
.neon-modal {
  background: #fff;
  border-radius: 12px;
  position: relative;
  overflow: hidden;
  z-index: 1;
}

/* Rotating neon border with pulsing glow */
.neon-modal::before {
  content: "";
  position: absolute;
  top: -4px;
  left: -4px;
  right: -4px;
  bottom: -4px;
  border-radius: 16px;
  background: conic-gradient(
    from 0deg,
    #5d57f4,
    #ff6b6b,
    #4cd964,
    #5d57f4
  );
  z-index: -1;
  animation: rotateBorder 4s linear infinite, pulseGlow 2s ease-in-out infinite alternate;
}

/* Inner cover to hide gradient in the middle */
.neon-modal::after {
  content: "";
  position: absolute;
  top: 4px;
  left: 4px;
  right: 4px;
  bottom: 4px;
  background: #fff;
  border-radius: 12px;
  z-index: -1;
}

/* Gradient rotation keyframes */
@keyframes rotateBorder {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Glow pulsing animation */
@keyframes pulseGlow {
  0% {
    filter: drop-shadow(0 0 8px #5d57f4)
            drop-shadow(0 0 8px #ff6b6b)
            drop-shadow(0 0 8px #4cd964);
  }
  50% {
    filter: drop-shadow(0 0 12px #5d57f4)
            drop-shadow(0 0 12px #ff6b6b)
            drop-shadow(0 0 12px #4cd964);
  }
  100% {
    filter: drop-shadow(0 0 8px #5d57f4)
            drop-shadow(0 0 8px #ff6b6b)
            drop-shadow(0 0 8px #4cd964);
  }
}

/* Ensure modal content stays above the border */
.neon-modal > * {
  position: relative;
  z-index: 1;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var firstLoginModal = new bootstrap.Modal(document.getElementById('firstLoginModal'));
    firstLoginModal.show();
});
</script>
<?php endif; ?>



</body>

</html>