<?php
// Payment callback handler for webhook notifications
require_once __DIR__.'/Configuration/payment_config.php';
require_once __DIR__.'/Auth/auth.php';

// Use fake payment handler if fake mode is enabled
if (defined('PAYMENT_FAKE_MODE') && PAYMENT_FAKE_MODE) {
    require_once __DIR__.'/Payment/FakePaymentHandler.php';
    $paymentHandler = new FakePaymentHandler();
} else {
    require_once __DIR__.'/Payment/PaymentHandler.php';
    $paymentHandler = new PaymentHandler();
}

// Log the callback for debugging
error_log("Payment callback received: " . file_get_contents('php://input'));

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data && isset($data['tx_ref'])) {
    $tx_ref = $data['tx_ref'];
    $status = $data['status'] ?? 'unknown';
    
    try {
        $conn = new Database();
        
        // Update payment transaction status
        $sqlQuery = $conn->conn->prepare("
            UPDATE payment_transactions 
            SET payment_status = ?, gateway_response = ?, updated_at = NOW() 
            WHERE tx_ref = ?
        ");
        
        $payment_status = ($status == 'success') ? 'success' : 'failed';
        $sqlQuery->execute([$payment_status, $input, $tx_ref]);
        
        // If payment failed, update pending registration
        if ($status != 'success') {
            $sqlQuery = $conn->conn->prepare("UPDATE pending_registrations SET status = 'failed' WHERE tx_ref = ?");
            $sqlQuery->execute([$tx_ref]);
        }
        
        error_log("Payment callback processed for tx_ref: $tx_ref, status: $status");
        
        // Return success response to gateway
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Callback processed']);
        
    } catch (Exception $e) {
        error_log("Payment callback error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Callback processing failed']);
    }
} else {
    error_log("Invalid payment callback data");
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid callback data']);
}
?>