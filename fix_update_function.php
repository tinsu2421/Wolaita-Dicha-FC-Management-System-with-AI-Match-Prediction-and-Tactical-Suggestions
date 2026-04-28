<?php
// This is the clean isUpdatePlayerProfile function
// Copy this and replace the broken one in performSecAction.php

public function isUpdatePlayerProfile(){
    if (!isset($_POST['isUpdatePlayerProfile'])) {
        return ""; // Not an update request
    }
    
    // Quick validation
    if (empty($_POST['urlid']) || empty($_POST['fullname'])) {
        return "<div class='alert alert-danger'>❌ Missing required fields</div>";
    }
    
    try {
        $urlid = $_POST['urlid'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        
        // Simple update - just the basic fields
        $sql = $this->conn->prepare("
            UPDATE playerregistration 
            SET fullname = ?, email = ?, phone = ? 
            WHERE player_id = ?
        ");
        
        $result = $sql->execute([$fullname, $email, $phone, $urlid]);
        
        if ($result) {
            return "<div class='alert alert-success'>✅ Player updated successfully!</div>";
        } else {
            return "<div class='alert alert-danger'>❌ Update failed</div>";
        }
        
    } catch (Exception $e) {
        return "<div class='alert alert-danger'>❌ Error: " . $e->getMessage() . "</div>";
    }
}
?>