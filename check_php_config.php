<?php
echo "<h2>PHP Configuration Check</h2>";

echo "<h3>PHP Extensions:</h3>";
$required_extensions = ['openssl', 'curl', 'mbstring', 'iconv'];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color: green;'>✅ $ext: Loaded</p>";
    } else {
        echo "<p style='color: red;'>❌ $ext: NOT Loaded</p>";
    }
}

echo "<h3>PHP Version:</h3>";
echo "<p>" . phpversion() . "</p>";

echo "<h3>OpenSSL Info:</h3>";
if (extension_loaded('openssl')) {
    echo "<p style='color: green;'>OpenSSL Version: " . OPENSSL_VERSION_TEXT . "</p>";
} else {
    echo "<p style='color: red;'>OpenSSL not available</p>";
}

echo "<h3>SMTP Settings Test:</h3>";
$smtp_host = 'smtp.gmail.com';
$smtp_port = 465;

echo "<p>Testing connection to $smtp_host:$smtp_port...</p>";

$connection = @fsockopen('ssl://' . $smtp_host, $smtp_port, $errno, $errstr, 10);
if ($connection) {
    echo "<p style='color: green;'>✅ SMTP connection successful</p>";
    fclose($connection);
} else {
    echo "<p style='color: red;'>❌ SMTP connection failed: $errstr ($errno)</p>";
}

echo "<h3>Email Constants:</h3>";
require_once 'MailerSrc/PHPMailer/constant.php';
echo "<p><strong>EMAIL:</strong> " . EMAIL . "</p>";
echo "<p><strong>PASSWORD:</strong> " . (strlen(PASSWORD) > 0 ? str_repeat('*', strlen(PASSWORD)) : 'NOT SET') . "</p>";
?>