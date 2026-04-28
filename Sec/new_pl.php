
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
   .input-group .valid-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      display: none; /* hide initially */
      pointer-events: none;
    }

  </style>
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
  <div class="row justify-content-center">

    <div class="col-lg-10 col-md-12 d-flex flex-column align-items-center justify-content-center pt-2">
      <div class="card w-100">
        <div class="card-body">

          <div class="pt-4 pb-2 text-center">
            <a href="#" class="newlogo d-flex align-items-center w-auto"></a>
            <h5 class="card-title pb-0 fs-4">New Player Registration Form</h5>
          </div>

<form class="row g-3 needs-validation" novalidate method="post" action="" id="forms" enctype="multipart/form-data">

<p class="text-center text-success spanError errorALL"></p>

<!-- Avatar (Full width) -->
<div class="col-12 text-center">
    <label class="col-form-label-sm">Player Avatar *</label>
    <div class="mb-2">
        <img id="avatarPreview"
             src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
             width="120" height="120"
             class="rounded-circle"
             style="object-fit: cover; border: 2px solid #ddd; cursor: pointer;"
             onclick="document.getElementById('avatar').click();">
    </div>
    <input type="file" name="avatar" id="avatar" accept="image/*"
           class="form-control d-none" onchange="previewAvatar(event)">
    <span class="text-danger spanError spanError-avatar"></span>
</div>

<!-- ROW 1 -->
<div class="row">
  <div class="col-md-4">
    <label class="col-form-label-sm">Full Name *</label>
    <input type="text" name="name" class="form-control" required>
    <span class="text-danger spanError spanError-name"></span>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Date of Birth *</label>
    <input type="date" name="date_of_birth" class="form-control" required>
    <span class="text-danger spanError spanError-dob"></span>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Gender *</label>
    <select name="gender" class="form-select" required>
      <option value="">Choose...</option>
      <option>Male</option>
      <option>Female</option>
      <option>Other</option>
    </select>
    <span class="text-danger spanError spanError-gender"></span>
  </div>
</div>

<!-- ROW 2 -->
<div class="row">
  <div class="col-md-4">
    <label class="col-form-label-sm">Nationality *</label>
    <select name="nationality" class="form-select" required>
      <option>Ethiopian</option>
      <option>Kenyan</option>
      <option>Ugandan</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Email *</label>
    <input type="email" name="email" class="form-control" required>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Phone *</label>
    <input type="text" name="phone" class="form-control" required>
  </div>
</div>

<!-- ROW 3 -->
<div class="row">
  <div class="col-md-4">
    <label class="col-form-label-sm">Club *</label>
    <select name="club_id" class="form-select" required>
      <option>Saint George</option>
      <option>Ethiopian Coffee</option>
      <option>Wolaita Dicha</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Position *</label>
    <select name="position" class="form-select" required>
      <option>Goalkeeper</option>
      <option>Defender</option>
      <option>Midfielder</option>
      <option>Forward</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Preferred Foot</label>
    <select name="preferred_foot" class="form-select">
      <option>Left</option>
      <option>Right</option>
      <option>Both</option>
    </select>
  </div>
</div>

<!-- ROW 4 -->
<div class="row">
  <div class="col-md-4">
    <label class="col-form-label-sm">Height (cm)</label>
    <input type="number" name="height_cm" class="form-control">
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Weight (kg)</label>
    <input type="number" name="weight_kg" class="form-control">
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Experience (Years)</label>
    <input type="number" name="experience_years" class="form-control" value="0">
  </div>
</div>

<!-- ROW 5 -->
<div class="row">
  <div class="col-md-4">
    <label class="col-form-label-sm">Skill Level</label>
    <select name="skill_level" class="form-select">
      <option>Beginner</option>
      <option>Intermediate</option>
      <option>Advanced</option>
      <option>Professional</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Contract Start</label>
    <input type="date" name="contract_start" class="form-control">
  </div>

  <div class="col-md-4">
    <label class="col-form-label-sm">Password *</label>
    <input type="password" name="password" class="form-control" required>
  </div>
</div>

<!-- SUBMIT -->
<div class="col-12 mt-3">
  <button class="btn btn-primary w-100" type="submit" name="isRegisterUser">
    Register Player
  </button>
</div>

</form>



        </div>
      </div>
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
  <!-- <script src="../dashboard/assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="../dashboard/assets/js/main.js"></script>
  <!-- Template Main JS File -->
  <!-- <script src="../dashboard/assets/js/main.js"></script> -->
 <script src="../dashboard/assets\ajax\jquery-2.2.4.min.js"></script>
  <script src="../dashboard/assets\ajax\jquery.js"></script>
  <script src="../dashboard/assets\ajax\jquery.min.js"></script>
  
  <script>
    $(document).ready(function() {
      // body...
      // Toggle password visibility

      $(".innershow").on('click', function(e) {
          e.preventDefault();
          $(this).toggleClass("bi-eye bi-eye-slash");
          var pass_field  = $(".pass-key"); 
          pass_field.attr("type", pass_field.attr("type") === "password" ? "text" : "password");
      });


    });
  </script>


 <script type="text/javascript">
// $(document).ready(function() {

//     // Toggle password visibility
//     $(".innershow").on('click', function(e) {
//         e.preventDefault();
//         $(this).toggleClass("bi-eye bi-eye-slash");
//         var pass_field  = $(".pass-key"); 
//         pass_field.attr("type", pass_field.attr("type") === "password" ? "text" : "password");
//     });

//     // Email validation regex
//     function isValidEmail(email) {
//         const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|gov|edu)$/i;
//         return re.test(String(email).toLowerCase());
//     }

//     const regexName = /^[a-zA-Z\s]+$/;

//       $("#name").on('blur keyup', function() {
//         var name = $(this).val().trim();
//         if (name === '') {
//             $(this).css("border-color","red");
//             $(".spanError-name").html("* This field is required.");
//         } else if (!regexName.test(name)) {
//             $(this).css("border-color","red");
//             $(".spanError-name").html("* Please enter a valid name.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-name").html('');
//         }
//     });

//     // Date of Birth
//     $("#dob").on('blur change', function() {
//         var dob = $(this).val();
//         if (dob === '') {
//             $(this).css("border-color","red");
//             $(".spanError-dob").text("* Date of Birth is required.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-dob").text("Looks good!");
//         }
//     });

//     // Gender
//     $("#gender").on('change blur keyup', function() {
//         var gender = $(this).val();
//         if (gender === '') {
//             $(this).css("border-color","red");
//             $(".spanError-gender").text("* Please select gender.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-gender").text("Looks good!");
//         }
//     });

//     // Nationality
//     $("#nationality").on('change', function() {
//         var nationality = $(this).val();
//         if (nationality === '') {
//             $(this).css("border-color","red");
//             $(".spanError-nationality").text("* Please select nationality.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-nationality").text("Looks good!");
//         }
//     });

//     // Email
//     $("#email-id").on('blur keyup', function() {
//         var email = $(this).val().trim();
//         if (email === '') {
//             $(this).css("border-color","red");
//             $(".spanError-1").text("* This field is required.");
//         } else if(!isValidEmail(email)){
//             $(this).css("border-color","red");
//             $(".spanError-1").text("* Please enter valid email.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-1").text("Looks good!");
//         }
//     });

//     // Phone
//     $("#phone").on('blur keyup change', function() {
//         var phone = $(this).val().trim();
//         var phonePattern = /^(09|07)\d{8}$/; // Starts with 09 or 07, 10 digits total
//         if (phone === '') {
//             $(this).css("border-color","red");
//             $(".spanError-phone").text("* This field is required.");
//         } else if (!phonePattern.test(phone)) {
//             $(this).css("border-color","red");
//             $(".spanError-phone").text("* Phone must start with 09 or 07 and be 10 digits.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-phone").text("Looks good!");
//         }
//     });

//     // Club
//     $("#club_id").on('change', function() {
//         var club = $(this).val();
//         if (club === '') {
//             $(this).css("border-color","red");
//             $(".spanError-club").text("* Please select a club.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-club").text("Looks good!");
//         }
//     });

//     // Position
//     $("#position").on('change', function() {
//         var position = $(this).val();
//         if (position === '') {
//             $(this).css("border-color","red");
//             $(".spanError-position").text("* Please select a position.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-position").text("Looks good!");
//         }
//     });

//     // Height
//     $("#height_cm").on('blur keyup', function() {
//         var h = $(this).val().trim();
//         if(h && h <= 0){
//             $(this).css("border-color","red");
//             $(".spanError-height").text("* Please enter a valid height.");
//         } else if(h){
//             $(this).css("border-color","green");
//             $(".spanError-height").text("Looks good!");
//         } else {
//             $(this).css("border-color","#ced4da");
//             $(".spanError-height").text('');
//         }
//     });

//     // Weight
//     $("#weight_kg").on('blur keyup', function() {
//         var w = $(this).val().trim();
//         if(w && w <= 0){
//             $(this).css("border-color","red");
//             $(".spanError-weight").text("* Please enter a valid weight.");
//         } else if(w){
//             $(this).css("border-color","green");
//             $(".spanError-weight").text("Looks good!");
//         } else {
//             $(this).css("border-color","#ced4da");
//             $(".spanError-weight").text('');
//         }
//     });

//     // Contract Start
//     $("#contract_start").on('blur change', function() {
//         var contract = $(this).val();
//         if(contract === ''){
//             $(this).css("border-color","red");
//             $(".spanError-contract").text("* Contract start date is required.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-contract").text("Looks good!");
//         }
//     });

//     // Password
//     $("#password").on('blur keyup', function() {
//         var password = $(this).val();
//         if (password === '') {
//             $(this).css("border-color","red");
//             $(".spanError-2").text("* This field is required.");
//         } else if (password.length < 6) {
//             $(this).css("border-color","red");
//             $(".spanError-2").text("* Password must be at least 6 characters.");
//         } else {
//             $(this).css("border-color","green");
//             $(".spanError-2").text("Looks good!");
//         }
//     });

//     // Avatar
//     $("#avatar").on('change', function(){
//         var file = $(this).val();
//         if(!file){
//             $(".spanError-avatar").text("* Please upload an avatar.");
//         } else {
//             $(".spanError-avatar").text("Looks good!");
//         }
//     });

//     // Final validation on submit
//     $("#AddBtn").on('click', function(event) {
//         $("#name, #dob, #gender, #nationality, #email-id, #phone, #club_id, #position, #height_cm, #weight_kg, #contract_start, #password, #avatar").trigger('blur change keyup');

//         let hasError = false;
//         $(".spanError").each(function(){
//             if($(this).text() && !$(this).text().includes("Looks good!")){
//                 hasError = true;
//             }
//         });

//         if(hasError){
//             event.preventDefault();
//         }
//     });

// });

</script>



</body>

</html>
 