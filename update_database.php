<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Configuration/Dbconfig.php';

try {
    $db = new Database();
    $conn = $db->conn;
    
    echo "<h1>Database Update Script</h1>";
    
    // Read the SQL file
    $sql_content = file_get_contents('payment_tables.sql');
    
    if (!$sql_content) {
        throw new Exception("Could not read payment_tables.sql file");
    }
    
    // Split SQL commands by semicolon
    $sql_commands = explode(';', $sql_content);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($sql_commands as $sql) {
        $sql = trim($sql);
        
        // Skip empty commands and comments
        if (empty($sql) || strpos($sql, '--') === 0) {
            continue;
        }
        
        try {
            $conn->exec($sql);
            $success_count++;
            echo "<p>✅ Executed: " . substr($sql, 0, 50) . "...</p>";
        } catch (PDOException $e) {
            $error_count++;
            // Check if it's just a "column already exists" error
            if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
                echo "<p>⚠️ Column already exists: " . substr($sql, 0, 50) . "...</p>";
            } else {
                echo "<p>❌ Error: " . $e->getMessage() . "</p>";
                echo "<p>SQL: " . substr($sql, 0, 100) . "...</p>";
            }
        }
    }
    
    echo "<h2>Summary</h2>";
    echo "<p>✅ Successful commands: $success_count</p>";
    echo "<p>❌ Failed commands: $error_count</p>";
    
    // Test the new columns
    echo "<h2>Column Check</h2>";
    try {
        $result = $conn->query("DESCRIBE fans");
        $columns = $result->fetchAll(PDO::FETCH_ASSOC);
        
        $required_columns = ['payment_status', 'payment_date', 'tx_ref'];
        foreach ($required_columns as $col) {
            $found = false;
            foreach ($columns as $column) {
                if ($column['Field'] === $col) {
                    $found = true;
                    break;
                }
            }
            echo "<p><strong>$col:</strong> " . ($found ? '✅ EXISTS' : '❌ MISSING') . "</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Error checking columns: " . $e->getMessage() . "</p>";
    }
    
    echo "<p><a href='reg_fans.php'>Test Registration</a></p>";
    
} catch (Exception $e) {
    echo "<h2>❌ Database Connection Error</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>