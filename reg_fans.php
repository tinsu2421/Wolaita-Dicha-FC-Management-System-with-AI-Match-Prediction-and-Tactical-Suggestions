<?php
// At the TOP of your PHP file
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Wolaita-Dicha-Fc/php_errors.log');

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

<style>
    /* Phone Input Styling - Compact Version */
    .phone-input-wrapper .input-group {
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: stretch;
    }

    .phone-input-wrapper .input-group-text {
        background-color: rgba(0, 123, 255, 0.1);
        border-color: #dee2e6;
        color: #007bff;
        font-weight: 500;
        padding: 0.5rem 0.75rem; /* Reduced padding */
        width: 80px; /* Fixed width */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        border-right: none;
        flex-shrink: 0; /* Prevent shrinking */
    }

    .phone-input-wrapper .input-group-text i {
        font-size: 0.9rem; /* Smaller icon */
        margin-right: 4px;
    }

    .phone-input-wrapper .input-group-text .country-code {
        font-size: 0.9rem; /* Smaller text */
        font-weight: 600;
    }

    .phone-input-wrapper input#phone {
        border-left: none;
        padding-left: 12px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1rem;
        flex: 1; /* Take remaining space */
    }

    .phone-input-wrapper input#phone:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
        z-index: 3;
    }

    .phone-input-wrapper .form-text {
        font-size: 0.75rem;
        margin-top: 4px;
        color: #6c757d !important;
    }

    .phone-input-wrapper .alert-info {
        background-color: rgba(13, 110, 253, 0.1);
        border: 1px solid rgba(13, 110, 253, 0.2);
        font-size: 0.75rem;
        border-radius: 4px;
        padding: 0.5rem;
    }
</style>

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

    <div class="row">
      <div class="col-12">
        <div class="login-container">
          <div class="row g-0">

            <!-- Login Form -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <div class="login-form-section">
                <div class="form-header text-center">
                  <h3>Join the Wolaita Dicha Family! ⚽</h3>
                  <p>Join our exclusive fan community and get access to special events, merchandise discounts, and behind-the-scenes content!</p>
                </div>
                <!-- Replace this line -->
                  <p class="text-danger text-center"><?=$CommonOBJ->isSignUpUsFans(); ?></p>

               
                <form action="" method="post" role="form" class="php-email-form">
                  <div class="row gy-3">

                    <div class="col-md-6">
                      <input type="text" class="form-control" name="fullname" placeholder="Enter Fullname" id="fullname">
                       <span id="spanError-fullname" class="text-danger"></span>
                    </div>


                    <div class="col-md-6">
                      <input type="email" class="form-control" name="UserEmail" placeholder="Email Address" id="email">
                       <span id="spanError-email" class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                      <select id="membership" name="membership" class="form-control">
                            <option value="Choose">Select membership type</option>
                            <option value="digital">Digital Only - Free</option>
                            <option value="standard">Standard - 500 ETB/year (~$19.99)</option>
                            <option value="premium">Premium - 1,250 ETB/year (~$49.99)</option>
                            <option value="vip">VIP - 2,500 ETB/year (~$99.99)</option>
                      </select>
                      <span id="spanError-membership" class="text-danger"></span>
                      <small class="form-text text-muted">
                        <i class="bi bi-info-circle"></i> Paid memberships include exclusive benefits and priority access
                      </small>
                    </div>

                     <div class="col-md-6">
                      <select id="fan_label" name="fan_label" class="form-control">
                            <option value="Choose">Choose Fan Level</option>
                            <option value="Basic Fan">Basic Fan</option>
                            <option value="Super Fan">Super Fan</option>
                            <option value="Ultimate Fan">Ultimate Fan</option>
                      </select>
                      <span id="spanError-fan_label" class="text-danger"></span>
                    </div>

                   <!--  <div class="col-md-6">
                      <div class="password-wrapper">
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                      </div>
                      <span id="spanError-phone" class="text-danger"></span>
                    </div> -->
                  
                   <div class="col-md-6">
                    <div class="phone-input-wrapper">
                        <div class="input-group">
                            <span class="input-group-text" id="phone-prefix">
                                <i class="bi bi-telephone-fill me-1"></i>
                                <span class="country-code">+251</span>
                            </span>
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone" 
                                   name="phone" 
                                   placeholder="9XX XXX XXX"
                                   maxlength="12"
                                   title="Please enter a valid Ethiopian phone number">
                        </div>
                        <small class="form-text text-muted">Format: 9XX XXX XXX (without +251)</small>
                        <span id="spanError-phone" class="text-danger"></span>
                        <div class="phone-format-info d-none mt-2" id="phone-format-info">
                            <div class="alert alert-info p-2 mb-0">
                                <small><i class="bi bi-info-circle me-1"></i> Example: 911 234 567 or 92 345 6789</small>
                            </div>
                        </div>
                    </div>
                </div>



                    <div class="col-12 justify-content-center">
                      <div class="g-recaptcha mb-3" data-sitekey="6LfZrhAsAAAAAAZPevXZ77ncugyfewxyrbKKwkd1" style="max-width: 1200px;"></div>
                      <span id="captchaError" style="font-size:13px;color:red; margin-bottom: 50px;"></span>
                    </div>
                      

                  </div>

                  <button type="submit" class="btn-login w-100" id="SignUpUsFans" name="isSignUpUsFans">
                    <i class="bi bi-person-check me-2"></i>
                    Become a Fan Member
                  </button>

                  <div class="text-center mt-3">
                    <a href="forgot-password.php?step1">Forgot Password?</a> | 
                    <a href="pages_login.php?login">Login ?</a> |
                    <a href="index.php">Back To Home</a> 
                  </div>
                </form>
              </div>
            </div>

            <!-- Info/Graphic Section -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
              <div class="login-info-section">
                <div class="hero-image">
                  <!-- <img src="assets/img/login-showcase.webp" alt="Login Illustration" class="img-fluid"> -->
                  <div class="overlay-content">
                    <h4>Fan Registration Form</h4>
                    <p>Join our exclusive fan community and get access to special events, merchandise discounts, and behind-the-scenes content!</p>
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
                        <p>Early access to event tickets, Exclusive merchandise & discounts</p>
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
                        <p>Behind-the-scenes content</p>
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
                        <p>Private fan community access</p>
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
                        <p>Special birthday surprises</p>
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

  <script>


    $(document).ready(function () {
    // Email regex function
    function isValidEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|gov|edu)$/i;
        return re.test(String(email).toLowerCase());
    }
    
    // Name validation regex
    const regexName = /^[a-zA-Z\s]+$/; // letters and spaces only
    
    // Phone number validation function
    function isValidEthiopianPhone(phone) {
        // Remove spaces and check if it's 9 digits starting with 9
        const cleanedPhone = phone.replace(/\s+/g, '');
        const ethPhoneRegex = /^9[0-9]{8}$/;
        return ethPhoneRegex.test(cleanedPhone);
    }
    
    // Phone number formatting function
    function formatPhoneNumber(phone) {
        // Remove all non-digit characters
        let cleaned = phone.replace(/\D/g, '');
        
        // Ethiopian phone format: 9XX XXX XXX
        if (cleaned.length <= 3) {
            return cleaned;
        } else if (cleaned.length <= 6) {
            return cleaned.substring(0, 3) + ' ' + cleaned.substring(3);
        } else {
            return cleaned.substring(0, 3) + ' ' + cleaned.substring(3, 6) + ' ' + cleaned.substring(6, 9);
        }
    }

    // reCAPTCHA validation
    function validateRecaptcha() {
        let recaptchaResponse = grecaptcha.getResponse();
        if (recaptchaResponse.length === 0) {
            $("#captchaError").html("🚨 Please complete the reCAPTCHA verification.");
            return false;
        } else {
            $("#captchaError").html("");
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

    $("#fan_label").on("change blur", function () {
        let fan_label = $(this).val().trim();
        if (fan_label === "Choose" || fan_label === "") {
            $("#spanError-fan_label").html("* This field is required.");
            $("#fan_label").css("border-color", "red");
        } else {
            $("#spanError-fan_label").html("");
            $("#fan_label").css("border-color", "green");
        }
    });

    $("#membership").on("change blur", function () {
        let membership = $(this).val().trim();
        if (membership === "Choose" || membership === "") {
            $("#spanError-membership").html("* This field is required.");
            $("#membership").css("border-color", "red");
        } else {
            $("#spanError-membership").html("");
            $("#membership").css("border-color", "green");
        }
    });

    $("#fullname").on("blur keyup", function () {
        let fullname = $(this).val().trim();
        if (fullname === "") {
            $("#spanError-fullname").html("* This field is required.");
            $("#fullname").css("border-color", "red");
        } else if (!regexName.test(fullname)) {
            $(this).css("border-color", "red");
            $("#spanError-fullname").html("* Please enter a valid fullname (letters only).");
        } else {
            $("#spanError-fullname").html("");
            $("#fullname").css("border-color", "green");
        }
    });

    $("#phone").on("blur keyup input", function () {
        let phone = $(this).val().trim();
        let cleanedPhone = phone.replace(/\s+/g, '');
        
        // Auto-format the phone number as user types
        if (phone.length > 0 && /\d/.test(phone)) {
            let formatted = formatPhoneNumber(phone);
            if (formatted !== phone) {
                $(this).val(formatted);
            }
        }
        
        if (phone === "") {
            $("#spanError-phone").html("* This field is required.");
            $(this).css("border-color", "red");
            $("#phone-format-info").addClass('d-none');
        } else if (!isValidEthiopianPhone(phone)) {
            $("#spanError-phone").html("* Please enter a valid Ethiopian phone number (9XXXXXXXX).");
            $(this).css("border-color", "red");
            $("#phone-format-info").removeClass('d-none');
        } else {
            $("#spanError-phone").html("");
            $(this).css("border-color", "green");
            $("#phone-format-info").addClass('d-none');
        }
    });

    // Auto-format phone number while typing
    $("#phone").on("input", function () {
        let phone = $(this).val().replace(/\D/g, '');
        let formatted = formatPhoneNumber(phone);
        $(this).val(formatted);
    });

    // Show format info when phone field is focused
    $("#phone").on("focus", function () {
        let phone = $(this).val().trim().replace(/\s+/g, '');
        if (phone === "" || !isValidEthiopianPhone(phone)) {
            $("#phone-format-info").removeClass('d-none');
        }
    });



    // === FINAL CHECK ON BUTTON CLICK ===
    $("#SignUpUsFans").on("click", function (event) {
        let email = $("#email").val().trim();
        let fullname = $("#fullname").val().trim();
        let fan_label = $("#fan_label").val().trim();
        let membership = $("#membership").val().trim();
        let phone = $("#phone").val().trim();
        let valid = true;

        // Reset errors
        $('[id^="spanError-"]').html('');
        $('.form-control').css('border-color', '#ced4da');
        $('.input-group-text').css('border-color', '#ced4da');

        // Fullname final check
        if (fullname === "") {
            $("#spanError-fullname").html("* This field is required.");
            $("#fullname").css("border-color", "red");
            valid = false;
        } else if (!regexName.test(fullname)) {
            $("#fullname").css("border-color", "red");
            $("#spanError-fullname").html("* Please enter a valid fullname (letters only).");
            valid = false;
        }

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

        // Membership final check
        if (membership === "Choose" || membership === "") {
            $("#spanError-membership").html("* This field is required.");
            $("#membership").css("border-color", "red");
            valid = false;
        }

        // Fan label final check
        if (fan_label === "Choose" || fan_label === "") {
            $("#spanError-fan_label").html("* This field is required.");
            $("#fan_label").css("border-color", "red");
            valid = false;
        }

        // Phone final check
        if (phone === "") {
            $("#spanError-phone").html("* This field is required.");
            $("#phone").css("border-color", "red");
            valid = false;
        } else if (!isValidEthiopianPhone(phone)) {
            $("#spanError-phone").html("* Please enter a valid Ethiopian phone number (9XXXXXXXX).");
            $("#phone").css("border-color", "red");
            valid = false;
        }

        // Password final check - REMOVED

        // reCAPTCHA validation
        if (!validateRecaptcha()) {
            valid = false;
        }

        // Stop submit if invalid
        if (!valid) {
            event.preventDefault();
            // Scroll to first error
            // const firstError = $('[id^="spanError-"]:not(:empty)').first();
            // if (firstError.length) {
            //     $('html, body').animate({
            //         scrollTop: firstError.offset().top - 100
            //     }, 500);
            // }
        } 
        // else {
        //     // Show loading state on button
        //     $(this).html('<i class="bi bi-hourglass-split me-2"></i>Processing...');
        //     $(this).prop('disabled', true);
        //     // Form will submit normally (no preventDefault called)
        // }
    });

    // Reset button state if form validation fails and user corrects errors
    $('.form-control').on('input change', function() {
        // Re-enable button if it was disabled
        if ($("#SignUpUsFans").prop('disabled')) {
            $("#SignUpUsFans").html('<i class="bi bi-person-check me-2"></i>Become a Fan Member');
            $("#SignUpUsFans").prop('disabled', false);
        }
    });
});
  </script>




</body>

</html>