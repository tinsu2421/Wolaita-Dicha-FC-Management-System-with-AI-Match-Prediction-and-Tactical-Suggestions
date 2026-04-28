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
  * Player Perform Action
  */
 class isPerformPlayerAction extends Database{


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

    // isRegisterTrainingSckedule
    public function isRegisterTrainingSckedule(){
        // code...
        if (isset($_POST['isRegisterTrainingSckedule'])) {
            // code...
            $training_date = $_POST['training_date'];
            $training_time = $_POST['training_time'];
            $training_type = $_POST['training_type'];
            $focus_area = $_POST['focus_area'];
            $location = $_POST['location'];
            $coach = $_POST['coach'];
            $duration_minutes = $_POST['duration_minutes'];
            $intensity = $_POST['intensity'];
            $squad = $_POST['squad'];
            $status = $_POST['status'];

            $sqlQuery = $this->conn->prepare("
                INSERT INTO `club_training_schedule`(`id`, `training_date`, `training_time`, `training_type`, `focus_area`, `location`, `coach`, `squad`, `intensity`, `duration_minutes`, `status`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $sqlQuery->execute([
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

            return "<div class='alert alert-success d-flex align-items-center' role='alert'>
                    <i class='bi bi-check-circle-fill me-2'></i>
                    Training schedule saved successfully.
                </div>";

        }
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