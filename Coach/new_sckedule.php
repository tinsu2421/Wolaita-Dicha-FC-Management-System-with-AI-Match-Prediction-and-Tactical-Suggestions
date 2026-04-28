
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
        $lastlogintime = $value['last_login_time'];
        $url = $value['profile_picture_url'];
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

        <!-- <div class="col-md-2"></div> -->
        <div class="col-md-5"></div>
        <!-- <div class="col-md-4"></div> -->
        <div class="row justify-content-center">
        <div class="col-md-7">
           <p class="text-center text-success spanError errorALL"><?= $isPerformCoachOBJ->isRegisterTrainingSckedule(); ?></p>
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
              <h5 class="mb-0">Register Club Training Schedule</h5>
            </div>
            <div class="card-body">
              <form id="trainingScheduleForm" method="post" action="">

                <!-- Training Date -->
                <div class="mb-3 mt-3">
                  <label for="training_date" class="form-label">Training Date</label>
                  <input type="date" class="form-control" id="training_date" name="training_date" required>
                  <div class="form-text text-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Training schedules can only be registered for dates from 2026 onwards.
                  </div>
                  <span id="spanError-training_date" class="text-danger"></span>
                </div>

                    <!-- Training Time -->
                    <div class="mb-3">
                      <label for="training_time" class="form-label">Training Time</label>
                      <input type="time" class="form-control" id="training_time" name="training_time" required>
                      <span id="spanError-training_time" class="text-danger"></span>
                    </div>

                    <!-- Training Type -->
                    <div class="mb-3">
                      <label for="training_type" class="form-label">Training Type</label>
                      <select class="form-select" id="training_type" name="training_type">
                        <option value="Choose" selected>Select Training Type</option>
                        <option value="Technical Training">Technical Training</option>
                        <option value="Physical Training">Physical Training</option>
                        <option value="Tactical Training">Tactical Training</option>
                        <option value="Match Preparation">Match Preparation</option>
                        <option value="Recovery Session">Recovery Session</option>
                        <option value="Friendly Match">Friendly Match</option>
                        <option value="Team Meeting">Team Meeting</option>
                      </select>
                      <span id="spanError-training_type" class="text-danger"></span>
                    </div>

                    <!-- Focus Area -->
                    <div class="mb-3">
                      <label for="focus_area" class="form-label">Focus Area</label>
                      <select class="form-select" id="focus_area" name="focus_area">
                        <option value="Choose" selected>Select Focus Area</option>
                        <option value="Passing">Passing</option>
                        <option value="Shooting">Shooting</option>
                        <option value="Defending">Defending</option>
                        <option value="Fitness">Fitness</option>
                        <option value="Set Pieces">Set Pieces</option>
                        <option value="Tactics">Tactics</option>
                        <option value="Ball Control">Ball Control</option>
                        <option value="Team Coordination">Team Coordination</option>
                      </select>
                      <span id="spanError-focus_area" class="text-danger"></span>
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                      <label for="location" class="form-label">Training Location</label>
                      <select class="form-select" id="location" name="location" required>
                        <option value="Choose" selected>Select Location</option>
                        <option value="Main Training Ground">Main Training Ground</option>
                        <option value="Secondary Field">Secondary Field</option>
                        <option value="Indoor Facility">Indoor Facility</option>
                        <option value="Gym">Gym</option>
                        <option value="Stadium">Stadium</option>
                        <option value="Away Venue">Away Venue</option>
                      </select>
                      <span id="spanError-location" class="text-danger"></span>
                    </div>

                      <!-- Coach -->
                      <div class="mb-3">
                        <label for="coach" class="form-label">Responsible Coach</label>
                        <input type="text" class="form-control" id="coach" name="coach" placeholder="Coach Name">
                        <span id="spanError-coach" class="text-danger"></span>
                      </div>

                      <!-- Duration & Intensity -->
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="duration" class="form-label">Duration (Minutes)</label>
                          <input type="number" class="form-control" id="duration" name="duration_minutes" min="30">
                          <span id="spanError-duration" class="text-danger"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="intensity" class="form-label">Intensity</label>
                          <select class="form-select" id="intensity" name="intensity">
                            <option value="Choose" selected>Choose Intensity</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Very High">Very High</option>
                          </select>
                          <span id="spanError-intensity" class="text-danger"></span>
                        </div>
                      </div>

                        <!-- Squad -->
                        <div class="mb-3">
                          <label for="squad" class="form-label">Squad</label>
                          <select class="form-select" id="squad" name="squad">
                            <option value="Choose">Choose Squad</option>
                            <option value="First Team">First Team</option>
                            <option value="Reserve Team">Reserve Team</option>
                            <option value="Youth Team">Youth Team</option>
                            <option value="U21">U21</option>
                            <option value="U19">U19</option>
                            <option value="Goalkeepers">Goalkeepers</option>
                            <option value="Defenders">Defenders</option>
                            <option value="Midfielders">Midfielders</option>
                            <option value="Forwards">Forwards</option>
                          </select>
                          <span id="spanError-squad" class="text-danger"></span>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                          <label for="status" class="form-label">Status</label>
                          <select class="form-select" id="status" name="status">
                            <option value="Choose" selected>Choose Status</option>
                            <option value="Scheduled">Scheduled</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Tentative">Tentative</option>
                          </select>
                          <span id="spanError-status" class="text-danger"></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                          <button type="submit" name="isRegisterTrainingSckedule" id="isRegisterTrainingSckedule" class="btn btn-primary">
                            Save Training Schedule
                          </button>
                        </div>

              </form>

            </div>
          </div>
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
  <!-- Template Main JS File -->
  <script src="../dashboard/assets/js/main.js"></script>
  <script src="../dashboard/assets\ajax\jquery-2.2.4.min.js"></script>
  <script src="../dashboard/assets\ajax\jquery.js"></script>
  <script src="../dashboard/assets\ajax\jquery.min.js"></script>
    <script src="../ajax\jquery-2.2.4.min.js"></script>
  <script src="../ajax\jquery.js"></script>
  <script src="../ajax\jquery.min.js"></script>
  <script type="text/javascript">
      $(document).ready(function () {

      // Set minimum date to 2026-01-01 or today, whichever is later
      const today = new Date();
      const minYear2026 = new Date('2026-01-01');
      const minDate = today > minYear2026 ? today : minYear2026;
      const minDateString = minDate.toISOString().split('T')[0];
      $("#training_date").attr('min', minDateString);
      
      // === INLINE VALIDATION ===
      $("#training_date").on("blur change", function () {
          let training_date = $(this).val().trim();
          if (training_date === "" || training_date == null) {
              $("#spanError-training_date").html("* This field is required.");
              $("#training_date").css("border-color", "red");
          } else {
              // Check if date is from 2026 or later
              const selectedDate = new Date(training_date);
              const year = selectedDate.getFullYear();
              
              if (year < 2026) {
                  $("#spanError-training_date").html("* Training date must be from 2026 or later. Selected year: " + year);
                  $("#training_date").css("border-color", "red");
              } else {
                  // Check if date is in the past
                  const today = new Date();
                  today.setHours(0, 0, 0, 0);
                  
                  if (selectedDate < today) {
                      $("#spanError-training_date").html("* Training date cannot be in the past.");
                      $("#training_date").css("border-color", "red");
                  } else {
                      $("#spanError-training_date").html("");
                      $("#training_date").css("border-color", "green");
                  }
              }
          }
      });

       // === INLINE VALIDATION ===
      $("#training_time").on("blur change", function () {
          let training_time = $(this).val().trim();
          if (training_time === "" || training_time == null) {
              $("#spanError-training_time").html("* This field is required.");
              $("#training_time").css("border-color", "red");
          } else {
              // Check for reasonable training hours (6 AM to 10 PM)
              const [hours, minutes] = training_time.split(':');
              const hour = parseInt(hours);
              
              if (hour < 6 || hour > 22) {
                  $("#spanError-training_time").html("* Training time should be between 6:00 AM and 10:00 PM.");
                  $("#training_time").css("border-color", "red");
              } else {
                  $("#spanError-training_time").html("");
                  $("#training_time").css("border-color", "green");
              }
          }
      });

       // === INLINE VALIDATION ===
      $("#training_type").on("blur change", function () {
          let training_type = $(this).val().trim();
          if (training_type === "Choose" || training_type == null) {
              $("#spanError-training_type").html("* This field is required.");
              $("#training_type").css("border-color", "red");
          }else {
              $("#spanError-training_type").html("");
              $("#training_type").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#focus_area").on("blur change", function () {
          let focus_area = $(this).val().trim();
          if (focus_area === "Choose" || focus_area == null) {
              $("#spanError-focus_area").html("* This field is required.");
              $("#focus_area").css("border-color", "red");
          }else {
              $("#spanError-focus_area").html("");
              $("#focus_area").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#location").on("blur change", function () {
          let location = $(this).val().trim();
          if (location === "Choose" || location == null) {
              $("#spanError-location").html("* This field is required.");
              $("#location").css("border-color", "red");
          }else {
              $("#spanError-location").html("");
              $("#location").css("border-color", "green");
          }
      });

       $("#coach").on("blur keyup", function () {
          let coach = $(this).val().trim();
          if (coach === "" || coach == null) {
              $("#spanError-coach").html("* This field is required.");
              $("#coach").css("border-color", "red");
          } else if (coach.length < 2) {
              $("#spanError-coach").html("* Coach name must be at least 2 characters long.");
              $("#coach").css("border-color", "red");
          } else if (coach.length > 50) {
              $("#spanError-coach").html("* Coach name cannot exceed 50 characters.");
              $("#coach").css("border-color", "red");
          } else if (!/^[a-zA-Z\s\-\.]+$/.test(coach)) {
              $("#spanError-coach").html("* Coach name can only contain letters, spaces, hyphens, and periods.");
              $("#coach").css("border-color", "red");
          } else {
              $("#spanError-coach").html("");
              $("#coach").css("border-color", "green");
          }
      });
      

      // === INLINE VALIDATION ===
      $("#duration").on("blur keyup", function () {
          let duration = $(this).val().trim();
          if (duration === "" || duration == null) {
              $("#spanError-duration").html("* This field is required.");
              $("#duration").css("border-color", "red");
          } else if (isNaN(duration) || duration <= 0) {
              $("#spanError-duration").html("* Duration must be a positive number.");
              $("#duration").css("border-color", "red");
          } else if (duration < 30) {
              $("#spanError-duration").html("* Training duration must be at least 30 minutes.");
              $("#duration").css("border-color", "red");
          } else if (duration > 300) {
              $("#spanError-duration").html("* Training duration cannot exceed 300 minutes (5 hours).");
              $("#duration").css("border-color", "red");
          } else {
              $("#spanError-duration").html("");
              $("#duration").css("border-color", "green");
          }
      });

      // === INLINE VALIDATION ===
      $("#intensity").on("blur change", function () {
          let intensity = $(this).val().trim();
          if (intensity === "Choose" || intensity == null) {
              $("#spanError-intensity").html("* This field is required.");
              $("#intensity").css("border-color", "red");
          }else {
              $("#spanError-intensity").html("");
              $("#intensity").css("border-color", "green");
          }
      });

      // === INLINE VALIDATION ===
      $("#squad").on("blur change", function () {
          let squad = $(this).val().trim();
          if (squad === "Choose" || squad == null) {
              $("#spanError-squad").html("* This field is required.");
              $("#squad").css("border-color", "red");
          }else {
              $("#spanError-squad").html("");
              $("#squad").css("border-color", "green");
          }
      });

      // === INLINE VALIDATION ===
      $("#status").on("blur change", function () {
          let status = $(this).val().trim();
          if (status === "Choose" || status == null) {
              $("#spanError-status").html("* This field is required.");
              $("#status").css("border-color", "red");
          }else {
              $("#spanError-status").html("");
              $("#status").css("border-color", "green");
          }
      });
    

      // === FINAL CHECK ON BUTTON CLICK ===
      $("#isRegisterTrainingSckedule").on("click", function (event) {
          let training_date = $("#training_date").val().trim();
          let training_type = $("#training_type").val().trim();
          let training_time = $("#training_time").val().trim();
          let focus_area = $("#focus_area").val().trim();
          let location = $("#location").val().trim();
          let coach = $("#coach").val().trim();
          let duration = $("#duration").val().trim();
          let squad = $("#squad").val().trim();
          let intensity = $("#intensity").val().trim();
          let status = $("#status").val().trim();
           
          
          let valid = true;

          // training_date final check
          if (training_date === "") {
              $("#spanError-training_date").html("* This field is required.");
              $("#training_date").css("border-color", "red");
              valid = false;
          } else {
              // Check if date is from 2026 or later
              const selectedDate = new Date(training_date);
              const year = selectedDate.getFullYear();
              
              if (year < 2026) {
                  $("#spanError-training_date").html("* Training date must be from 2026 or later. Selected year: " + year);
                  $("#training_date").css("border-color", "red");
                  valid = false;
              } else {
                  // Check if date is in the past
                  const today = new Date();
                  today.setHours(0, 0, 0, 0);
                  
                  if (selectedDate < today) {
                      $("#spanError-training_date").html("* Training date cannot be in the past.");
                      $("#training_date").css("border-color", "red");
                      valid = false;
                  }
              }
          }

          if (training_time === "" || training_time == null) {
              $("#spanError-training_time").html("* This field is required.");
              $("#training_time").css("border-color", "red");
              valid = false;
          } else {
              // Check for reasonable training hours
              const [hours, minutes] = training_time.split(':');
              const hour = parseInt(hours);
              
              if (hour < 6 || hour > 22) {
                  $("#spanError-training_time").html("* Training time should be between 6:00 AM and 10:00 PM.");
                  $("#training_time").css("border-color", "red");
                  valid = false;
              }
          }

           if (training_type === "Choose" || training_type == null) {
              $("#spanError-training_type").html("* This field is required.");
              $("#training_type").css("border-color", "red");
              valid = false;
          }

          if (focus_area === "Choose" || focus_area == null) {
              $("#spanError-focus_area").html("* This field is required.");
              $("#focus_area").css("border-color", "red");
              valid = false;
          }

          if (location === "Choose" || location == null) {
              $("#spanError-location").html("* This field is required.");
              $("#location").css("border-color", "red");
              valid = false;

          }
          if (coach === "" || coach == null) {
              $("#spanError-coach").html("* This field is required.");
              $("#coach").css("border-color", "red");
              valid = false;
          } else if (coach.length < 2) {
              $("#spanError-coach").html("* Coach name must be at least 2 characters long.");
              $("#coach").css("border-color", "red");
              valid = false;
          }

          if (duration === "" || duration == null) {
              $("#spanError-duration").html("* This field is required.");
              $("#duration").css("border-color", "red");
              valid = false;
          } else if (isNaN(duration) || duration <= 0) {
              $("#spanError-duration").html("* Duration must be a positive number.");
              $("#duration").css("border-color", "red");
              valid = false;
          } else if (duration < 30) {
              $("#spanError-duration").html("* Training duration must be at least 30 minutes.");
              $("#duration").css("border-color", "red");
              valid = false;
          } else if (duration > 300) {
              $("#spanError-duration").html("* Training duration cannot exceed 300 minutes.");
              $("#duration").css("border-color", "red");
              valid = false;
          }

          if (intensity === "Choose") {
              $("#spanError-intensity").html("* This field is required.");
              $("#intensity").css("border-color", "red");
              valid = false;
          }

          if (squad === "Choose" || squad == null) {
              $("#spanError-squad").html("* This field is required.");
              $("#squad").css("border-color", "red");
              valid = false;
          }

          if (status === "Choose" || status == null) {
              $("#spanError-status").html("* This field is required.");
              $("#status").css("border-color", "red");
              valid = false;
          }

          // Stop submit if invalid
          if (!valid) {
              event.preventDefault();
          }

          
      });

  });
  </script>
</body>

</html>
 