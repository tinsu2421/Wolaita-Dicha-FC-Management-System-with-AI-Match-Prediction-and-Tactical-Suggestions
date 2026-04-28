<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Complete Payment System Debug</h1>";

// Set up test session data if needed
if (!isset($_SESSION['pending_registration'])) {
    $_SESSION['pending_registration'] = [
        'fullname' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '0912345678',
        'password' => sha1('testpass'),
        'membership' => 'standard',
        'fan_label' => 'supporter'
    ];
    echo "<p>✅ Test session data created</p>";
}

echo "<h2>1. Session Status</h2>";
echo "<p><strong>pending_registration:</strong> " . (isset($_SESSION['pending_registration']) ? '✅ EXISTS' : '❌ MISSING') . "</p>";
echo "<p><strong>selected_payment_method:</strong> " . (isset($_SESSION['selected_payment_method']) ? '✅ EXISTS (' . $_SESSION['selected_payment_method'] . ')' : '❌ MISSING') . "</p>";

if (isset($_SESSION['pending_registration'])) {
    echo "<h3>Registration Data:</h3>";
    echo "<pre>" . print_r($_SESSION['pending_registration'], true) . "</pre>";
}

echo "<h2>2. PaymentHandler Test</h2>";
try {
    require_once __DIR__.'/Payment/PaymentHandler.php';
    $paymentHandler = new PaymentHandler();
    echo "<p>✅ PaymentHandler loaded successfully</p>";
    
    $amount = $paymentHandler->getMembershipPrice('standard');
    echo "<p><strong>Standard membership price:</strong> $amount ETB</p>";
    
    $methods = $paymentHandler->getPaymentMethods();
    echo "<p><strong>Available payment methods:</strong> " . implode(', ', array_keys($methods)) . "</p>";
    
} catch (Exception $e) {
    echo "<p>❌ PaymentHandler Error: " . $e->getMessage() . "</p>";
}

echo "<h2>3. File Existence Check</h2>";
$files_to_check = [
    'payment_method_selection.php',
    'process_payment.php',
    'Payment/PaymentHandler.php',
    'Configuration/payment_config.php'
];

foreach ($files_to_check as $file) {
    $exists = file_exists(__DIR__ . '/' . $file);
    echo "<p><strong>$file:</strong> " . ($exists ? '✅ EXISTS' : '❌ MISSING') . "</p>";
}

echo "<h2>4. Quick Tests</h2>";
echo "<p><a href='simple_payment_form.php' target='_blank'>Test Simple Payment Form</a></p>";
echo "<p><a href='payment_method_selection.php' target='_blank'>Test Full Payment Selection</a></p>";
echo "<p><a href='debug_process_payment.php' target='_blank'>Test Process Payment Debug</a></p>";

// Test setting payment method
if (isset($_GET['set_method'])) {
    $_SESSION['selected_payment_method'] = $_GET['set_method'];
    echo "<p>✅ Payment method set to: " . $_GET['set_method'] . "</p>";
    echo "<p><a href='process_payment.php'>Now test process_payment.php</a></p>";
}

echo "<h2>5. Set Payment Method for Testing</h2>";
echo "<p><a href='?set_method=chapa'>Set Chapa Method</a> | <a href='?set_method=telebirr'>Set Telebirr Method</a></p>";

echo "<h2>6. Registration Flow Test</h2>";
echo "<p><a href='reg_fans.php'>Start New Registration</a></p>";

echo "<hr>";
echo "<p><em>Last updated: " . date('Y-m-d H:i:s') . "</em></p>";
?>