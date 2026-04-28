<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple Fake Payment Test</h1>";

// Test 1: Configuration
echo "<h2>1. Configuration Test</h2>";
require_once 'Configuration/payment_config.php';
echo "✓ PAYMENT_FAKE_MODE: " . (PAYMENT_FAKE_MODE ? 'TRUE' : 'FALSE') . "<br>";

// Test 2: Fake Payment Handler
echo "<h2>2. Fake Payment Handler Test</h2>";
require_once 'Payment/FakePaymentHandler.php';
$fakeHandler = new FakePaymentHandler();
echo "✓ FakePaymentHandler created<br>";

$methods = $fakeHandler->getPaymentMethods();
echo "✓ Payment methods: " . count($methods) . "<br>";
foreach ($methods as $key => $method) {
    echo "- $key: {$method['name']}<br>";
}

// Test 3: Generate transaction
echo "<h2>3. Transaction Generation Test</h2>";
$tx_ref = $fakeHandler->generateTxRef();
echo "✓ Generated TX Ref: $tx_ref<br>";

$amount = $fakeHandler->getMembershipPrice('standard');
echo "✓ Standard membership price: $amount ETB<br>";

echo "<h2>✅ Basic Tests Passed!</h2>";
echo "<p>The fake payment system is working. Now try:</p>";
echo "<ul>";
echo "<li><a href='reg_fans.php'>Register a new fan</a></li>";
echo "<li><a href='payment_method_selection.php'>Go to payment method selection</a></li>";
echo "</ul>";
?>