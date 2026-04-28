
<?php
  // require __DIR__.'../CommonFunction/CommenForEveryUserFunction.php';
  require __DIR__.'\Auth\auth.php';
  $CommonOBJ = new Auth();
  session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Wolaita Dicha SC – Login</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="assets/img/dichaLogo.jpg" rel="icon">
  <link href="assets/img/dichaLogo.jpg" rel="apple-touch-icon">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Source+Serif+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <!-- <link href="assets/css/login.css" rel="stylesheet"> -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/upcomingsection.css"> -->
  <link rel="stylesheet" type="text/css" href="assets\css\loginupdated.css">
</head>

<body class="index-page">

  <main class="main">
  <section id="login" class="login section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row mt-7">
      <div class="col-12">
        <div class="login-container">
          <div class="row g-0">
            <div class="col-lg-3"></div>
            <?php if(isset($_GET['step1'])) {?>
            <!-- Login Form -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <div class="login-form-section">
                <div class="form-header text-center">
                  <h3> Send Email to get OTP! <span class="hand-wave">👋</span></h3>
                  <p>Access your account to manage your bookings, profile, or dashboard securely.</p>
                </div>
                <p class="text-danger text-center"><?=$CommonOBJ->ForgetPassword(); ?></p>
                <form action="" method="post" role="form" class="php-email-form">
                  <div class="row gy-3">
                    <div class="col-12 mb-3">
                      <input type="email" class="form-control" name="UserEmail" placeholder="Email Address" id="email">
                       <span id="spanError-email" class="text-danger"></span>
                    </div>
                  

                    <!-- <div class="col-12">
                      <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="UserPass" placeholder="Password">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                      </div>
                      <span id="spanError-password" class="text-danger"></span>
                    </div> -->

                  <!--   <div class="col-12 justify-content-center">
                      <div class="g-recaptcha mb-3" data-sitekey="6LfZrhAsAAAAAAZPevXZ77ncugyfewxyrbKKwkd1" style="max-width: 1200px;"></div>
                      <span id="captchaError" style="font-size:13px;color:red; margin-bottom: 50px;"></span>
                    </div>
                       -->

                  </div>

                  <button type="submit" class="btn-login w-100" id="sendEmail" name="sendEmail">
                      <i class="bi bi-envelope-fill me-2"></i>
                      Send Email
                  </button>

                  <div class="text-center mt-3">
                    <a href="forgot-password.php?step1">Forgot Password?</a> | 
                    <a href="reg_fans.php?r">Register Us Fans ?</a> |
                    <a href="index.php">Back To Home</a> 
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>

           <?php if(isset($_GET['step2'])) {?>
            <!-- Login Form -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <div class="login-form-section">
                <div class="form-header text-center">
                  <h3> Enter OTP Number! <span class="hand-wave">👋</span></h3>
                  <p>Access your account to manage your bookings, profile, or dashboard securely.</p>
                </div>
                <p class="text-danger text-center"><?=$CommonOBJ->sendOTP(); ?></p>
                <form action="" method="post" role="form" class="php-email-form">
                  <div class="row gy-3">
                  <!--   <div class="col-12 mb-3">
                      <input type="email" class="form-control" name="UserEmail" placeholder="Email Address" id="email">
                       <span id="spanError-email" class="text-danger"></span>
                    </div> -->

                <div class="col-12 mb-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="otp" placeholder="የአንድ ጊዜ የይለፍ ቃል ኮድ ያስገቡ*" id="otp">
                        <input type="hidden" name="UserEmail" class="form-control" id="email" value="<?=$_GET['email']; ?>">
                    </div>
                    <span id="spanError-otp" class="text-danger" style="font-size: 13px;"></span>
                  
                </div>
                  

                    <!-- <div class="col-12">
                      <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="UserPass" placeholder="Password">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                      </div>
                      <span id="spanError-password" class="text-danger"></span>
                    </div> -->

                  <!--   <div class="col-12 justify-content-center">
                      <div class="g-recaptcha mb-3" data-sitekey="6LfZrhAsAAAAAAZPevXZ77ncugyfewxyrbKKwkd1" style="max-width: 1200px;"></div>
                      <span id="captchaError" style="font-size:13px;color:red; margin-bottom: 50px;"></span>
                    </div>
                       -->

                  </div>

                  <button type="submit" class="btn-login w-100" id="sendOTP" name="sendOTP">
                      <i class="bi bi-envelope-fill me-2"></i>
                      Send OTP Code
                  </button>

                  <div class="text-center mt-3">
                    <a href="forgot-password.php?step1">Forgot Password?</a> | 
                    <a href="reg_fans.php?r">Register Us Fans ?</a> |
                    <a href="index.php">Back To Home</a> 
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>

           <?php if(isset($_GET['step3'])) {?>
            <!-- Login Form -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <div class="login-form-section">
                <div class="form-header text-center">
                 <h3 class="text-center mb-4" style="color:#204060;">
               Change Password <span class="hand-wave">👋</span>
            </h3>
                  <p>Access your account to manage your bookings, profile, or dashboard securely.</p>
                </div>
                <p class="text-danger text-center"><?=$CommonOBJ->isChangePasswordAuth(); ?></p>
                <form action="" method="post" role="form" class="php-email-form">
                  <div class="row gy-3">
                
<!-- 
                <div class="col-12 mb-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="otp" placeholder="የአንድ ጊዜ የይለፍ ቃል ኮድ ያስገቡ*" id="otp">
                        
                    </div>
                    <span id="spanError-otp" class="text-danger" style="font-size: 13px;"></span>
                  
                </div> -->


                  
                <input type="hidden" name="UserEmail" class="form-control" id="email" value="<?=$_GET['email']; ?>">

                    <div class="col-12">
                      <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="newpassword" placeholder="አዲስ የይለፍ ቃል ያስገቡ።">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                      </div>
                      <span id="spanError-password" class="text-danger"></span>
                    </div>

                     <div class="col-12 mb-3">
                      <div class="password-wrapper">
                        <input type="password" class="form-control" id="conpassword" name="conpassword" placeholder="የማረጋገጫ ይለፍ ቃል ያስገቡ።">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                      </div>
                      <span id="spanError-conpassword" class="text-danger"></span>
                    </div>

                  <!--   <div class="col-12 justify-content-center">
                      <div class="g-recaptcha mb-3" data-sitekey="6LfZrhAsAAAAAAZPevXZ77ncugyfewxyrbKKwkd1" style="max-width: 1200px;"></div>
                      <span id="captchaError" style="font-size:13px;color:red; margin-bottom: 50px;"></span>
                    </div>
                       -->

                  </div>

                 <button type="submit" class="btn-login w-100" id="isChangePassword" name="isChangePassword">
                    <i class="bi bi-key-fill me-2"></i>
                    Change Password
                </button>

                  <div class="text-center mt-3">
                    <a href="forgot-password.php?step1">Forgot Password?</a> | 
                    <a href="reg_fans.php?r">Register Us Fans ?</a> |
                    <a href="index.php">Back To Home</a> 
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
           

          </div>
        </div>
      </div>
    </div>

  </div>

</section><!-- /Login Section -->


  </main>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="ajax\jquery-2.2.4.min.js"></script>
  <script src="ajax\jquery.js"></script>
  <script src="ajax\jquery.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function () {

      

      // Email regex function
      function isValidEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|gov|edu)$/i;
        return re.test(String(email).toLowerCase());
      }


      // Add this new function inside your document.ready block
      function validateRecaptcha() {
          // grecaptcha is globally available because of the script tag you included
          let recaptchaResponse = grecaptcha.getResponse(); 

          if (recaptchaResponse.length === 0) {
              $("#captchaError").html("🚨 Please complete the reCAPTCHA verification.");
              // Note: The reCAPTCHA widget itself can't easily be styled with a red border, 
              // but we highlight the error message.
              return false;
          } else {
              $("#captchaError").html(""); // Clear the error message
              return true;
          }
      }


      // === INLINE VALIDATION ===
      $("#email").on("blur keyup", function () {
          let email = $(this).val().trim();
          if (email === "") {
              $("#spanError-email").html("* This field is required.");
              $("#email").css("border-color", "red");
          } else if (!isValidEmail(email)) {
              $("#spanError-email").html("* Please enter valid email.");
              $("#email").css("border-color", "red");
          } else {
              $("#spanError-email").html("");
              $("#email").css("border-color", "green");
          }
      });

      $("#otp").on("blur keyup", function () {
          let otp = $(this).val().trim();
          if (otp === "") {
              $("#spanError-otp").html("* This field is required.");
              $("#otp").css("border-color", "red");
          } else if (otp.length < 4) {
              $("#spanError-otp").html("* otp must be at least 4 characters.");
              $("#otp").css("border-color", "red");
          } else {
              $("#spanError-otp").html("");
              $("#otp").css("border-color", "green");
          }
      });

      $("#password").on("blur keyup", function () {
          let password = $(this).val().trim();
          if (password === "") {
              $("#spanError-password").html("* This field is required.");
              $("#password").css("border-color", "red");
          } else if (password.length < 6) {
              $("#spanError-password").html("* Password must be at least 6 characters.");
              $("#password").css("border-color", "red");
          } else {
              $("#spanError-password").html("");
              $("#password").css("border-color", "green");
          }
      });

       $("#conpassword").on("blur keyup", function () {
          let conpassword = $(this).val().trim();
          if (conpassword === "") {
              $("#spanError-conpassword").html("* This field is required.");
              $("#conpassword").css("border-color", "red");
          } else if (conpassword.length < 6) {
              $("#spanError-conpassword").html("* conpassword must be at least 6 characters.");
              $("#conpassword").css("border-color", "red");
          } else {
              $("#spanError-conpassword").html("");
              $("#conpassword").css("border-color", "green");
          }
      });

       // === FINAL CHECK ON BUTTON CLICK ===
      $("#isChangePassword").on("click", function (event) {
          // let password = $("#password").val().trim();
          let password = $("#password").val().trim();
          let conpassword = $("#conpassword").val().trim();
          let valid = true;

         
          // Password final check
          if (password === "") {
              $("#spanError-password").html("* This field is required.");
              $("#password").css("border-color", "red");
              valid = false;
          } else if (password.length < 6) {
              $("#spanError-password").html("* Password must be at least 6 characters.");
              $("#password").css("border-color", "red");
              valid = false;
          }

          // Password final check
          if (conpassword === "") {
              $("#spanError-conpassword").html("* This field is required.");
              $("#conpassword").css("border-color", "red");
              valid = false;
          } else if (conpassword.length < 6) {
              $("#spanError-conpassword").html("* con password must be at least 6 characters.");
              $("#conpassword").css("border-color", "red");
              valid = false;
          }

          // Stop submit if invalid
          if (!valid) {
              event.preventDefault();
          }

          
      });


      // === FINAL CHECK ON BUTTON CLICK ===
      $("#sendEmail").on("click", function (event) {
          let email = $("#email").val().trim();
          // let password = $("#password").val().trim();
          let valid = true;

          // Email final check
          if (email === "") {
              $("#spanError-email").html("* This field is required.");
              $("#email").css("border-color", "red");
              valid = false;
          } else if (!isValidEmail(email)) {
              $("#spanError-email").html("* Please enter valid email.");
              $("#email").css("border-color", "red");
              valid = false;
          }

          // Password final check
          // if (password === "") {
          //     $("#spanError-password").html("* This field is required.");
          //     $("#password").css("border-color", "red");
          //     valid = false;
          // } else if (password.length < 6) {
          //     $("#spanError-password").html("* Password must be at least 6 characters.");
          //     $("#password").css("border-color", "red");
          //     valid = false;
          // }

          // Stop submit if invalid
          if (!valid) {
              event.preventDefault();
          }

          
      });

      // === FINAL CHECK ON BUTTON CLICK ===
      $("#sendOTP").on("click", function (event) {
          let otp = $("#otp").val().trim();
          // let password = $("#password").val().trim();
          let valid = true;

          // Email final check
          if (otp === "") {
              $("#spanError-otp").html("* This field is required.");
              $("#otp").css("border-color", "red");
              valid = false;
          }

          // Password final check
          // if (password === "") {
          //     $("#spanError-password").html("* This field is required.");
          //     $("#password").css("border-color", "red");
          //     valid = false;
          // } else if (password.length < 6) {
          //     $("#spanError-password").html("* Password must be at least 6 characters.");
          //     $("#password").css("border-color", "red");
          //     valid = false;
          // }

          // Stop submit if invalid
          if (!valid) {
              event.preventDefault();
          }

          
      });

  });
  </script>


  <script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function () {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // toggle the icon
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
</script>

</body>

</html>