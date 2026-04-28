<?php
require __DIR__.'/Auth/auth.php';
require __DIR__.'/Payment/PaymentHandler.php';

$CommonOBJ = new Auth();
$paymentHandler = new PaymentHandler();

$message = "";
$status = "info";

if (isset($_GET['tx_ref'])) {
    $tx_ref = $_GET['tx_ref'];
    
    // Get payment method from database
    $conn = new Database();
    $sqlQuery = $conn->conn->prepare("SELECT payment_method FROM pending_registrations WHERE tx_ref = ?");
    $sqlQuery->execute([$tx_ref]);
    $pendingReg = $sqlQuery->fetch(PDO::FETCH_ASSOC);
    
    $payment_method = $pendingReg['payment_method'] ?? 'chapa';
    
    // Verify payment with appropriate gateway
    $verification = $paymentHandler->verifyPayment($tx_ref, $payment_method);
    
    if ($verification['status'] == 'success' && $verification['data']['status'] == 'success') {
        // Payment successful - complete registration
        try {
            $conn = new Database();
            $conn->conn->beginTransaction();
            
            // Get pending registration data
            $sqlQuery = $conn->conn->prepare("SELECT * FROM pending_registrations WHERE tx_ref = ? AND status = 'pending'");
            $sqlQuery->execute([$tx_ref]);
            $pendingReg = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            
            if ($pendingReg) {
                // Insert into fans table
                $sqlQuery = $conn->conn->prepare("
                    INSERT INTO `fans`(`full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `is_verified`, `status`, `payment_status`, `payment_date`, `tx_ref`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
                ");
                
                $sqlQuery->execute([
                    $pendingReg['full_name'],
                    $pendingReg['email'],
                    $pendingReg['phone'],
                    $pendingReg['password'],
                    $pendingReg['membership_type'],
                    $pendingReg['fan_label'],
                    0,
                    0,
                    'paid',
                    $tx_ref
                ]);
                
                // Update pending registration status
                $sqlQuery = $conn->conn->prepare("UPDATE pending_registrations SET status = 'completed' WHERE tx_ref = ?");
                $sqlQuery->execute([$tx_ref]);
                
                // Record payment transaction
                $sqlQuery = $conn->conn->prepare("
                    INSERT INTO payment_transactions (tx_ref, user_email, amount, currency, payment_method, payment_status, gateway_response, gateway_tx_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $sqlQuery->execute([
                    $tx_ref,
                    $pendingReg['email'],
                    $pendingReg['amount'],
                    'ETB',
                    'chapa',
                    'success',
                    json_encode($verification),
                    $verification['data']['reference'] ?? ''
                ]);
                
                $conn->conn->commit();
                
                $message = "🎉 Payment successful! Your " . ucfirst($pendingReg['membership_type']) . " membership has been activated. Welcome to Wolaita Dicha FC!";
                $status = "success";
                
                // TODO: Send confirmation email here
                
            } else {
                $message = "❌ Registration data not found or already processed.";
                $status = "error";
            }
            
        } catch (Exception $e) {
            if ($conn->conn->inTransaction()) {
                $conn->conn->rollBack();
            }
            $message = "❌ Error processing payment: " . $e->getMessage();
            $status = "error";
        }
        
    } else {
        $message = "❌ Payment verification failed. Please contact support.";
        $status = "error";
    }
} else {
    $message = "❌ Invalid payment reference.";
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Payment Status - Wolaita Dicha FC</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Payment Status</h3>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($status == "success"): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?= $message ?>
                            </div>
                            <div class="mt-4">
                                <a href="pages_login.php" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Login to Your Account
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $message ?>
                            </div>
                            <div class="mt-4">
                                <a href="reg_fans.php" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Try Again
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-3">
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-house me-2"></i>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>