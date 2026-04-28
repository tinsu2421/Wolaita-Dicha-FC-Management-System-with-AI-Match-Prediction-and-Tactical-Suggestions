<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Wolaita-Dicha-Fc/php_errors.log');

// Load payment configuration first
require_once __DIR__.'/Configuration/payment_config.php';

// Check if we have pending registration data and selected payment method
if (!isset($_SESSION['pending_registration']) || !isset($_SESSION['selected_payment_method'])) {
    error_log("Missing session data - redirecting to registration");
    header('Location: reg_fans.php');
    exit;
}

$pendingReg = $_SESSION['pending_registration'];
$paymentMethod = $_SESSION['selected_payment_method'];

error_log("Processing payment for: " . $pendingReg['email'] . " with method: " . $paymentMethod);

try {
    // Use fake payment handler if fake mode is enabled
    if (defined('PAYMENT_FAKE_MODE') && PAYMENT_FAKE_MODE) {
        require_once __DIR__.'/Payment/FakePaymentHandler.php';
        $paymentHandler = new FakePaymentHandler();
    } else {
        require_once __DIR__.'/Payment/PaymentHandler.php';
        $paymentHandler = new PaymentHandler();
    }
    
    require_once __DIR__.'/Configuration/Dbconfig.php';
    $db = new Database();
    
    // Generate transaction reference
    $tx_ref = $paymentHandler->generateTxRef();
    $amount = $paymentHandler->getMembershipPrice($pendingReg['membership']);
    
    error_log("Generated TX Ref: $tx_ref, Amount: $amount");
    
    // Store pending registration in database
    $sqlQuery = $db->conn->prepare("
        INSERT INTO `pending_registrations` 
        (`tx_ref`, `full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `amount`, `status`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $sqlQuery->execute([
        $tx_ref,
        $pendingReg['fullname'],
        $pendingReg['email'],
        $pendingReg['phone'],
        $pendingReg['password'],
        $pendingReg['membership'],
        $pendingReg['fan_label'],
        $amount
    ]);
    
    // Prepare payment data
    $payment_data = [
        'amount' => $amount,
        'email' => $pendingReg['email'],
        'first_name' => explode(' ', $pendingReg['fullname'])[0],
        'last_name' => implode(' ', array_slice(explode(' ', $pendingReg['fullname']), 1)) ?: 'Fan',
        'phone_number' => $pendingReg['phone'],
        'tx_ref' => $tx_ref,
        'description' => "Wolaita Dicha FC " . ucfirst($pendingReg['membership']) . " Membership",
        'membership_type' => $pendingReg['membership'],
        'fan_label' => $pendingReg['fan_label']
    ];
    
    // Initialize payment with selected gateway
    $payment_result = $paymentHandler->initializePayment($payment_data, $paymentMethod);
    
    if ($payment_result['status'] === 'success') {
        // Store payment transaction
        $sqlQuery = $db->conn->prepare("
            INSERT INTO `payment_transactions` 
            (`tx_ref`, `user_email`, `amount`, `currency`, `payment_method`, `payment_status`, `gateway_response`) 
            VALUES (?, ?, ?, ?, ?, 'pending', ?)
        ");
        
        $sqlQuery->execute([
            $tx_ref,
            $pendingReg['email'],
            $amount,
            'ETB',
            $paymentMethod,
            json_encode($payment_result)
        ]);
        
        // Redirect to payment gateway
        $checkout_url = $payment_result['data']['checkout_url'];
        error_log("Redirecting to payment gateway: $checkout_url");
        
        // Clear session data as it's now stored in database
        unset($_SESSION['pending_registration']);
        unset($_SESSION['selected_payment_method']);
        
        header("Location: $checkout_url");
        exit;
        
    } else {
        throw new Exception($payment_result['message'] ?? 'Payment initialization failed');
    }
    
} catch (Exception $e) {
    error_log("Payment processing error: " . $e->getMessage());
    
    $_SESSION['payment_error'] = 'Payment processing failed: ' . $e->getMessage();
    header('Location: payment_method_selection.php');
    exit;
}
?>