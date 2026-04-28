<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Configuration/Dbconfig.php';

try {
    $db = new Database();
    $conn = $db->conn;
    
    echo "<h1>Add Fullname Column to User Account Table</h1>";
    
    // Check if fullname column exists
    $result = $conn->query("DESCRIBE user_account");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    $has_fullname = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'fullname') {
            $has_fullname = true;
            break;
        }
    }
    
    if ($has_fullname) {
        echo "<p>✅ Column 'fullname' already exists in user_account table</p>";
    } else {
        echo "<p>⚠️ Column 'fullname' is missing. Adding it now...</p>";
        
        try {
            $conn->exec("ALTER TABLE user_account ADD COLUMN fullname VARCHAR(255) NOT NULL AFTER account_id");
            echo "<p>✅ Successfully added 'fullname' column to user_account table</p>";
        } catch (Exception $e) {
            echo "<p>❌ Error adding column: " . $e->getMessage() . "</p>";
        }
    }
    
    // Show current table structure
    echo "<h2>Current user_account Table Structure:</h2>";
    $result = $conn->query("DESCRIBE user_account");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        $highlight = ($column['Field'] === 'fullname') ? 'style="background-color: yellow;"' : '';
        echo "<div $highlight>";
        echo "<strong>{$column['Field']}</strong>: {$column['Type']}";
        if ($column['Null'] === 'YES') echo " (NULL allowed)";
        if ($column['Default']) echo " Default: {$column['Default']}";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Database Error</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='Syadmin/pages-newuser.php'>Test Admin User Creation</a></p>";
?>