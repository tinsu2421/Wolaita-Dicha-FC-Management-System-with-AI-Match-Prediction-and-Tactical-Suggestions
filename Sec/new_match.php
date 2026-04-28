
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
           <p class="text-center text-success spanError errorALL"><?= $isPerformSecOBJ->isRegisterResult(); ?></p>
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
              <h5 class="mb-0">Add Club Match Result</h5>
            </div>
            <div class="card-body">
              <form id="matchResultForm" method="post" action="">

                <!-- Match Date -->
                <div class="mb-3 mt-3">
                  <label for="match_date" class="form-label">Match Date</label>
                  <input type="date" class="form-control" id="match_date" name="match_date">
                  <span id="spanError-match_date" class="text-danger"></span>
                </div>

                <!-- Home Club -->
                <div class="mb-3">
                  <label for="home_club" class="form-label">Home Club</label>
                  <select class="form-select" id="home_club" name="home_club" required>
                    <option value="Choose" selected>Select Home Club</option>
                    <option value="Wolaita Dicha">Wolaita Dicha FC</option>
                    <option value="Saint George">Saint George SC</option>
                    <option value="Ethiopian Coffee">Ethiopian Coffee SC</option>
                    <option value="Fasil Kenema">Fasil Kenema SC</option>
                    <option value="Sidama Coffee">Sidama Coffee SC</option>
                    <option value="Hawassa City">Hawassa Kenema SC</option>
                    <option value="Bahir Dar Kenema">Bahir Dar Kenema SC</option>
                    <option value="Adama City">Adama City FC</option>
                    <option value="Dire Dawa City">Dire Dawa City SC</option>
                    <option value="Hadiya Hossana">Hadiya Hossana FC</option>
                    <option value="Mekelle 70 Enderta">Mekelle 70 Enderta FC</option>
                    <option value="Arba Minch City">Arba Minch Kenema FC</option>
                    <option value="Defence Force">Defence Force SC</option>
                    <option value="Welwalo Adigrat University">Welwalo Adigrat University FC</option>
                    <option value="Shire Endaselassie">Shire Endaselassie FC</option>
                    <option value="Jimma Aba Jifar">Jimma Aba Jifar SC</option>
                    <option value="Academy">Academy</option>
                  </select>
                  <span id="spanError-home_club" class="text-danger"></span>
                </div>

                <!-- Away Club -->
                <div class="mb-3">
                  <label for="away_club" class="form-label">Away Club</label>
                  <select class="form-select" id="away_club" name="away_club" required>
                    <option value="Choose" selected>Select Away Club</option>
                    <option value="Wolaita Dicha">Wolaita Dicha FC</option>
                    <option value="Saint George">Saint George SC</option>
                    <option value="Ethiopian Coffee">Ethiopian Coffee SC</option>
                    <option value="Fasil Kenema">Fasil Kenema SC</option>
                    <option value="Sidama Coffee">Sidama Coffee SC</option>
                    <option value="Hawassa City">Hawassa Kenema SC</option>
                    <option value="Bahir Dar Kenema">Bahir Dar Kenema SC</option>
                    <option value="Adama City">Adama City FC</option>
                    <option value="Dire Dawa City">Dire Dawa City SC</option>
                    <option value="Hadiya Hossana">Hadiya Hossana FC</option>
                    <option value="Mekelle 70 Enderta">Mekelle 70 Enderta FC</option>
                    <option value="Arba Minch City">Arba Minch Kenema FC</option>
                    <option value="Defence Force">Defence Force SC</option>
                    <option value="Welwalo Adigrat University">Welwalo Adigrat University FC</option>
                    <option value="Shire Endaselassie">Shire Endaselassie FC</option>
                    <option value="Jimma Aba Jifar">Jimma Aba Jifar SC</option>
                    <option value="Academy">Academy</option>
                  </select>
                  <span id="spanError-away_club" class="text-danger"></span>
                </div>


                <!-- Scores -->
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="home_score" class="form-label">Home Score</label>
                    <input type="number" class="form-control" id="home_score" name="home_score" min="0" >
                    <span id="spanError-home_score" class="text-danger"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="away_score" class="form-label">Away Score</label>
                    <input type="number" class="form-control" id="away_score" name="away_score" min="0">
                    <span id="spanError-away_score" class="text-danger"></span>
                  </div>
                </div>

                <!-- Competition -->
                <div class="mb-3">
                  <label for="competition" class="form-label">Competition</label>
                  <select class="form-select" id="competition" name="competition" required>
                    <option value="Choose" selected>Select Competition</option>
                    <option value="Ethiopian Premier League">Ethiopian Premier League</option>
                    <option value="Ethiopian Cup">Ethiopian Cup</option>
                    <option value="Ethiopian Super Cup">Ethiopian Super Cup</option>
                    <option value="Friendly">Friendly Match</option>
                    <option value="CAF Champions League">CAF Champions League</option>
                    <option value="CAF Confederation Cup">CAF Confederation Cup</option>
                  </select>
                  <span id="spanError-competition" class="text-danger"></span>
                </div>


                <!-- Venue -->
                <div class="mb-3">
                  <label for="venue" class="form-label">Venue</label>
                  <select class="form-select" id="venue" name="venue" required>
                    <option value="Choose" selected>Select Venue</option>
                    <option value="Addis Ababa Stadium">Addis Ababa Stadium</option>
                    <option value="Hawassa Stadium">Hawassa University Stadium</option>
                    <option value="Dire Dawa Stadium">Dire Dawa Stadium</option>
                    <option value="Bahir Dar Stadium">Bahir Dar Stadium</option>
                  </select>
                  <span id="spanError-venue" class="text-danger"></span>
                </div>

                <!-- Match Week -->
                <div class="mb-3">
                  <label for="match_week" class="form-label">Match Week</label>
                  <select class="form-select" id="match_week" name="match_week" required>
                    <option value="Choose" selected>Select Match Week</option>
                    <!-- Example: 30 weeks -->
                    <?php
                      for ($i = 1; $i <= 30; $i++) {
                        echo "<option value='$i'>Week $i</option>";
                      }
                    ?>
                  </select>
                  <span id="spanError-match_week" class="text-danger"></span>
                </div>


                <!-- Status -->
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="" selected>Select Venue</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Postponed">Postponed</option>
                  </select>
                  <span id="spanError-status" class="text-danger"></span>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="submit" name="isRegisterResult" class="btn btn-primary" id="MatchResultAddForm">Save Match Result</button>
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
     
      Powered By <a href="https://t.me/+qEQkBeElRQYxODM0>CS Students</a>
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

      
      // === INLINE VALIDATION ===
      $("#match_date").on("blur keyup", function () {
          let match_date = $(this).val().trim();
          if (match_date === "" || match_date == null) {
              $("#spanError-match_date").html("* This field is required.");
              $("#match_date").css("border-color", "red");
          }else {
              $("#spanError-match_date").html("");
              $("#match_date").css("border-color", "green");
          }
      });

       // === INLINE VALIDATION ===
      $("#match_week").on("blur keyup", function () {
          let match_week = $(this).val().trim();
          if (match_week === "Choose" || match_week == null) {
              $("#spanError-match_week").html("* This field is required.");
              $("#match_week").css("border-color", "red");
          }else {
              $("#spanError-match_week").html("");
              $("#match_week").css("border-color", "green");
          }
      });

       // === INLINE VALIDATION ===
      $("#home_club").on("blur keyup", function () {
          let home_club = $(this).val().trim();
          if (home_club === "Choose" || home_club == null) {
              $("#spanError-home_club").html("* This field is required.");
              $("#home_club").css("border-color", "red");
          }else {
              $("#spanError-home_club").html("");
              $("#home_club").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#competition").on("blur keyup", function () {
          let competition = $(this).val().trim();
          if (competition === "Choose" || competition == null) {
              $("#spanError-competition").html("* This field is required.");
              $("#competition").css("border-color", "red");
          }else {
              $("#spanError-competition").html("");
              $("#competition").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#venue").on("blur keyup", function () {
          let venue = $(this).val().trim();
          if (venue === "Choose" || venue == null) {
              $("#spanError-venue").html("* This field is required.");
              $("#venue").css("border-color", "red");
          }else {
              $("#spanError-venue").html("");
              $("#venue").css("border-color", "green");
          }
      });

       $("#status").on("blur keyup", function () {
          let status = $(this).val().trim();
          if (status === "" || status == null) {
              $("#spanError-status").html("* This field is required.");
              $("#status").css("border-color", "red");
          }else {
              $("#spanError-status").html("");
              $("#status").css("border-color", "green");
          }
      });
      

         // === INLINE VALIDATION ===
      $("#away_club").on("blur keyup", function () {
          let away_club = $(this).val().trim();
          if (away_club === "Choose" || away_club == null) {
              $("#spanError-away_club").html("* This field is required.");
              $("#away_club").css("border-color", "red");
          }else {
              $("#spanError-away_club").html("");
              $("#away_club").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#home_score").on("blur keyup", function () {
          let home_score = $(this).val().trim();
          if (home_score === "" || home_score == null) {
              $("#spanError-home_score").html("* This field is required.");
              $("#home_score").css("border-color", "red");
          }else {
              $("#spanError-home_score").html("");
              $("#home_score").css("border-color", "green");
          }
      });

         // === INLINE VALIDATION ===
      $("#away_score").on("blur keyup", function () {
          let away_score = $(this).val().trim();
          if (away_score === "" || away_score == null) {
              $("#spanError-away_score").html("* This field is required.");
              $("#away_score").css("border-color", "red");
          }else {
              $("#spanError-away_score").html("");
              $("#away_score").css("border-color", "green");
          }
      });
    

      // === FINAL CHECK ON BUTTON CLICK ===
      $("#MatchResultAddForm").on("click", function (event) {
          let match_date = $("#match_date").val().trim();
          let home_club = $("#home_club").val().trim();
          let away_club = $("#away_club").val().trim();
          let away_score = $("#away_score").val().trim();
          let home_score = $("#home_score").val().trim();
          let competition = $("#competition").val().trim();
          let match_week = $("#match_week").val().trim();
          let venue = $("#venue").val().trim();
          let status = $("#status").val().trim();
          let valid = true;

          // match_date final check
          if (match_date === "") {
              $("#spanError-match_date").html("* This field is required.");
              $("#match_date").css("border-color", "red");
              valid = false;
          }
          if (home_club === "Choose" || home_club == null) {
              $("#spanError-home_club").html("* This field is required.");
              $("#home_club").css("border-color", "red");
              valid = false;
          }

          if (away_club === "Choose" || away_club == null) {
              $("#spanError-away_club").html("* This field is required.");
              $("#away_club").css("border-color", "red");
              valid = false;
          }

          if (home_score === "") {
              $("#spanError-home_score").html("* This field is required.");
              $("#home_score").css("border-color", "red");
              valid = false;
          }

          if (away_score === "" || away_score == null) {
              $("#spanError-away_score").html("* This field is required.");
              $("#away_score").css("border-color", "red");
              valid = false;
          }

          if (competition === "Choose" || competition == null) {
              $("#spanError-competition").html("* This field is required.");
              $("#competition").css("border-color", "red");
              valid = false;
          }

          if (venue === "Choose" || venue == null) {
              $("#spanError-venue").html("* This field is required.");
              $("#venue").css("border-color", "red");
              valid = false;

          }

          if (status === "" || status == null) {
              $("#spanError-status").html("* This field is required.");
              $("#status").css("border-color", "red");
              valid = false;
          }

          if (match_week === "Choose" || match_week == null) {
              $("#spanError-match_week").html("* This field is required.");
              $("#match_week").css("border-color", "red");
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
 