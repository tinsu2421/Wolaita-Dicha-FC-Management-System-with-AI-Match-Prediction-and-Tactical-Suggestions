
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

  <style>
    .profile-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin: 50px auto;
    overflow: hidden;
}

.profile-header {
    background: linear-gradient(120deg, #0077b3, #6610f2);
    color: #fff;
    padding: 40px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 5px solid #fff;
    object-fit: cover;
    background: #fff;
}

.club-logo {
    width: 80px;
    height: 80px;
    border-radius: 15px;
    border: 2px solid #fff;
    object-fit: cover;
    background: #fff;
}

.card-body {
    padding: 30px;
}

.input-group input {
    border-radius: 12px;
    border: 1px solid #ced4da;
    box-shadow: none;
}

.input-group input:focus {
    border-color: #6610f2;
    box-shadow: 0 0 10px rgba(102,16,242,0.2);
}

.nav-tabs {
    border-bottom: none;
}

.nav-tabs .nav-link {
    border-radius: 10px;
    margin-bottom: 10px;
    color: #495057;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    background: #6610f2;
    color: #fff;
}

.stat-card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
    margin-bottom: 15px;
}

.stat-card h4 {
    font-size: 26px;
    margin: 0;
    font-weight: 700;
}

.stat-card p {
    margin: 0;
    color: #6c757d;
}

.tab-content .card {
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.achievements i {
    font-size: 2.2rem;
    margin-bottom: 10px;
}
  </style>
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

    <?php 

      $dataQPlayer = $CommonOBJ->getPlayerByEFFID(base64_decode($_GET['urlid']));
      foreach ($dataQPlayer as $key => $dataQPlayer) {
    ?>
        <div class="container">
          <div class="profile-card">
        <!-- Header -->
        <div class="profile-header">
            <img src="<?=$dataQPlayer['avatar']; ?>" alt="Avatar" class="avatar">
            <div class="text-center flex-grow-1 mx-3">
                <h2 class="mb-1"><?=$dataQPlayer['fullname'] ?></h2>
                <p class="mb-0 fs-5"><?=$dataQPlayer['position'] ?></p>
            </div>
            <img src="../logos/WolaitaDicha.jpg" alt="Club Logo" class="club-logo">
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row">
                <!-- Tabs vertical -->
                <div class="col-md-3 mb-3">
                    <div class="nav flex-column nav-tabs" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-profile-tab" data-bs-toggle="tab" data-bs-target="#v-profile" type="button">Profile</button>
                        <button class="nav-link" id="v-stats-tab" data-bs-toggle="tab" data-bs-target="#v-stats" type="button">Stats</button>
                        <button class="nav-link" id="v-contract-tab" data-bs-toggle="tab" data-bs-target="#v-contract" type="button">Contract</button>
                        <button class="nav-link" id="v-achievements-tab" data-bs-toggle="tab" data-bs-target="#v-achievements" type="button">Achievements</button>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="col-md-9">
                    <div class="tab-content" id="v-tabs-tabContent">
                        <!-- Profile -->
                        <div class="tab-pane fade show active" id="v-profile">
                            <div class="row g-3">
                                <div class="col-md-6"><strong>Full Name:</strong> <?=$dataQPlayer['fullname'] ?></div>
                                <div class="col-md-6"><strong>Date of Birth:</strong> <?=$dataQPlayer['date_of_birth'] ?></div>
                                <div class="col-md-6"><strong>Nationality:</strong> Ethiopian</div>
                                <div class="col-md-6"><strong>Email:</strong> <?=$dataQPlayer['email'] ?></div>
                                <div class="col-md-6"><strong>Phone:</strong> <?=$dataQPlayer['phone'] ?></div>
                                <div class="col-md-6"><strong>Height:</strong> <?=$dataQPlayer['height_cm'] ?> M</div>
                                <div class="col-md-6"><strong>Weight:</strong> <?=$dataQPlayer['weight_kg'] ?> kg</div>
                                <div class="col-md-6"><strong>Preferred Foot:</strong> <?=$dataQPlayer['preferred_foot'] ?></div>
                                <div class="col-md-6"><strong>Experience:</strong> <?=$dataQPlayer['experience_years'] ?></div>
                                <div class="col-md-6"><strong>Skill Level:</strong> <?=$dataQPlayer['skill_level'] ?></div>
                                <div class="col-md-6"><strong>EFF ID:</strong> <?=$dataQPlayer['effid'] ?></div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="tab-pane fade" id="v-stats">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <h4>50</h4>
                                        <p>Matches</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <h4>30</h4>
                                        <p>Goals</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <h4>15</h4>
                                        <p>Assists</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h5>Performance Progress</h5>
                                <div class="mb-2"><strong>Fitness:</strong> <div class="progress"><div class="progress-bar bg-success" style="width: 85%"></div></div></div>
                                <div class="mb-2"><strong>Speed:</strong> <div class="progress"><div class="progress-bar bg-warning" style="width: 78%"></div></div></div>
                                <div class="mb-2"><strong>Accuracy:</strong> <div class="progress"><div class="progress-bar bg-info" style="width: 92%"></div></div></div>
                            </div>
                        </div>

                        <!-- Contract -->
                        <div class="tab-pane fade" id="v-contract">
                            <div class="card p-3">
                                <p><strong>Contract Start:</strong> <?=$dataQPlayer['contract_start'] ?></p>
                                <p><strong>Contract End:</strong> <?=$dataQPlayer['contract_end'] ?></p>
                                <p><strong>Current Club:</strong> Wolaita Dicha FC</p>
                                <p><strong>Salary:</strong> N/A</p>
                                <p><strong>Contract Range:</strong> <?=$dataQPlayer['range_format'] ?></p>
                            </div>
                        </div>

                        <!-- Achievements -->
                        <div class="tab-pane fade" id="v-achievements">
                            <div class="row g-3 achievements">
                                <div class="col-md-4">
                                    <div class="card p-3 text-center">
                                        <i class="bi bi-trophy-fill text-warning"></i>
                                        <h5 class="mt-2">League Champion 2024</h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 text-center">
                                        <i class="bi bi-award-fill text-success"></i>
                                        <h5 class="mt-2">Top Scorer 2023</h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 text-center">
                                        <i class="bi bi-star-fill text-primary"></i>
                                        <h5 class="mt-2">Best Player 2022</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
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
  <!-- Activate/Deactivate Modal -->
<!-- DEACTIVATE MODAL -->
<div class="modal fade" id="deactivateModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Deactivate Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Are you sure you want to <b>deactivate</b> <span id="deactivate-fullname"></span>'s account?
        </div>

        <div class="modal-footer">
          <input type="hidden" name="email" id="deactivate-email">
          <input type="hidden" name="methodName" value="deactivateUser">

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="SusspendUser" class="btn btn-danger">Deactivate</button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- ACTIVATE MODAL -->
<div class="modal fade" id="activateModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-success">Activate Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Are you sure you want to <b>activate</b> <span id="activate-fullname"></span>'s account?
        </div>

        <div class="modal-footer">
          <input type="hidden" name="email" id="activate-email">
          <input type="hidden" name="methodName" value="activateUser">

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="UnSusspendUser" class="btn btn-success">Activate</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script>
// -------------------------
// Open DEACTIVATE Modal
// -------------------------
document.querySelectorAll('.btn-open-deactivate').forEach(button => {
    button.addEventListener('click', function () {

        // Get data from button
        const email = this.getAttribute('data-email');
        const fullname = this.getAttribute('data-fullname');

        // Insert into modal
        document.getElementById("deactivate-email").value = email;
        document.getElementById("deactivate-fullname").textContent = fullname;

        // Show modal
        const deactivateModal = new bootstrap.Modal(document.getElementById('deactivateModal'));
        deactivateModal.show();
    });
});


// -------------------------
// Open ACTIVATE Modal
// -------------------------
document.querySelectorAll('.btn-open-activate').forEach(button => {
    button.addEventListener('click', function () {

        // Get data from button
        const email = this.getAttribute('data-email');
        const fullname = this.getAttribute('data-fullname');

        // Insert into modal
        document.getElementById("activate-email").value = email;
        document.getElementById("activate-fullname").textContent = fullname;

        // Show modal
        const activateModal = new bootstrap.Modal(document.getElementById('activateModal'));
        activateModal.show();
    });
});
</script>



</body>

</html>