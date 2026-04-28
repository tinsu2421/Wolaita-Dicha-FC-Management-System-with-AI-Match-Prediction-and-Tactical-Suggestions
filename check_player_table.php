<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Check Player Table Structure</h1>";

try {
    require __DIR__.'/Configuration/Dbconfig.php';
    $db = new Database();
    echo "<h2>✅ Database connection successful</h2>";
    
    // Check table structure
    $sqlStructure = $db->conn->prepare("DESCRIBE playerregistration");
    $sqlStructure->execute();
    $columns = $sqlStructure->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Player Registration Table Structure:</h2>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check if there are any players
    $sqlCount = $db->conn->prepare("SELECT COUNT(*) as total FROM playerregistration");
    $sqlCount->execute();
    $count = $sqlCount->fetch(PDO::FETCH_ASSOC);
    echo "<h2>Total Players: " . $count['total'] . "</h2>";
    
    // Show first few players
    if ($count['total'] > 0) {
        $sqlPlayers = $db->conn->prepare("SELECT * FROM playerregistration LIMIT 5");
        $sqlPlayers->execute();
        $players = $sqlPlayers->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h2>Sample Players:</h2>";
        echo "<pre>";
        print_r($players);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Database error: " . $e->getMessage() . "</h2>";
}
?>