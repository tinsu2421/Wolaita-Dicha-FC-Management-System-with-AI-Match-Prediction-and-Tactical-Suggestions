
<?php 

  session_start();
  if (isset($_SESSION['sessionID'])) {
    // code...
  }else{
    echo "<script>window.location='../pages_login.php?login&error=Session Timeout try again.';</script>";
  }

   require __DIR__.'/performPlayerAction.php';
  $isPerformPlayerOBJ = new isPerformPlayerAction();
  require __DIR__.'/../CommonFunction/CommenForEveryUserFunction.php';
  $CommonOBJ = new CommonFunction();

  $dataQ = $isPerformPlayerOBJ->getSessionUser($_SESSION['sessionID']);
  $rowQ = $isPerformPlayerOBJ->getSessionUser($_SESSION['sessionID']);
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
      <a href="index.php" class="logo d-flex align-items-center">
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

        <!-- <div class="col-md-3"></div> -->
        <div class="col-md-5"></div>
        <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center pt-2">
          <div class="card ">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <a href="#" class="newlogo d-flex align-items-center w-auto">
                  <img src="ERP/assets/img/RodasNew.png" alt="" style="width: 100px;" class="">
                  <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
                </a>
                    <h5 class="card-title text-center pb-0 fs-4">Change Password ?</h5>
                    
                  </div>
                  <!--class: needs-validation attribute:novalidate -->
                  <form class="row g-3 needs-validations" novalidate method="post" action="" id="forms">
                    <?php

                    if (isset($_GET['error'])) { ?>
                     <p class="text-center text-danger small fw-bold" id="displayblock"><?= $_GET['error'];  ?></p>
                    <?php } ?>
                    
                    <p class="text-center text-success spanError errorALL"><?= $CommonOBJ->changePassword(); ?></p>
               
                    <div class="col-md-12">
                      <label for="yourUsername" class="col-form-label-sm">Email *</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="email" value="<?=$_SESSION['sessionID']; ?>">
                      </div>
                      <span class="text-danger spanError spanError-email"></span>
                    </div>
                    
                   <div class="col-md-12">
                   <label for="yourPassword" class="col-form-label-sm">OLD Password *</label>
                      <div class="input-group has-validation">
                      <span class="input-group-text show"><span class="bi bi-eye-slash innershow" id="togglePassword"></span></span>
                      <input type="password" name="oldPassword" class="form-control pass-key" id="oldpassword">
                    </div>
                    <span class="text-danger spanError spanError-oldpass"></span>
                  </div>

                  <div class="col-md-12">
                   <label for="yourPassword" class="col-form-label-sm">NEW Password *</label>
                      <div class="input-group has-validation">
                      <span class="input-group-text show"><span class="bi bi-eye-slash innershow" id="togglePassword"></span></span>
                      <input type="password" name="newPassword" class="form-control pass-key" id="newpassword">
                    </div>
                    <span class="text-danger spanError spanError-newpass"></span>
                  </div>

                  <div class="col-md-12">
                   <label for="yourPassword" class="col-form-label-sm">Confirm Password *</label>
                      <div class="input-group has-validation">
                      <span class="input-group-text show"><span class="bi bi-eye-slash innershow" id="togglePassword"></span></span>
                      <input type="password" name="conPassword" class="form-control pass-key" id="conpassword">
                    </div>
                    <span class="text-danger spanError spanError-conpass"></span>
                  </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="changePasswordBtn" id="AddBtn">Submit</button>
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
  ipt src="../dashboard/assets/js/main.js"></script>
  <script src="../dashboard/assets\ajax\jquery-2.2.4.min.js"></script>
  <script src="../dashboard/assets\ajax\jquery.js"></script>
  <script src="../dashboard/assets\ajax\jquery.min.js"></script>

  <script type="text/javascript">
$(document).ready(function() {

    // Generic inline validator
    function validateField(fieldId, errorClass, validator) {
        const field = $(fieldId);
        const errorSpan = $(errorClass);
        const value = field.val().trim();
        const result = validator(value);

        if (result.valid) {
            field.css("border-color", "green");
            errorSpan.html('');
        } else {
            field.css("border-color", "red");
            errorSpan.html(result.message);
        }

        return result.valid;
    }

    // Validators
    const notEmptyValidator = (fieldName) => (val) => ({
        valid: val !== '',
        message: `* ${fieldName} is required.`
    });

    const emailValidator = (val) => {
        const re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (val === '') return { valid: false, message: '* Email is required.' };
        if (!re.test(val.toLowerCase())) return { valid: false, message: '* Please enter a valid email.' };
        return { valid: true, message: '' };
    };

    const passwordValidator = (fieldName, minLength=6) => (val) => {
        if (val === '') return { valid: false, message: `* ${fieldName} is required.` };
        if (val.length < minLength) return { valid: false, message: `* ${fieldName} must be at least ${minLength} characters.` };
        return { valid: true, message: '' };
    };

    // Inline validation events
    $("#email").on('blur keyup', () => validateField("#email", ".spanError-email", emailValidator));
    $("#oldpassword").on('blur keyup', () => validateField("#oldpassword", ".spanError-oldpass", notEmptyValidator("Old Password")));
    $("#newpassword").on('blur keyup', () => validateField("#newpassword", ".spanError-newpass", passwordValidator("New Password")));
    $("#conpassword").on('blur keyup', () => validateField("#conpassword", ".spanError-conpass", passwordValidator("Confirm Password")));

    // Submit button click
    $("#AddBtn").on('click', function(event) {
        let validEmail = validateField("#email", ".spanError-email", emailValidator);
        let validOldPass = validateField("#oldpassword", ".spanError-oldpass", notEmptyValidator("Old Password"));
        let validNewPass = validateField("#newpassword", ".spanError-newpass", passwordValidator("New Password"));
        let validConPass = validateField("#conpassword", ".spanError-conpass", passwordValidator("Confirm Password"));

        // Optional: check if newpassword and conpassword match
        if ($("#newpassword").val().trim() !== $("#conpassword").val().trim()) {
            validNewPass = validConPass = false;
            $("#newpassword, #conpassword").css("border-color","red");
            $(".spanError-conpass").html("* Passwords do not match.");
        }

        if (!(validEmail && validOldPass && validNewPass && validConPass)) {
            event.preventDefault(); // stop form submission if any field is invalid
        } else {
            $("#forms").submit(); // submit form if all valid
        }
    });

    // Toggle password visibility
    $(".innershow").on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass("bi-eye bi-eye-slash");
        $(".pass-key").attr("type", function(_, type) {
            return type === "password" ? "text" : "password";
        });
    });

});
</script>


</body>

</html>