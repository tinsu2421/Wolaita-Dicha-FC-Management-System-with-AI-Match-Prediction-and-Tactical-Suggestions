<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Configuration/Dbconfig.php';

try {
    $db = new Database();
    $conn = $db->conn;
    
    echo "<h1>Fix Fans Table - Add Payment Columns</h1>";
    
    // SQL commands to add missing columns
    $sql_commands = [
        "ALTER TABLE `fans` ADD COLUMN `payment_status` enum('free','paid','pending','failed') DEFAULT 'free' AFTER `status`",
        "ALTER TABLE `fans` ADD COLUMN `payment_date` timestamp NULL AFTER `payment_status`",
        "ALTER TABLE `fans` ADD COLUMN `tx_ref` varchar(100) NULL AFTER `payment_date`"
    ];
    
    foreach ($sql_commands as $sql) {
        try {
            $conn->exec($sql);
            echo "<p>✅ Successfully executed: " . htmlspecialchars($sql) . "</p>";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
                echo "<p>⚠️ Column already exists (skipping): " . htmlspecialchars($sql) . "</p>";
            } else {
                echo "<p>❌ Error: " . $e->getMessage() . "</p>";
                echo "<p>SQL: " . htmlspecialchars($sql) . "</p>";
            }
        }
    }
    
    // Verify the columns exist
    echo "<h2>Verification</h2>";
    try {
        $result = $conn->query("DESCRIBE fans");
        $columns = $result->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Fans Table Columns:</h3>";
        foreach ($columns as $column) {
            $highlight = in_array($column['Field'], ['payment_status', 'payment_date', 'tx_ref']) ? 'style="background-color: yellow;"' : '';
            echo "<p $highlight><strong>{$column['Field']}</strong>: {$column['Type']} {$column['Null']} {$column['Default']}</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Error checking table structure: " . $e->getMessage() . "</p>";
    }
    
    echo "<hr>";
    echo "<p><a href='reg_fans.php'>Test Registration Now</a></p>";
    echo "<p><a href='debug_simple.php'>Run Debug Check</a></p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Database Connection Error</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>