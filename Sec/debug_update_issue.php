<?php
session_start();

echo "<h1>Player Update Debug - In Sec Directory</h1>";

// Test 1: Check if we can load the class
echo "<h2>1. Class Loading Test</h2>";
try {
    require __DIR__.'/performSecAction.php';
    echo "✅ performSecAction.php loaded<br>";
    
    $isPerformSecOBJ = new isPerformSecAction();
    echo "✅ Class instantiated<br>";
    
    if (method_exists($isPerformSecOBJ, 'isUpdatePlayerProfile')) {
        echo "✅ isUpdatePlayerProfile method exists<br>";
    } else {
        echo "❌ Method missing<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";

// Test 2: Check POST data if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>2. POST Data Analysis</h2>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    
    if (isset($_POST['isUpdatePlayerProfile'])) {
        echo "✅ Update trigger found<br>";
        
        // Call the function
        echo "<h3>Function Call Result:</h3>";
        $result = $isPerformSecOBJ->isUpdatePlayerProfile();
        echo $result ? $result : "(No result returned)";
    } else {
        echo "❌ Update trigger missing<br>";
    }
    echo "<hr>";
}

// Test 3: Database connection
echo "<h2>3. Database Test</h2>";
try {
    require __DIR__.'/../Configuration/Dbconfig.php';
    $db = new Database();
    echo "✅ Database connected<br>";
    
    $stmt = $db->conn->prepare("SELECT COUNT(*) as count FROM playerregistration");
    $stmt->execute();
    $result = $stmt->fetch();
    echo "📊 Players in database: " . $result['count'] . "<br>";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

echo "<hr>";

// Test 4: Simple form
echo "<h2>4. Test Form</h2>";
?>
<form method="POST" action="">
    <input type="hidden" name="isUpdatePlayerProfile" value="1">
    <table>
        <tr><td>Player ID:</td><td><input type="text" name="urlid" value="1" required></td></tr>
        <tr><td>Name:</td><td><input type="text" name="fullname" value="Test Update" required></td></tr>
        <tr><td>Email:</td><td><input type="email" name="email" value="test@test.com" required></td></tr>
        <tr><td>Phone:</td><td><input type="text" name="phone" value="0912345678" required></td></tr>
        <tr><td>Gender:</td><td><select name="gender"><option value="Male">Male</option></select></td></tr>
        <tr><td>DOB:</td><td><input type="date" name="dob" value="1990-01-01" required></td></tr>
        <tr><td>Nationality:</td><td><input type="text" name="nationality" value="Ethiopian" required></td></tr>
        <tr><td>Position:</td><td><input type="text" name="position" value="Forward" required></td></tr>
        <tr><td>Height:</td><td><input type="number" name="height" value="180" required></td></tr>
        <tr><td>Weight:</td><td><input type="number" name="weight" value="75" required></td></tr>
        <tr><td>Foot:</td><td><select name="preferred_foot"><option value="Right">Right</option></select></td></tr>
        <tr><td>Experience:</td><td><input type="number" name="experience" value="5" required></td></tr>
        <tr><td>Skill:</td><td><select name="skill_level"><option value="Professional">Professional</option></select></td></tr>
        <tr><td>Contract Start:</td><td><input type="date" name="contract_start" value="2024-01-01"></td></tr>
        <tr><td>Contract End:</td><td><input type="date" name="contract_end" value="2025-01-01"></td></tr>
        <tr><td>EFF ID:</td><td><input type="text" name="effid" value="EFF-18-TEST" required></td></tr>
        <tr><td>Club:</td><td><input type="text" name="club" value="Test Club" required></td></tr>
    </table>
    <br>
    <button type="submit">🧪 TEST UPDATE</button>
</form>