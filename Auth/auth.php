

<?php 

 // Authentication Class
  
require __DIR__.'/../Configuration/Dbconfig.php';
// use mailer class..
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

error_reporting(0);

// Include all php class file

include 'MailerSrc/PHPMailer/src/Exception.php';
include 'MailerSrc/PHPMailer/src/SMTP.php';
include 'MailerSrc/PHPMailer/src/PHPMailer.php';
include 'MailerSrc/PHPMailer/constant.php'; 


// error_reporting(0 );

 /**
  * Auth
  */
 class Auth extends Database{


    public function submitubject() {

    try {

        if (isset($_POST['SubmitContacQuery'])) {

            $name    = $_POST['name'];
            $email   = $_POST['email'];
            $message = $_POST['message'];

            $sqlQuery = $this->conn->prepare("
                INSERT INTO contact_messages (full_name, email, message)
                VALUES (?, ?, ?)
            ");

            $sqlQuery->execute([
                $name,
                $email,
                $message
            ]);

            return "Message sent successfully.";
        }

    } catch (Exception $e) {
        return $e->getMessage();
    }
}



    public function isChangePasswordAuth(){
        // code...
        if (isset($_POST['isChangePassword'])) {
            $cpassword = $_POST['conpassword'];
            $hashCpassword = sha1($_POST['conpassword']);
            $email = $_POST['UserEmail'];
            $npassword = $_POST['newpassword'];
            $hashNpassword = sha1($_POST['newpassword']);
        if(empty($npassword) || empty($cpassword)){
          return "Error : This field is required.";
        }

            if ($cpassword != $npassword) {
                // code...
                return "<div class='alert alert-danger' role='alert'> <i class='bi bi-exclamation-triangle-fill me-2'></i> New and Confirm password does not matched.</div>";
            }else{
                $sqlQuery = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_account` SET `password` = '$hashCpassword' WHERE `email` = '$email'");
                $sqlQuery->execute();
                return "<div class='alert alert-success' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Password changed successfully.</div>";
            }
        }
    }


            // sendOTP
    public function sendOTP(){
        // code...
        if (isset($_POST['sendOTP'])) {
            // code...
            $otp = $_POST['otp'];
            $email = $_POST['UserEmail'];
            // return $email;
            $sqlQuery = $this->conn->prepare("SELECT * FROM `wolaita_dichafcdb`.`user_account` WHERE `email` = '$email' ");
            $sqlQuery->execute();
            $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultQ as $key => $value) {
                // code...
                $otpDb = $value['otp'];
            }
            // return $otpDb;
            if ($otp == $otpDb) {
                // code...
                return "<script>window.location='forgot-password.php?step3&url&email=".$email."';</script>";
            }else{
                // return "Error : Invalid OTP Verfication Number.";
                return "<div class='alert alert-warning' role='alert'> <i class='bi bi-exclamation-triangle-fill me-2'></i> Invalid OTP Verfication Number.</div>"; 
            }
        }
    }

         // ForgetPassword
    public function ForgetPassword(){
      // code...
      if (isset($_POST['sendEmail'])) {
        // code...
        $email = $_POST['UserEmail'];
        // return $email;
        $sqlQuery = $this->conn->prepare("SELECT * FROM `wolaita_dichafcdb`.`user_account` WHERE `email` = '$email' ");
        $sqlQuery->execute();
        $rowQ = $sqlQuery->rowCount();
        if($rowQ == 0) return "Error : Email not found.";

        $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
          foreach ($resultQ as $key => $value) {
              // code...
              $name = $value['username'];
          }

        // return $name;
          try {
            
            $this->conn->beginTransaction();
            $randOtp = rand(100000,999999);
            $sqlQuery = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_account` SET `otp` = '$randOtp' WHERE `email` = '$email'");
            if ($sqlQuery->execute()) {
              // code...
              $mail = new PHPMailer(true);
                // Server Setting..
              $mail->SMTPDebug = 0;
              $mail->isSMTP();
              $mail->Host = 'smtp.gmail.com';
              $mail->SMTPAuth = true;
              $mail->Username = EMAIL;
              $mail->Password = PASSWORD;
              $mail->SMTPSecure = 'ssl';
              $mail->Port = 465;

              $mail->setFrom(EMAIL, ' Wolaita Dicha FC');
              $mail->addAddress($email,'Unknown');
              $mail->isHTML(true);
              $mail->Subject = "Hi '$email' This is your password verification code.";

              $mail->Body = '<div class="row">
                  <div class="col-xl-4 col-md-6 col-sm-12">
                      <div class="card">
                          <div class="card-content">
                              <div class="card-body">
                                  <h4 class="card-title">Wolaita Dicha FC</h4>
                                 


                                  <p class="card-text">
                                      Dear Customer the requested otp is<b> '.$randOtp.'</b> Password reset has been requested again..
                                  </p>

                                   <p class="card-text">
                                        Yours,<br>
                                        Rediet tesfaye - System Adminstrator/Software Developer
                                  </p>
                              </div>
                              
                          </div>
                         
                      </div>
                      </div>
                      </div>
              ';

              $mail->AltBody = 'This is your otp number';
                  $mail->SMTPOptions = array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                  )
              );
              if ($mail->send()) {
                // code...
                $this->conn->commit();
                return "<script>window.location='forgot-password.php?step2&url&email=".$email."';</script>";
              }else{
                return "Error : Mailer Class Error try again.";
              }

            }else{
              return "Error : Check the maria DB.";
            }


            $this->conn->commit();
          } catch (PDOException $e) {
            if ($this->conn->inTransaction()) $this->conn->rollBack(); return "Error : Query rollBack...!";
            
          }

      }
    }

    // isSignUpUsFans with Payment Integration
    public function isSignUpUsFans(){
        // code...
        define('RECAPTCHA_SECRET_KEY', '6LfZrhAsAAAAAAq6Lr4Q9LuU0dWW7N1_ZTOcWnvk');
        if (isset($_POST['isSignUpUsFans'])) {
            // code...
            
            // Verify reCAPTCHA
            $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
            
            if (empty($recaptcha_response)) {
                return "ERROR: Please check the 'I'm not a robot' box.";
            }
            
            // Verify with Google
            $verification_url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => RECAPTCHA_SECRET_KEY,
                'response' => $recaptcha_response
            ];
            
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];
            $context  = stream_context_create($options);
            $result = file_get_contents($verification_url, false, $context);
            $result_json = json_decode($result);
            
            if ($result_json === null || $result_json === false || !$result_json->success) {
                return "ERROR: reCAPTCHA verification failed. Please try again.";
            }
            
            $fullname = $_POST['fullname'];
            $UserEmail = $_POST['UserEmail'];
            $membership = $_POST['membership'];
            $fan_label = $_POST['fan_label'];
            $phone = $_POST['phone'];
            
            // Auto-generate a secure password
            $UserPass = 'WD' . rand(100000, 999999); // Generate password like WD123456
            $password = sha1($UserPass); // Hash the password for storage

            // Check email and phone recently in use ...
            $sqlQuery = $this->conn->prepare("
                SELECT * FROM `wolaita_dichafcdb`.`fans`
                WHERE `phone` = ? || `email` = ?
            ");
            $sqlQuery->execute([
                $phone,
                $UserEmail
            ]);
            $rowQ = $sqlQuery->rowCount();
            if ($rowQ > 0) return "<div class='alert alert-warning' role='alert'> <i class='bi bi-exclamation-triangle-fill me-2'></i> Email or phone number in use..</div>"; 

            // Check if payment is required
            $membership_prices = [
                'digital' => 0,      // Free
                'standard' => 500,   // 500 ETB (~$19.99)
                'premium' => 1250,   // 1250 ETB (~$49.99)
                'vip' => 2500        // 2500 ETB (~$99.99)
            ];
            
            $amount = $membership_prices[$membership] ?? 0;
            error_log("Membership: $membership, Amount: $amount");
            
            if ($amount > 0) {
                // Payment required - store data in session and redirect to payment method selection
                $_SESSION['pending_registration'] = [
                    'fullname' => $fullname,
                    'email' => $UserEmail,
                    'phone' => $phone,
                    'password' => $password,
                    'membership' => $membership,
                    'fan_label' => $fan_label
                ];
                
                error_log("Redirecting to payment selection for amount: $amount");
                return "<script>window.location.href='payment_method_selection.php';</script>";
                
            } else {
                error_log("Free membership, proceeding with direct registration");
                // Free membership - proceed with registration
                // Free membership - proceed with registration
                try {
                    $this->conn->beginTransaction();
                    
                    // Insert fan registration
                    $sqlQuery = $this->conn->prepare("
                        INSERT INTO `fans`(`full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `is_verified`, `status`, `payment_status`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");

                    $sqlQuery->execute([
                        $fullname,
                        $UserEmail,
                        $phone,
                        $password,
                        $membership,
                        $fan_label,
                        0,
                        0,
                        'free'
                    ]);

                    // Log email attempt
                    error_log("Attempting to send email to: " . $UserEmail);

                    // Send congratulation email
                    $mail = new PHPMailer(true);
                    
                    // Server Setting..
                    $mail->SMTPDebug = 0; // Set to 2 for debugging
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = EMAIL;
                    $mail->Password = PASSWORD;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom(EMAIL, 'Wolaita Dicha FC');
                    $mail->addAddress($UserEmail, $fullname);
                    $mail->isHTML(true);
                    $mail->Subject = "🎉 Welcome to Wolaita Dicha FC Fan Community!";


                    $mail->Body = '
                    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; padding: 20px;">
                        <div style="background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            
                            <!-- Header with Logo -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h1 style="color: #204060; margin: 0; font-size: 28px;">🎉 Welcome to Wolaita Dicha FC!</h1>
                                <p style="color: #666; font-size: 16px; margin: 10px 0 0 0;">The Bees of Tona Family</p>
                            </div>

                            <!-- Welcome Message -->
                            <div style="background: linear-gradient(135deg, #204060, #3a6b8c); color: white; padding: 25px; border-radius: 8px; margin-bottom: 25px;">
                                <h2 style="margin: 0 0 15px 0; font-size: 24px;">🏆 Congratulations, ' . htmlspecialchars($fullname) . '!</h2>
                                <p style="margin: 0; font-size: 16px; line-height: 1.5;">
                                    You have successfully joined the Wolaita Dicha FC fan community! Welcome to our family!
                                </p>
                            </div>

                            <!-- Footer -->
                            <div style="text-align: center; padding-top: 20px; border-top: 1px solid #dee2e6;">
                                <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">
                                    Thank you for joining the Wolaita Dicha FC family!
                                </p>
                                <p style="color: #666; font-size: 14px; margin: 0;">
                                    <strong>የጦና ንቦች - The Bees of Tona</strong><br>
                                    <em>Passion. Pride. Wolaita Dicha.</em>
                                </p>
                            </div>

                        </div>
                    </div>';

                    $mail->AltBody = "Congratulations $fullname! You have successfully joined the Wolaita Dicha FC fan community. Welcome to our family!";
                    
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    // Try to send email
                    $emailSent = false;
                    $emailError = "";
                    
                    try {
                        $emailSent = $mail->send();
                        error_log("Email sent successfully to: " . $UserEmail);
                    } catch (Exception $emailException) {
                        $emailError = $emailException->getMessage();
                        error_log("Email failed: " . $emailError);
                    }

                    if ($emailSent) {
                        $this->conn->commit();
                        return "<div class='alert alert-success' role='alert'> 
                                    <i class='bi bi-check-circle-fill me-2'></i> 
                                    🎉 Congratulations! Your fan registration was successful. Welcome to the Wolaita Dicha FC family!
                                </div>";
                    } else {
                        $this->conn->commit(); // Still commit the registration even if email fails
                        return "<div class='alert alert-success' role='alert'> 
                                    <i class='bi bi-check-circle-fill me-2'></i> 
                                    🎉 Congratulations! Your fan registration was successful. Welcome to the Wolaita Dicha FC family!
                                </div>";
                    }

                } catch (Exception $e) {
                    if ($this->conn->inTransaction()) {
                        $this->conn->rollBack();
                    }
                    error_log("Registration error: " . $e->getMessage());
                    return "<div class='alert alert-danger' role='alert'> 
                                <i class='bi bi-exclamation-triangle-fill me-2'></i> 
                                Registration failed. Please try again.
                            </div>";
                }
            }
        }
    }

    // SignUpUsFans
    public function SignUpUsFans(){
        // code...
        define('RECAPTCHA_SECRET_KEY', '6LfZrhAsAAAAAAq6Lr4Q9LuU0dWW7N1_ZTOcWnvk');
        if (isset($_POST['SignUpUsFans'])) {
            // code...
            $fullname = $_POST['fullname'];
            $UserEmail = $_POST['UserEmail'];
            $membership = $_POST['membership'];
            $fan_label = $_POST['fan_label'];
            $UserPass = $_POST['UserPass'];
            $phone = $_POST['phone'];

            return $fullname;

            // Check email and phone recently in use ...
            $sqlQuery = $this->conn->prepare("
                SELECT * FROM `wolaita_dichafcdb`.`fans`
                WHERE `phone` = ? || `email` = ?
            ");
            $sqlQuery->execute([
                $phone,
                $UserEmail
            ]);
            $sqlQuery->rowCount();
            if ($sqlQuery > 0) return "<div class='alert alert-warning' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Email or phone number in use..</div>";  

            else return "<div class='alert alert-success' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> successfully.</div>";
            // INSERT INTO `fans`(`id`, `full_name`, `username`, `email`, `phone`, `password`, `dob`, `gender`, `address`, `profile_image`, `favorite_team`, `membership_type`, `fan_label`, `is_verified`, `status`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]')
        }
    }

      // fetchUserList
    public function getUpCompingMatch() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.club_upcoming_matches  ");
            $sqlQuery->execute();

            $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            // Return empty array if no users found
            return $resultQ ?: [];

        } catch (PDOException $e) {
            // Log error and return empty array
            error_log("Error fetching user list: " . $e->getMessage());
            return [];
        }
    }
    
     // fetchUserList
    public function getMatchResult() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.club_match_results  ");
            $sqlQuery->execute();

            $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            // Return empty array if no users found
            return $resultQ ?: [];

        } catch (PDOException $e) {
            // Log error and return empty array
            error_log("Error fetching user list: " . $e->getMessage());
            return [];
        }
    }
    
    // Login or Logger Class
    public function Login(){
        // code...
        if (isset($_POST['LoginBtn'])) {
            // code...
            $UserEmail = $_POST['UserEmail'];
            $UserPass = sha1($_POST['UserPass']); // shal1 function for encryption leencryption
            // return $UserEmail;

            $attemptType = 'login'; // or 'password_reset', 'otp', 'other'
            $status = 'failed'; // or 'success'
            $message = 'Incorrect password'; // optional description 
            $ipAddress = $_SERVER['REMOTE_ADDR'];

            // If IPv6 localhost (::1), convert to 127.0.0.1 for consistency
            if ($ipAddress == '::1') {
                $ipAddress = '127.0.0.1';
            }

              // Detect device name (from browser)
              $userAgent = $_SERVER['HTTP_USER_AGENT'];
              $deviceName = 'Unknown Device';
              if (preg_match('/Windows/i', $userAgent)) $deviceName = 'Windows PC';
              elseif (preg_match('/Mac/i', $userAgent)) $deviceName = 'Mac';
              elseif (preg_match('/Linux/i', $userAgent)) $deviceName = 'Linux';
              elseif (preg_match('/Android/i', $userAgent)) $deviceName = 'Android Phone';
              elseif (preg_match('/iPhone/i', $userAgent)) $deviceName = 'iPhone';

              // Optionally detect location (using IP-based API)
              $location = 'Unknown';
              $locationData = @file_get_contents("https://ipapi.co/{$ipAddress}/json/");
              if ($locationData) {
                  $locationJson = json_decode($locationData, true);
                  if (isset($locationJson['city']) && isset($locationJson['country_name'])) {
                      $location = $locationJson['city'] . ', ' . $locationJson['country_name'];
                  }
              }

          $timestamp = strtotime($date);

          // Format: Day name, Day Month Year at Time (AM/PM)
          $formatted = date("l, d F Y \a\\t h:i A", $timestamp);

          $userAgent = $_SERVER['HTTP_USER_AGENT'];

          // Detect OS
          if (preg_match('/Windows NT 10/i', $userAgent)) $osVersion = 'Windows 10';
          elseif (preg_match('/Windows NT 11/i', $userAgent)) $osVersion = 'Windows 11';
          elseif (preg_match('/Android/i', $userAgent)) $osVersion = 'Android';
          elseif (preg_match('/iPhone|iPad/i', $userAgent)) $osVersion = 'iOS';
          else $osVersion = 'Unknown OS';

          // Detect browser
          if (preg_match('/Chrome\/([0-9.]+)/i', $userAgent, $matches)) {
              $browserName = 'Chrome';
              $browserVersion = $matches[1];
          } elseif (preg_match('/Firefox\/([0-9.]+)/i', $userAgent, $matches)) {
              $browserName = 'Firefox';
              $browserVersion = $matches[1];
          } elseif (preg_match('/Edg\/([0-9.]+)/i', $userAgent, $matches)) {
              $browserName = 'Edge';
              $browserVersion = $matches[1];
          } else {
              $browserName = 'Unknown';
              $browserVersion = '';
          }


            // return "Error code";
            $sqlQuery = $this->conn->prepare("SELECT * FROM `wolaita_dichafcdb`.`user_account` WHERE `email` = '$UserEmail' AND `password` = '$UserPass' ");
            $sqlQuery->execute();

            if ($rowQ = $sqlQuery->rowCount() > 0) {
                // code...
                $lastlogindate = date('M d Y');
                $lastlogintime = date('D, h:i: sa');
                $concat_date = $lastlogindate." ".$lastlogintime;
                $sqlQueryUpdateLoginTime = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_account` SET `last_login_date`= '$concat_date',`last_login_time` = '$lastlogintime' WHERE  `email`='$UserEmail' ");
                $sqlQueryUpdateLoginTime->execute();

                $result = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $key => $value) {
                  // code...
                
                $accounttype = $value['role'];
                // return $accounttype;

                if (empty($accounttype)) return "Error : User has not a role to Login Previlage !";

                $status = $value['account_status'];
                $level = $value['account_level'];

            // Store atempt 
            $status2 = "Success";
            $message2 = "Correct Password";
            $logFile = __DIR__ . '/user_attempts.log';
              $sqlQuery = $this->conn->prepare("
                  INSERT INTO `wolaita_dichafcdb`.`tbl_user_attempts`
                  (`email`, `ip_address`, `attempt_type`, `status`, `message`, `notified_admin`,
                   `device_name`, `location`, `user_agent`, `os_version`, `browser_name`,`attempt_time`)
                  VALUES
                  (:email, :ip_address, :attempt_type, :status, :message, :notified_admin,
                   :device_name, :location, :user_agent, :os_version, :browser_name, :attempt_time)
              ");

              $sqlQuery->execute([
                  ':email' => $UserEmail,
                  ':ip_address' => $ipAddress,
                  ':attempt_type' => $attemptType,
                  ':status' => $status2,
                  ':message' => $message2,
                  ':notified_admin' => '', // or 'yes'/'no'
                  ':device_name' => $deviceName,
                  ':location' => $location,
                  ':user_agent' => $userAgent,
                  ':os_version' => $osVersion,
                  ':browser_name' => $browserName,
                  ':attempt_time' => $formatted
              ]);

              // $sqlQuery->execute();

                
                $logintime = $value['last_login_time'];

                        if ($accounttype == 'System administrator') {
                            // code...
                            if ($status == 1) {
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;
                                echo "<script>window.location='Syadmin/dashboard';</script>";
                            }else{
                                return "Error : Your Account Locked contact System Administrator.";
                            }
                         }elseif ($accounttype == 'Secretary') {
                            // code...
                            if ($status == 1) {
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;
                                echo "<script>window.location='Sec/dashboard';</script>";
                            }else{
                                return "Error : Your Account Locked contact System Administrator.";
                            }
                         }elseif ($accounttype == 'Coach') {
                            // code...
                            if ($status == 1) {
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;
                                echo "<script>window.location='Coach/dashboard';</script>";
                            }else{
                                return "Error : Your Account Locked contact System Administrator.";
                            }
                         }elseif ($accounttype == 'Medical Staff') {
                            // code...
                            if ($status == 1) {
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;
                                echo "<script>window.location='Medical/dashboard';</script>";
                            }else{
                                return "Error : Your Account Locked contact System Administrator.";
                            }
                         }elseif ($accounttype == 'Technical Director') {
                            // code...
                            if ($status == 1) {
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;
                                echo "<script>window.location='TechDir/dashboard';</script>";
                            }else{
                                return "Error : Your Account Locked contact System Administrator.";
                            }
                         }else if ($accounttype == "Player") {
                             // code...
                            if ($status == 1) {
                                // code...
                                // code...
                                $_SESSION['sessionID'] = $value['email'];
                                $_SESSION['roleID'] = $accounttype;

                                
                                echo "<script>window.location='Player/dashboard';</script>";
                            }else{
                                 return "Error : Your Account Locked contact System Administrator.";
                            }
                         } else{
                            return "Error : Email or password is incorrect.";
                         }

                        }
                    }else{

            // Store atempt 
              // Format: Day name, Day Month Year at Time (AM/PM)
          $formatted = date("l, d F Y \a\\t h:i A", $timestamp);

          $userAgent = $_SERVER['HTTP_USER_AGENT'];
              $sqlQuery = $this->conn->prepare("
                  INSERT INTO `wolaita_dichafcdb`.`tbl_user_attempts`
                  (`email`, `ip_address`, `attempt_type`, `status`, `message`, `notified_admin`,
                   `device_name`, `location`, `user_agent`, `os_version`, `browser_name`,`attempt_time`)
                  VALUES
                  (:email, :ip_address, :attempt_type, :status, :message, :notified_admin,
                   :device_name, :location, :user_agent, :os_version, :browser_name, :attempt_time)
              ");

              $sqlQuery->execute([
                  ':email' => $UserEmail,
                  ':ip_address' => $ipAddress,
                  ':attempt_type' => $attemptType,
                  ':status' => $status,
                  ':message' => $message,
                  ':notified_admin' => '', // or 'yes'/'no'
                  ':device_name' => $deviceName,
                  ':location' => $location,
                  ':user_agent' => $userAgent,
                  ':os_version' => $osVersion,
                  ':browser_name' => $browserName,
                  ':attempt_time' => $formatted
              ]);

              // $sqlQuery->execute();
                        return "Error : Email or password is incorrect.";
                    }
                }
    }
 }