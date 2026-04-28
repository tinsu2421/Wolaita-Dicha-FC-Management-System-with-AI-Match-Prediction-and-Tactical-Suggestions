
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
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/upcomingsection.css"> -->
  <link rel="stylesheet" type="text/css" href="assets\css\loginupdated.css">
</head>

<body class="index-page">

  <main class="main">
  <section id="login" class="login section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row">
      <div class="col-12">
        <div class="login-container">
          <div class="row g-0">

            <!-- Login Form -->
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
              <div class="login-form-section">
                <div class="form-header text-center">
                  <h3>Login to Your Account</h3>
                  <p>Access your account to manage your bookings, profile, or dashboard securely.</p>
                </div>
                <p class="text-danger text-center"><?=$CommonOBJ->Login(); ?></p>
                <form action="" method="post" role="form" class="php-email-form">
                  <div class="row gy-3">
                    <div class="col-12">
                      <input type="email" class="form-control" name="UserEmail" placeholder="Email Address" id="email">
                       <span id="spanError-email" class="text-danger"></span>
                    </div>
                  

                    <div class="col-12">
                      <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="UserPass" placeholder="Password">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                      </div>
                      <span id="spanError-password" class="text-danger"></span>
                    </div>

                  </div>

                  <button type="submit" class="btn-login w-100" id="LoginBtn" name="LoginBtn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login
                  </button>

                  <div class="text-center mt-3">
                    <a href="forgot-password.php?step1">Forgot Password?</a> | 
                    <a href="reg_fans.php?r">Register Us Fans ?</a> |
                    <a href="index.php">Back To Home</a> 
                  </div>
                </form>
              </div>
            </div>

            <!-- Info/Graphic Section -->
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
              <div class="login-info-section">
                <div class="hero-image">
                  <!-- <img src="assets/img/login-showcase.webp" alt="Login Illustration" class="img-fluid"> -->
                  <div class="overlay-content">
                    <h4>Welcome Back!</h4>
                    <p>Log in to continue accessing your account and enjoy seamless service.</p>
                  </div>
                </div>

                <div class="info-cards">
                <div class="row g-3">
                  <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="info-card">
                      <div class="card-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                      </div>
                      <div class="card-content">
                        <h5>Secure Login</h5>
                        <p>Login safely to access your player, coach, and team management data.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6" data-aos="zoom-in" data-aos-delay="450">
                    <div class="info-card">
                      <div class="card-icon">
                        <i class="bi bi-speedometer2"></i>
                      </div>
                      <div class="card-content">
                        <h5>Quick Access</h5>
                        <p>Fast access to team schedules, match stats, and club updates.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
                    <div class="info-card">
                      <div class="card-icon">
                        <i class="bi bi-person-check-fill"></i>
                      </div>
                      <div class="card-content">
                        <h5>Player & Coach Dashboard</h5>
                        <p>View player stats, training schedules, and coaching notes at a glance.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6" data-aos="zoom-in" data-aos-delay="550">
                    <div class="info-card">
                      <div class="card-icon">
                        <i class="bi bi-envelope-fill"></i>
                      </div>
                      <div class="card-content">
                        <h5>Club Support</h5>
                        <p>Contact club management or support staff for assistance anytime.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


                <div class="additional-info" data-aos="fade-up" data-aos-delay="600">
                  <div class="info-highlight">
                    <i class="bi bi-star-fill"></i>
                    <span>Keep your login credentials safe and never share them with others.</span>
                  </div>
                </div>
              </div>
            </div>

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

      // === FINAL CHECK ON BUTTON CLICK ===
      $("#LoginBtn").on("click", function (event) {
          let email = $("#email").val().trim();
          let password = $("#password").val().trim();
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
          if (password === "") {
              $("#spanError-password").html("* This field is required.");
              $("#password").css("border-color", "red");
              valid = false;
          } else if (password.length < 6) {
              $("#spanError-password").html("* Password must be at least 6 characters.");
              $("#password").css("border-color", "red");
              valid = false;
          }

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