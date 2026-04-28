
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

  <link rel="stylesheet" type="text/css" href="avatar.css">
  <style>


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

        <div class="col-md-5"></div>

          <div class="col-lg-10 col-md-12 d-flex flex-column align-items-center justify-content-center pt-2">
          <div class="card w-100">
                <div class="card-body">

                <div class="pt-4 pb-2 text-center">
                  <a href="#" class="newlogo d-flex align-items-center w-auto"></a>
                  <h5 class="card-title pb-0 fs-4">New Player Registration Form</h5>
                </div>
                 <form class="row g-3 needs-validation" novalidate method="post" action="" id="forms" enctype="multipart/form-data">
                  
                    <p class="text-center text-success spanError errorALL"><?= $isPerformSecOBJ->isRegisterPlayer(); ?></p>

                    
                   
                     <div class="col-md-4">
                      <label for="yourUsername" class="col-form-label-sm">Fullname *</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="fullname" class="form-control" id="name" required>
                      </div>
                      <span class="text-danger spanError spanError-name"></span>
                    </div> 

                    <div class="col-md-4">
                      <label for="yourUsername" class="col-form-label-sm">Email *</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="email-id" required>
                        <input type="hidden" name="regiterBy" value="<?=$fullname; ?>" class="form-control">
                      </div>
                      <span class="text-danger spanError spanError-1"></span>
                    </div>

                    <div class="col-md-4">
                      <label for="yourUsername" class="col-form-label-sm">Mobile Number *</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="0912345678" maxlength="10">
                      </div>
                      <small class="text-muted">Format: 09xxxxxxxx (10 digits starting with 09)</small>
                      <span class="text-danger spanError spanError-phone"></span>
                    </div>

                     <div class="col-md-4">
                        <label for="gender" class="col-form-label-sm">Gender *</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="Choose">Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                           
                        </select>
                        <span class="text-danger spanError spanError-gender"></span>
                    </div>
                    

                <div class="col-md-4">
                    <label for="dob" class="col-form-label-sm">Date of Birth *</label>
                    <input type="date" name="dob" class="form-control" id="date_of_birth" required max="<?= date('Y-m-d', strtotime('-17 years')) ?>">
                    <small class="text-muted">Player must be at least 17 years old</small>
                    <span class="text-danger spanError spanError-date_of_birth"></span>
                </div>

                <div class="col-md-4">
                  <label for="nationality" class="col-form-label-sm">Nationality *</label>
                  <select name="nationality" id="nationality" class="form-select" required>
                      <option value="Choose">Choose...</option>
                      <option value="Ethiopian" selected>Ethiopian</option>
                      <option value="Kenyan">Kenyan</option>
                      <option value="Ugandan">Ugandan</option>
                      <option value="Sudanese">Sudanese</option>
                      <option value="Other">Other</option>
                  </select>
                  <span class="text-danger spanError spanError-nationality"></span>
              </div>

             <div class="col-md-4">
              <label for="club_id" class="col-form-label-sm">Recent Club *</label>
              <select name="club" id="club_id" class="form-select" required>
                  <option value="Choose">Choose Club...</option>

                  <option value="Saint George SC">Saint George SC</option>
                  <option value="Ethiopian Coffee SC">Ethiopian Coffee SC</option>
                  <option value="Wolaita Dicha SC">Wolaita Dicha SC</option>
                  <option value="Fasil Kenema SC">Fasil Kenema SC</option>
                  <option value="Sidama Coffee SC">Sidama Coffee SC</option>
                  <option value="Hawassa Kenema SC">Hawassa Kenema SC</option>
                  <option value="Bahir Dar Kenema SC">Bahir Dar Kenema SC</option>
                  <option value="Adama City FC">Adama City FC</option>
                  <option value="Dire Dawa City SC">Dire Dawa City SC</option>
                  <option value="Hadiya Hossana FC">Hadiya Hossana FC</option>
                  <option value="Mekelle 70 Enderta FC">Mekelle 70 Enderta FC</option>
                  <option value="Arba Minch Kenema FC">Arba Minch Kenema FC</option>
                  <option value="Defence Force SC">Defence Force SC</option>
                  <option value="Welwalo Adigrat University FC">Welwalo Adigrat University FC</option>
                  <option value="Shire Endaselassie FC">Shire Endaselassie FC</option>
                  <option value="Jimma Aba Jifar SC">Jimma Aba Jifar SC</option>
                  <option value="Academy">Academy</option>

              </select>
              <span class="text-danger spanError spanError-club"></span>
          </div>


              <div class="col-md-4">
                <label for="position" class="col-form-label-sm">Position *</label>
                <select name="position" id="position" class="form-select" required>
                    <option value="Choose">Choose Position...</option>
                    <option value="Goalkeeper">Goalkeeper</option>
                    <option value="Defender">Defender</option>
                    <option value="Midfielder">Midfielder</option>
                    <option value="Forward">Forward</option>
                </select>
                <span class="text-danger spanError spanError-position"></span>
            </div>

        <div class="col-md-4">
            <label for="height_cm" class="col-form-label-sm">Height (m)</label>
            <input type="number" step="0.01" name="height" class="form-control" id="height_cm" placeholder="e.g., 1.75">
            <span class="text-danger spanError spanError-height"></span>
        </div>

        <!-- Weight -->
        <div class="col-md-4">
            <label for="weight_kg" class="col-form-label-sm">Weight (kg)</label>
            <input type="number" name="weight" class="form-control" id="weight_kg">
            <span class="text-danger spanError spanError-weight"></span>
        </div>

         <!-- Preferred Foot -->
        <div class="col-md-4">
            <label for="preferred_foot" class="col-form-label-sm">Preferred Foot</label>
            <select name="preferred_foot" id="preferred_foot" class="form-select">
                <option value="">Choose...</option>
                <option value="Left">Left</option>
                <option value="Right">Right</option>
                <option value="Both">Both</option>
            </select>
            <span class="text-danger spanError spanError-preferred_foot"></span>
        </div>

        <!-- Experience Years -->
        <div class="col-md-4">
            <label for="experience_years" class="col-form-label-sm">Experience (years)</label>
            <input type="number" name="experience" class="form-control" id="experience_years" min="0" max="20" value="">
            <small class="text-muted">Maximum 20 years of experience</small>
            <span class="text-danger spanError spanError-experience"></span>
        </div>

        <div class="col-md-4">
            <label for="skill_level" class="col-form-label-sm">Skill Level</label>
            <select name="skill_level" id="skill_level" class="form-select">
                <option value="Choose">Choose</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
                <option value="Professional">Professional</option>
            </select>
            <span class="text-danger spanError spanError-skill"></span>
        </div>

        <!-- Contract Start -->
        <div class="col-md-4">
            <label for="contract_start" class="col-form-label-sm">Contract Start</label>
            <input type="date" name="contract_start" class="form-control" id="contract_start" min="<?= date('Y-m-d', strtotime('-30 days')) ?>">
            <small class="text-muted">Cannot be more than 30 days in the past</small>
            <span class="text-danger spanError spanError-contract"></span>
        </div>

         <div class="col-md-4">
            <label for="contract_end" class="col-form-label-sm">Contract End</label>
            <input type="date" name="contract_end" class="form-control" id="contract_end">
            <small class="text-muted">Duration: 6 months to 6 years</small>
            <span class="text-danger spanError spanError-end"></span>
        </div>

        <div class="col-md-4">
            <label for="effid" class="col-form-label-sm">EFF ID</label>
            <input type="text" name="effid" class="form-control" id="effid" placeholder="EFF-18-">
            <span class="text-danger spanError spanError-effid"></span>
        </div>
        
        <div class="col-md-4">
            <label for="effid" class="col-form-label-sm">Files</label>
            <input type="file" name="files" class="form-control" id="files" >
            <span class="text-danger spanError spanError-files"></span>
        </div>

   

                   <!-- </div> -->

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="isRegisterPlayer" id="isRegisterPlayer">Submit</button>
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
  <script src="../dashboard/assets/js/main.js"></script>
  <script src="../dashboard/assets\ajax\jquery-2.2.4.min.js"></script>
  <script src="../dashboard/assets\ajax\jquery.js"></script>
  <script src="../dashboard/assets\ajax\jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {


    // Toggle password visibility
    $(".innershow").on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass("bi-eye bi-eye-slash");
        var passField  = $(".pass-key"); 
        passField.attr("type", passField.attr("type") === "password" ? "text" : "password");
    });

    // Email validation
    function isValidEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|gov|edu)$/i;
        return re.test(String(email).toLowerCase());
    }

    
    // const regexfullname = /^[a-zA-Z ]{2,50}$/;
    function isValidFullName(name) {
        for (let i = 0; i < name.length; i++) {
            const char = name[i];
            if (!(/[a-zA-Z '-]/.test(char))) {  // check each character
                console.log(`Invalid character found: "${char}" at index ${i}`);
                return false;
            }
        }
        return true;
    }

    const regexName = /^[a-zA-Z\s]+$/;

    // ===============================
    // FIELD-BY-FIELD VALIDATIONS
    // ===============================

    $("#name").on('blur keyup', function() {
        var name = $(this).val().trim();
        if (name === '' || name == null) {
            $(this).css("border-color","red");
            $(".spanError-name").html("* This field is required.");
        }else if(!isValidFullName(name)){
          $(this).css("border-color","red");
            $(".spanError-name").html("* Name must be charater.");
        }else {
            $(this).css("border-color","green");
            $(".spanError-name").html('');
        }
    });

    $("#phone").on('blur keyup', function() {
        var phone = $(this).val().trim();
        var phonePattern = /^09[0-9]{8}$/; // Ethiopian phone format: 09 followed by 8 digits
        
        if (phone === '') {
            $(this).css("border-color","red");
            $(".spanError-phone").html("* This field is required.");
        } else if (!phonePattern.test(phone)) {
            $(this).css("border-color","red");
            $(".spanError-phone").html("* Phone must be 10 digits starting with 09 (e.g., 0912345678).");
        } else {
            $(this).css("border-color","green");
            $(".spanError-phone").html('');
        }
    });

    $("#gender").on('change blur', function() {
        var gender = $(this).val();
        if (gender === 'Choose') {
            $(this).css("border-color","red");
            $(".spanError-gender").html("* This field is required.");
        } else {
            $(this).css("border-color","green");
            $(".spanError-gender").html('');
        }
    });

    $("#nationality").on('change blur', function() {
        var nationality = $(this).val();
        if (nationality === 'Choose') {
            $(this).css("border-color","red");
            $(".spanError-nationality").html("* This field is required.");
        } else {
            $(this).css("border-color","green");
            $(".spanError-nationality").html('');
        }
    });

     $("#club_id").on('change blur', function() {
        var club_id = $(this).val();
        if (club_id === 'Choose') {
            $(this).css("border-color","red");
            $(".spanError-club").html("* This field is required.");
        } else {
            $(this).css("border-color","green");
            $(".spanError-club").html('');
        }
    });
    

    $("#date_of_birth").on('blur change', function() {
        var date_of_birth = $(this).val();
        if (date_of_birth === '') {
            $(this).css("border-color","red");
            $(".spanError-date_of_birth").html("* This field is required.");
        } else {
            // Calculate age
            var today = new Date();
            var birthDate = new Date(date_of_birth);
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Adjust age if birthday hasn't occurred this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 17) {
                $(this).css("border-color","red");
                $(".spanError-date_of_birth").html("* Player must be at least 17 years old. Current age: " + age + " years.");
            } else if (age > 45) {
                $(this).css("border-color","red");
                $(".spanError-date_of_birth").html("* Player age cannot exceed 45 years. Current age: " + age + " years.");
            } else {
                $(this).css("border-color","green");
                $(".spanError-date_of_birth").html('');
            }
        }
    });

    $("#email-id").on('blur keyup', function() {
        var email = $(this).val().trim();
        if (email === '') {
            $(this).css("border-color","red");
            $(".spanError-1").html("* This field is required.");
        } else if (!isValidEmail(email)) {
            $(this).css("border-color","red");
            $(".spanError-1").html("* Please enter valid email.");
        } else {
            $(this).css("border-color","green");
            $(".spanError-1").html('');
        }
    });

    // $("#password").on('blur keyup', function() {
    //     var password = $(this).val();
    //     if (password === '') {
    //         $(this).css("border-color","red");
    //         $(".spanError-2").html("* This field is required.");
    //     } else if (password.length < 6) {
    //         $(this).css("border-color","red");
    //         $(".spanError-2").html("* Password must be at least 6 characters.");
    //     } else {
    //         $(this).css("border-color","green");
    //         $(".spanError-2").html('');
    //     }
    // });

     $("#position").on('blur change', function() {
        var position = $(this).val();
        if (position === 'Choose') {
            $(this).css("border-color","red");
            $(".spanError-position").html("* This field is required.");
        } else {
            $(this).css("border-color","green");
            $(".spanError-position").html('');
        }
    });

    $("#height_cm").on('blur change', function() {
        var height_cm = parseFloat($(this).val());
        if ($(this).val() !== '' && (isNaN(height_cm) || height_cm < 1.5)){
          $(this).css("border-color","red");
          $(".spanError-height").html("* Player height must be at least 1.5m.");
        }else {
            $(this).css("border-color","green");
            $(".spanError-height").html('');
        }
    });

       $("#weight_kg").on('blur change', function () {
        let weight = parseFloat($(this).val());

        if ($(this).val() !== '' && isNaN(weight)) {
            $(this).css("border-color", "red");
            $(".spanError-weight").html("* Enter a valid number.");
        } 
        else if ($(this).val() !== '' && weight < 45) {
            $(this).css("border-color", "red");
            $(".spanError-weight").html("* Weight must be at least 45 kg.");
        } 
        else if ($(this).val() !== '' && weight > 120) {
            $(this).css("border-color", "red");
            $(".spanError-weight").html("* Weight must be less than 120 kg.");
        } 
        else {
            $(this).css("border-color", "green");
            $(".spanError-weight").html('');
        }
    });


    $("#preferred_foot").on('blur change', function() {
        var preferred_foot = $(this).val();
        // Optional field - no validation needed, just clear any errors
        $(this).css("border-color","green");
        $(".spanError-preferred_foot").html('');
    });

    $("#experience_years").on('blur change', function() {
        var experience_years = parseInt($(this).val());
        
        if ($(this).val() === '') {
            $(this).css("border-color","orange");
            $(".spanError-experience").html("* Experience is recommended for player profile.");
            return;
        }
        
        if (isNaN(experience_years) || experience_years < 0) {
            $(this).css("border-color","red");
            $(".spanError-experience").html("* Experience must be a positive number.");
            return;
        }
        
        if (experience_years > 20) {
            $(this).css("border-color","red");
            $(".spanError-experience").html("* Experience cannot exceed 20 years.");
            return;
        }
        
        $(this).css("border-color","green");
        $(".spanError-experience").html('');
    });

    $("#skill_level").on('blur change', function() {
        var skill_level = $(this).val();
        // Optional field - no validation needed
        $(this).css("border-color","green");
        $(".spanError-skill").html('');
    });

    $("#contract_start").on('blur change', function() {
        var contract_start = $(this).val();
        var contract_end = $("#contract_end").val();
        
        if (contract_start === '') {
            $(this).css("border-color","orange");
            $(".spanError-contract").html("* Contract start date is recommended.");
            return;
        }
        
        var startDate = new Date(contract_start);
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time to compare dates only
        
        // Check if contract start is in the past (more than 30 days ago)
        var thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        
        if (startDate < thirtyDaysAgo) {
            $(this).css("border-color","red");
            $(".spanError-contract").html("* Contract start date cannot be more than 30 days in the past.");
            return;
        }
        
        // Check contract duration if end date is also provided
        if (contract_end !== '') {
            var endDate = new Date(contract_end);
            var diffTime = Math.abs(endDate - startDate);
            var diffMonths = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 30.44)); // Average days per month
            
            if (endDate <= startDate) {
                $(this).css("border-color","red");
                $(".spanError-contract").html("* Contract start must be before end date.");
                return;
            }
            
            if (diffMonths < 6) {
                $(this).css("border-color","red");
                $(".spanError-contract").html("* Contract duration must be at least 6 months.");
                return;
            }
            
            if (diffMonths > 72) { // 6 years = 72 months
                $(this).css("border-color","red");
                $(".spanError-contract").html("* Contract duration cannot exceed 6 years.");
                return;
            }
        }
        
        $(this).css("border-color","green");
        $(".spanError-contract").html('');
    });

    $("#contract_end").on('blur change', function() {
        var contract_end = $(this).val();
        var contract_start = $("#contract_start").val();
        
        if (contract_end === '') {
            $(this).css("border-color","orange");
            $(".spanError-end").html("* Contract end date is recommended.");
            return;
        }
        
        if (contract_start === '') {
            $(this).css("border-color","red");
            $(".spanError-end").html("* Please set contract start date first.");
            return;
        }
        
        var startDate = new Date(contract_start);
        var endDate = new Date(contract_end);
        var diffTime = Math.abs(endDate - startDate);
        var diffMonths = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 30.44)); // Average days per month
        
        if (endDate <= startDate) {
            $(this).css("border-color","red");
            $(".spanError-end").html("* Contract end must be after start date.");
            return;
        }
        
        if (diffMonths < 6) {
            $(this).css("border-color","red");
            $(".spanError-end").html("* Contract duration must be at least 6 months. Current: " + diffMonths + " months.");
            return;
        }
        
        if (diffMonths > 72) { // 6 years = 72 months
            $(this).css("border-color","red");
            $(".spanError-end").html("* Contract duration cannot exceed 6 years. Current: " + Math.round(diffMonths/12) + " years.");
            return;
        }
        
        $(this).css("border-color","green");
        $(".spanError-end").html("✓ Contract duration: " + diffMonths + " months (" + Math.round(diffMonths/12*10)/10 + " years)");
    });

   $("#effid").on('blur change', function() {
    var effid = $(this).val().trim();
      var pattern = /^EFF-18.+$/; // Must start with EEF-18 and have at least one more character

      if (effid === '') {
          $(this).css("border-color","red");
          $(".spanError-effid").html("* This field is required.");
      } else if (!pattern.test(effid)) {
          $(this).css("border-color","red");
          $(".spanError-effid").html("* Must start with EEF-18 followed by other characters.");
      } else {
          $(this).css("border-color","green");
          $(".spanError-effid").html('');
      }
  });

    // ===============================
    // FINAL VALIDATION ON SUBMIT
    // ===============================
    $("#isRegisterPlayer").on('click', function(event) {

        // Only trigger validation on required fields
        $("#name, #phone, #email-id, #date_of_birth, #gender, #nationality, #club_id, #position, #effid").trigger('blur');
        
        // Also trigger contract validation if dates are provided
        if ($("#contract_start").val() !== '' || $("#contract_end").val() !== '') {
            $("#contract_start, #contract_end").trigger('blur');
        }

        // Check only critical required fields
        if (
            $(".spanError-name").html() ||
            $(".spanError-phone").html() ||
            $(".spanError-1").html() ||
            $(".spanError-date_of_birth").html() ||
            $(".spanError-gender").html() ||
            $(".spanError-nationality").html() ||
            $(".spanError-club").html() ||
            $(".spanError-position").html() ||
            $(".spanError-effid").html() ||
            ($(".spanError-contract").html() && $(".spanError-contract").html().includes('*')) ||
            ($(".spanError-end").html() && $(".spanError-end").html().includes('*'))
        ) {
            event.preventDefault();
            alert("Please fill all required fields correctly and fix any contract validation errors before submitting.");
        }
    });

});
</script>

 <script>

// const avatarWrapper = document.getElementById('avatarWrapper');
// const avatarInput = document.getElementById('avatar');
// const avatarPreview = document.getElementById('avatarPreview');
// const avatarLoader = document.getElementById('avatarLoader');

// // Prevent default drag behaviors
// ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//     avatarWrapper.addEventListener(eventName, (e) => {
//         e.preventDefault();
//         e.stopPropagation();
//     });
// });

// // Highlight on dragover
// avatarWrapper.addEventListener('dragover', () => {
//     avatarWrapper.classList.add('dragover');
// });

// avatarWrapper.addEventListener('dragleave', () => {
//     avatarWrapper.classList.remove('dragover');
// });

// // Handle drop
// avatarWrapper.addEventListener('drop', (e) => {
//     avatarWrapper.classList.remove('dragover');
//     const file = e.dataTransfer.files[0];
//     if (!file) return;
//     uploadAvatar(file);
// });

// // Click to open file dialog
// avatarWrapper.addEventListener('click', () => {
//     avatarInput.click();
// });

// // Handle file selection from input
// avatarInput.addEventListener('change', (e) => {
//     const file = e.target.files[0];
//     if (!file) return;
//     uploadAvatar(file);
// });

// // Function to handle upload & preview
// function uploadAvatar(file) {
//     avatarLoader.style.display = "flex"; // show loader
//     const reader = new FileReader();
//     reader.onload = function() {
//         setTimeout(() => {
//             avatarPreview.src = reader.result;
//             avatarLoader.style.display = "none"; // hide loader
//         }, 800); // simulate preloader delay
//     }
//     reader.readAsDataURL(file);
// }

          

const avatarWrapper = document.getElementById('avatarWrapper');
const avatarInput = document.getElementById('avatar');
const avatarPreview = document.getElementById('avatarPreview');
const avatarLoader = document.getElementById('avatarLoader');
const uploadPercent = document.getElementById('uploadPercent');

// Click to open file selector
avatarWrapper.addEventListener('click', () => avatarInput.click());

// Drag & Drop
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  avatarWrapper.addEventListener(eventName, e => {
    e.preventDefault();
    e.stopPropagation();
  });
});

avatarWrapper.addEventListener('dragover', () => avatarWrapper.classList.add('dragover'));
avatarWrapper.addEventListener('dragleave', () => avatarWrapper.classList.remove('dragover'));

avatarWrapper.addEventListener('drop', (e) => {
  avatarWrapper.classList.remove('dragover');
  const file = e.dataTransfer.files[0];
  if (!file) return;
  uploadImage(file);
});

avatarInput.addEventListener('change', () => {
  const file = avatarInput.files[0];
  if (!file) return;
  uploadImage(file);
});

function uploadImage(file) {
  const reader = new FileReader();
  avatarLoader.style.display = 'flex';
  uploadPercent.innerText = '0%';
  
  reader.onloadstart = () => simulateProgress();
  reader.onload = () => {
    setTimeout(() => {
      avatarPreview.src = reader.result;
      avatarLoader.style.display = 'none';
    }, 1500); // wait till progress finishes
  };
  
  reader.readAsDataURL(file);
}

function simulateProgress() {
  let percent = 0;
  const interval = setInterval(() => {
    percent += Math.floor(Math.random() * 10) + 5;
    if (percent >= 100) {
      percent = 100;
      clearInterval(interval);
    }
    uploadPercent.innerText = percent + '%';
  }, 100);
}

 </script>


</body>

</html>
 