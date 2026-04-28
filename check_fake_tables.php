<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Checking Fake Payment Database Tables</h2>";

try {
    require 'Configuration/Dbconfig.php';
    $db = new Database();
    
    // Check if fake tables exist
    $tables = ['fake_chapa_transactions', 'fake_telebirr_transactions', 'fake_payment_responses'];
    $missing_tables = [];
    
    foreach ($tables as $table) {
        try {
            $stmt = $db->conn->prepare("SELECT COUNT(*) FROM $table");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            echo "✓ Table <strong>$table</strong> exists with $count records<br>";
        } catch (Exception $e) {
            echo "✗ Table <strong>$table</strong> does NOT exist<br>";
            $missing_tables[] = $table;
        }
    }
    
    if (count($missing_tables) > 0) {
        echo "<br><h3>❌ Missing Tables Found</h3>";
        echo "<p>You need to create the following tables by running the SQL commands from <code>fake_chapa_database.sql</code>:</p>";
        echo "<ul>";
        foreach ($missing_tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        echo "<h4>Quick Fix - Run these SQL commands:</h4>";
        echo "<textarea style='width:100%; height:200px;'>";
        echo file_get_contents('fake_chapa_database.sql');
        echo "</textarea>";
    } else {
        echo "<br><h3>✅ All Tables Exist</h3>";
        echo "<p>Fake payment system database is ready!</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Database Connection Error</h3>";
    echo "Error: " . $e->getMessage();
}
?>