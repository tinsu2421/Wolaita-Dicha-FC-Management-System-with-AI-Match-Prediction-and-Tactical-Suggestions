<?php 


/**
 * 
 */
class CommonFunction extends Database{

      // fetchUserList
    public function getPlayerByEFFID($params) {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.playerregistration  WHERE player_id  = ?  ");
            $sqlQuery->execute([$params]);

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
    public function fetchFanList() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.fans ");
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
    public function fetchUserList() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.user_account a INNER JOIN user_details u ON a.account_id = u.account_id WHERE a.role != 'PLayer' ");
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
    public function fetchUpcomingResult() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.club_upcoming_matches ORDER BY id  ASC ");
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
    public function fetchRecentResult() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.club_match_results ORDER BY match_id  ASC ");
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
    public function fetchEachPlayerInjury($params) {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("
                SELECT * FROM wolaita_dichafcdb.player_injuries 
                WHERE email = ?
                 ");
            $sqlQuery->execute([$params]);

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
    public function fetchPlayerInjury() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.player_injuries  ");
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
    public function fetchTrainingSckedule() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.club_training_schedule ORDER BY id  ASC ");
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

    // isUpdateAvatar
    public function isUpdateAvatar(){
        // code...
        if (isset($_POST['UploadAvatar'])) {
            $allowedTypes = ['image/jpeg','image/png','image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            $urlId = $_POST['urlId'];

            // Check if we have the urlId
            if (empty($urlId)) {
                return "<div class='alert alert-danger' role='alert'> Error: User ID not found.</div>";
            }

            // Check if file was uploaded
            if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                return "<div class='alert alert-danger' role='alert'> Error: Please select a valid image file.</div>";
            }

            $file = $_FILES['avatar'];
            $filename = $file['name'];
            $fileerror = $file['error'];
            $filetmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            $fileext = explode('.', $filename);
            $filechecker = strtolower(end($fileext));
            $filestoretype = array('jpeg','jpg','png','gif');

            // Validate file type
            if (!in_array($filechecker, $filestoretype)) {
                return "<div class='alert alert-danger' role='alert'> Error: Only JPEG, PNG, and GIF images are allowed.</div>";
            }

            // Validate file size
            if ($fileSize > $maxFileSize) {
                return "<div class='alert alert-danger' role='alert'> Error: File size exceeds the maximum limit of 2 MB.</div>";
            }

            $dirPath = '../assets/img/avatar/';
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }

            // Create unique filename to avoid conflicts
            $uniqueFilename = uniqid('avatar_') . '.' . $filechecker;
            $destination = $dirPath . $uniqueFilename;
            
            if (move_uploaded_file($filetmp, $destination)) {
                // Update database with relative path for web access from subfolders
                $webPath = '../assets/img/avatar/' . $uniqueFilename;
                $sqlQuery = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_details` SET `profile_picture_url`='$webPath' WHERE `account_id` = '$urlId' ");
                
                if ($sqlQuery->execute()) {
                    return "<div class='alert alert-success' role='alert'> 
                        <i class='bi bi-check-circle-fill me-2'></i> 
                        Profile photo updated successfully!
                    </div>";
                } else {
                    return "<div class='alert alert-danger' role='alert'> Error: Failed to update database.</div>";
                }
            } else {
                return "<div class='alert alert-danger' role='alert'> Error: Failed to upload file. Check directory permissions.</div>";
            }
        }
    }


      // fetchUserList
    public function fetchPlayers() {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("SELECT * FROM wolaita_dichafcdb.playerregistration ");
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
    public function fetchEachPlayers($params) {
        try {
            // Prepare query with placeholder to avoid SQL injection
            $sqlQuery = $this->conn->prepare("
                SELECT * FROM wolaita_dichafcdb.playerregistration 
                WHERE email = ?
            ");
            $sqlQuery->execute([$params]);

            $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            // Return empty array if no users found
            return $resultQ ?: [];

        } catch (PDOException $e) {
            // Log error and return empty array
            error_log("Error fetching user list: " . $e->getMessage());
            return [];
        }
    }

   public function confirmStatus(string $params){
      // code...
      if (isset($_POST['confirmCongrats'])) {
         // code...
         $sqlQuery = $this->conn->prepare("
            UPDATE 
               `wolaita_dichafcdb`.`user_account` 
            SET `congrats_status` = 1
            WHERE `email` = ?
         ");
         $sqlQuery->execute([$params]);
      }
   }

   // getState
   public function congratsModalBool($params){
        // code...
         $sqlQuery = $this->conn->prepare("
                SELECT * FROM `wolaita_dichafcdb`.`user_account` 
                WHERE `email` = '$params'  
        ");
         $sqlQuery->execute();
         $resultQ = $sqlQuery->fetchAll();
         foreach ($resultQ as $key => $value) {
             // code...
             $congratsModalBool = $value['congrats_status'];
         }
         return $congratsModalBool;
         
    }

	// change password
    public function changePassword(){
    // code...
    if (isset($_POST['changePasswordBtn'])) {
         // code...
         $email = $_POST['email'];
         $oldPassword = $_POST['oldPassword'];
         $newPassword = $_POST['newPassword'];
         $conPassword = $_POST['conPassword'];

         // check if new and confirm password match..
         if ($newPassword != $conPassword) {
            // code...
            return "Error : New and Confirm password not matched.";
         }else{
            // return "Success : OK";
            // check if old password is correct
            $sqlQuery = $this->conn->prepare("SELECT * FROM `wolaita_dichafcdb`.`user_account` WHERE `phone_number` LIKE '$email' OR `email` LIKE '$email'");
            $sqlQuery->execute();
            $resultQ = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultQ as $key => $value) {
               // code...
               $dbPassword = $value['password']; // Use hashed password from database
            }

            // Hash the old password to compare with stored hash
            $hashedOldPassword = sha1($oldPassword);
            if ($dbPassword != $hashedOldPassword) {
               // code...
               return "Error : OLD password is not correct. Try again.";
            }else{

               // HASH password with encryption algorithm
               $hashPassword = sha1($newPassword);
               $sqlQuery = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_account` SET `password` = '$hashPassword' WHERE `phone_number` = '$email' OR `email` = '$email'");
               if ($sqlQuery->execute()) {
                  // code...
                  return "<div class='alert alert-success' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Password changed successfully.</div>";  
                  // return "Success : Password changed successfully.";
               }else{
                  return "Error : Something want wrong, Please Try Again.";
               }
            }
         }
         
      }
  }


	// UpdateSetting
    public function UpdateSetting(){
        if (isset($_POST['UpdateSetting'])) {
            // code...

            $Address = $_POST['Address'];
            $City = $_POST['City'];
            $Region = $_POST['Region'];
            $Gender = $_POST['Gender'];
            $Bio = $_POST['Bio'];


            $urlid = $_POST['urlid'];

            $sqlQuery = $this->conn->prepare("UPDATE `wolaita_dichafcdb`.`user_details` 
                SET `address`='$Address',`city`='$City',`state`='$Region',`gender`='$Gender',`bio`='$Bio' WHERE `account_id` = '$urlid'");
            if ($sqlQuery->execute()) {
                // code...
                return "<div class='alert alert-success' role='alert'> <i class='bi bi-check-circle-fill me-2'></i> Profile setting Update successfully.</div>";  
            }else{
                return "<div class='alert alert-danger' role='alert'> Error: SQL QUERY Error Check The maria DB.</div>";  
            }
        }
    }

	// Total admins
	public function getTotalAdmins() {
	    try {
	        $sqlQuery = $this->conn->prepare("SELECT COUNT(*) AS total FROM `wolaita_dichafcdb`.`user_account` WHERE `role` = :role");
	        $sqlQuery->execute(['role' => 'System administrator']);
	        $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	        return $result ? (int)$result['total'] : 0;
	    } catch (PDOException $e) {
	        // Log error or handle gracefully
	        error_log("Error fetching admin quantity: " . $e->getMessage());
	        return 0;
	    }
	}


    // Total fans
	public function getFansQty() {
	    try {
	        $sqlQuery = $this->conn->prepare("SELECT COUNT(*) AS total FROM `wolaita_dichafcdb`.`fans`");
	        $sqlQuery->execute();
	        $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	        return $result ? (int)$result['total'] : 0;
	    } catch (PDOException $e) {
	        // Log error or handle gracefully
	        error_log("Error fetching fan quantity: " . $e->getMessage());
	        return 0;
	    }
	}


	// Total fans
	public function getTotalPlayers() {
	    try {
	        $sqlQuery = $this->conn->prepare("SELECT COUNT(*) AS total FROM `wolaita_dichafcdb`.`playerregistration`");
	        $sqlQuery->execute();
	        $result = $sqlQuery->fetch(PDO::FETCH_ASSOC);
	        return $result ? (int)$result['total'] : 0;
	    } catch (PDOException $e) {
	        // Log error or handle gracefully
	        error_log("Error fetching fan quantity: " . $e->getMessage());
	        return 0;
	    }
	}

}