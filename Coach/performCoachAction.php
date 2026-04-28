<?php 


 // use mailer class..
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Include all php class file

include '../MailerSrc/PHPMailer/src/Exception.php';
include '../MailerSrc/PHPMailer/src/SMTP.php';
include '../MailerSrc/PHPMailer/src/PHPMailer.php';
include '../MailerSrc/PHPMailer/constant.php';


 // Include Required file 
 require __DIR__.'/../Configuration/Dbconfig.php';

 /**
  * Syadmin Perform Action
  */
 class isPerformCoachAction extends Database{


    // User status lock and unlock method....
    public function SckeduleStatus(){

    // Account Lock 
      if (isset($_POST['UnApprove'])) {
         // code...
         $urlId = $_POST['urlId'];
         $status = 0;
         $Completed = "Scheduled";
         $sqlQuery = $this->conn->prepare(" 
            UPDATE 
                    `wolaita_dichafcdb`.`club_training_schedule` 
                SET 
                    `sckedule_status` = ?,
                    `status` = ?
                WHERE 
                    `id` = ? 
        ");

        $sqlQuery->execute([$status, $Completed, $urlId]);
        return "<div class='alert alert-warning' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Sckedule Scheduled Successfully.</div>";
      }

      // Account UnLock 
      if (isset($_POST['Approve'])) {
         // code...
         $urlId = $_POST['urlId'];
         $status = 1;
         $Completed = "Completed";
         $sqlQuery = $this->conn->prepare(" 
            UPDATE 
                    `wolaita_dichafcdb`.`club_training_schedule` 
                SET 
                    `sckedule_status` = ?,
                    `status` = ?
                WHERE 
                    `id` = ? 
        ");

        $sqlQuery->execute([$status, $Completed, $urlId]);
        return "<div class='alert alert-success' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Sckedule Complated Successfully.</div>";
      }
    }

    // isRegisterTrainingSckedule - ENHANCED WITH COMPREHENSIVE VALIDATION
    public function isRegisterTrainingSckedule(){
        // code...
        if (isset($_POST['isRegisterTrainingSckedule'])) {
            // Get form data with trimming
            $training_date = trim($_POST['training_date'] ?? '');
            $training_time = trim($_POST['training_time'] ?? '');
            $training_type = trim($_POST['training_type'] ?? '');
            $focus_area = trim($_POST['focus_area'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $coach = trim($_POST['coach'] ?? '');
            $duration_minutes = trim($_POST['duration_minutes'] ?? '');
            $intensity = trim($_POST['intensity'] ?? '');
            $squad = trim($_POST['squad'] ?? '');
            $status = trim($_POST['status'] ?? '');

            // Validation
            $errors = [];

            // Required field validation
            if (empty($training_date)) {
                $errors[] = "Training date is required";
            }
            if (empty($training_time)) {
                $errors[] = "Training time is required";
            }
            if (empty($training_type) || $training_type === 'Choose') {
                $errors[] = "Training type is required";
            }
            if (empty($focus_area) || $focus_area === 'Choose') {
                $errors[] = "Focus area is required";
            }
            if (empty($location) || $location === 'Choose') {
                $errors[] = "Location is required";
            }
            if (empty($coach)) {
                $errors[] = "Coach name is required";
            }
            if (empty($duration_minutes)) {
                $errors[] = "Duration is required";
            }
            if (empty($intensity) || $intensity === 'Choose') {
                $errors[] = "Intensity level is required";
            }
            if (empty($squad) || $squad === 'Choose') {
                $errors[] = "Squad selection is required";
            }
            if (empty($status) || $status === 'Choose') {
                $errors[] = "Status is required";
            }

            // Date validation
            if (!empty($training_date)) {
                $date = DateTime::createFromFormat('Y-m-d', $training_date);
                if (!$date || $date->format('Y-m-d') !== $training_date) {
                    $errors[] = "Invalid training date format";
                } else {
                    // Only accept training dates from 2026 or later
                    $year = $date->format('Y');
                    if ($year < 2026) {
                        $errors[] = "Training date must be from 2026 or later. Selected year: $year";
                    }
                    
                    // Training should be scheduled for future dates (not past)
                    $today = new DateTime();
                    $today->setTime(0, 0, 0); // Set to start of day for comparison
                    if ($date < $today) {
                        $errors[] = "Training date cannot be in the past. Please select today or a future date.";
                    }
                    
                    // Don't allow training more than 1 year in advance
                    $maxDate = clone $today;
                    $maxDate->add(new DateInterval('P1Y')); // Add 1 year
                    if ($date > $maxDate) {
                        $errors[] = "Training date cannot be more than 1 year in advance";
                    }
                }
            }

            // Time validation
            if (!empty($training_time)) {
                $time = DateTime::createFromFormat('H:i', $training_time);
                if (!$time || $time->format('H:i') !== $training_time) {
                    $errors[] = "Invalid training time format (use HH:MM)";
                } else {
                    // Check for reasonable training hours (6 AM to 10 PM)
                    $hour = (int)$time->format('H');
                    if ($hour < 6 || $hour > 22) {
                        $errors[] = "Training time should be between 6:00 AM and 10:00 PM";
                    }
                }
            }

            // Duration validation
            if (!empty($duration_minutes)) {
                if (!is_numeric($duration_minutes) || $duration_minutes <= 0) {
                    $errors[] = "Duration must be a positive number";
                } else {
                    $duration = (int)$duration_minutes;
                    if ($duration < 30) {
                        $errors[] = "Training duration must be at least 30 minutes";
                    }
                    if ($duration > 300) { // 5 hours
                        $errors[] = "Training duration cannot exceed 300 minutes (5 hours)";
                    }
                }
            }

            // Training type validation
            if (!empty($training_type) && $training_type !== 'Choose') {
                $validTrainingTypes = [
                    'Technical Training', 'Physical Training', 'Tactical Training', 
                    'Match Preparation', 'Recovery Session', 'Friendly Match', 'Team Meeting'
                ];
                if (!in_array($training_type, $validTrainingTypes)) {
                    $errors[] = "Invalid training type selected";
                }
            }

            // Focus area validation
            if (!empty($focus_area) && $focus_area !== 'Choose') {
                $validFocusAreas = [
                    'Passing', 'Shooting', 'Defending', 'Fitness', 'Set Pieces', 
                    'Tactics', 'Ball Control', 'Team Coordination'
                ];
                if (!in_array($focus_area, $validFocusAreas)) {
                    $errors[] = "Invalid focus area selected";
                }
            }

            // Location validation
            if (!empty($location) && $location !== 'Choose') {
                $validLocations = [
                    'Main Training Ground', 'Secondary Field', 'Indoor Facility', 
                    'Gym', 'Stadium', 'Away Venue'
                ];
                if (!in_array($location, $validLocations)) {
                    $errors[] = "Invalid location selected";
                }
            }

            // Intensity validation
            if (!empty($intensity) && $intensity !== 'Choose') {
                $validIntensities = ['Low', 'Medium', 'High', 'Very High'];
                if (!in_array($intensity, $validIntensities)) {
                    $errors[] = "Invalid intensity level selected";
                }
            }

            // Squad validation
            if (!empty($squad) && $squad !== 'Choose') {
                $validSquads = [
                    'First Team', 'Reserve Team', 'Youth Team', 'U21', 'U19', 
                    'Goalkeepers', 'Defenders', 'Midfielders', 'Forwards'
                ];
                if (!in_array($squad, $validSquads)) {
                    $errors[] = "Invalid squad selection";
                }
            }

            // Status validation
            if (!empty($status) && $status !== 'Choose') {
                $validStatuses = ['Scheduled', 'Confirmed', 'Tentative'];
                if (!in_array($status, $validStatuses)) {
                    $errors[] = "Invalid status selected";
                }
            }

            // Coach name validation
            if (!empty($coach)) {
                if (strlen($coach) < 2) {
                    $errors[] = "Coach name must be at least 2 characters long";
                }
                if (strlen($coach) > 50) {
                    $errors[] = "Coach name cannot exceed 50 characters";
                }
                if (!preg_match('/^[a-zA-Z\s\-\.]+$/', $coach)) {
                    $errors[] = "Coach name can only contain letters, spaces, hyphens, and periods";
                }
            }

            // Return validation errors if any
            if (!empty($errors)) {
                return "<div class='alert alert-danger'><strong>Validation Errors:</strong><br>• " . implode("<br>• ", $errors) . "</div>";
            }

            // Check for duplicate training (same date, time, location)
            try {
                $sqlCheck = $this->conn->prepare("
                    SELECT * FROM club_training_schedule 
                    WHERE training_date = ? AND training_time = ? AND location = ?
                ");
                $sqlCheck->execute([$training_date, $training_time, $location]);
                
                if ($sqlCheck->rowCount() > 0) {
                    return "<div class='alert alert-warning'>Warning: Another training session is already scheduled at the same date, time, and location.</div>";
                }
            } catch (Exception $e) {
                return "<div class='alert alert-danger'>Error checking for duplicate training: " . $e->getMessage() . "</div>";
            }

            try {
                // Begin transaction
                $this->conn->beginTransaction();

                $sqlQuery = $this->conn->prepare("
                    INSERT INTO `club_training_schedule`(`id`, `training_date`, `training_time`, `training_type`, `focus_area`, `location`, `coach`, `squad`, `intensity`, `duration_minutes`, `status`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $success = $sqlQuery->execute([
                    NULL,
                    $training_date,
                    $training_time,
                    $training_type,
                    $focus_area,
                    $location,
                    $coach,
                    $squad,
                    $intensity,
                    $duration_minutes,
                    $status
                ]);

                if (!$success) {
                    throw new Exception("Failed to save training schedule to database");
                }

                $this->conn->commit();
                return "<div class='alert alert-success d-flex align-items-center' role='alert'>
                        <i class='bi bi-check-circle-fill me-2'></i>
                        Training schedule saved successfully.
                    </div>";

            } catch (Exception $e) {
                $this->conn->rollBack();
                return "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill me-2'></i>Error: " . $e->getMessage() . "</div>";
            }
        }
        
        return ""; // Return empty string if form not submitted
    }

      // User status lock and unlock method....
    public function AccountState(){

    // Account Lock 
      if (isset($_POST['SusspendUser'])) {
         // code...
         $email = $_POST['email'];
         $status = 0;
         $sqlQuery = $this->conn->prepare(" 
            UPDATE 
                    `wolaita_dichafcdb`.`playerregistration` 
                SET 
                    `status` = ? 
                WHERE 
                    `email` = ? ");

        $sqlQuery->execute([$status, $email]);
        return "<div class='alert alert-success' role='alert'> Success: Player registration UnApproved .</div>";
      }

      // Account UnLock 
      if (isset($_POST['UnSusspendUser'])) {
         // code...
         $email = $_POST['email'];
         $status = 1;
         $sqlQuery = $this->conn->prepare(" 
            UPDATE 
                    `wolaita_dichafcdb`.`playerregistration` 
                SET 
                    `status` = ? 
                WHERE 
                    `email` = ? ");

        $sqlQuery->execute([$status, $email]);
        return "<div class='alert alert-success' role='alert'> Success: Player registration approved succesfully by Club Technical Director.</div>";
      }
    }


    // Get user with session variable.. Weym Active Users
    public function getSessionUser(string $param){
        // code...
        // $param = function defination given for this method
        $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.user_account a INNER JOIN user_details u ON a.account_id = u.account_id WHERE `email` = '$param'");
        $sqlQuery->execute();


        if ($rowQ = $sqlQuery->rowCount() > 0) {
         // code...
         $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultQ as $key => $value) {
               // code...
               $dataQ[] = $value;
            }

             return $dataQ;
        }

        return $rowQ = $sqlQuery->rowCount();
    }
 }