<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Wolaita-Dicha-Fc/php_errors.log');

// Load payment configuration first
require_once __DIR__.'/Configuration/payment_config.php';
require_once __DIR__.'/Configuration/Dbconfig.php';
require_once __DIR__.'/Payment/FakePaymentHandler.php';

$payment_success = false;
$error_message = '';
$payment_details = null;

try {
    // Get transaction reference from URL
    $tx_ref = $_GET['tx_ref'] ?? null;
    $status = $_GET['status'] ?? 'unknown';
    
    if (!$tx_ref) {
        throw new Exception("Transaction reference not provided");
    }
    
    error_log("Processing payment success for TX Ref: $tx_ref, Status: $status");
    
    $fakePaymentHandler = new FakePaymentHandler();
    $db = new Database();
    
    if ($status === 'success') {
        // Payment was successful, complete the registration
        $db->conn->beginTransaction();
        
        try {
            // Get transaction details from fake tables
            $transaction = null;
            
            // Try Chapa transactions first
            $sqlQuery = $db->conn->prepare("
                SELECT fct.tx_ref, fct.amount, fct.email, fct.first_name, fct.last_name, fct.phone_number, fct.status,
                       pr.password, pr.fan_label, pr.membership_type
                FROM fake_chapa_transactions fct 
                LEFT JOIN pending_registrations pr ON fct.tx_ref = pr.tx_ref 
                WHERE fct.tx_ref = ? AND fct.status = 'success'
            ");
            $sqlQuery->execute([$tx_ref]);
            $transaction = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            
            // If not found in Chapa, try Telebirr transactions
            if (!$transaction) {
                $sqlQuery = $db->conn->prepare("
                    SELECT ftt.tx_ref, ftt.amount, ftt.email, ftt.first_name, ftt.last_name, ftt.phone_number, ftt.status,
                           pr.password, pr.fan_label, pr.membership_type
                    FROM fake_telebirr_transactions ftt 
                    LEFT JOIN pending_registrations pr ON ftt.tx_ref = pr.tx_ref 
                    WHERE ftt.tx_ref = ? AND ftt.status = 'success'
                ");
                $sqlQuery->execute([$tx_ref]);
                $transaction = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            }
            
            if (!$transaction) {
                throw new Exception("Successful transaction not found");
            }
            
            // Check if fan already registered
            $sqlQuery = $db->conn->prepare("SELECT id FROM fans WHERE tx_ref = ?");
            $sqlQuery->execute([$tx_ref]);
            $existing_fan = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            
            if (!$existing_fan) {
                // Insert into fans table
                $sqlQuery = $db->conn->prepare("
                    INSERT INTO `fans`(`full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `is_verified`, `status`, `payment_status`, `payment_date`, `tx_ref`) 
                    VALUES (?, ?, ?, ?, ?, ?, 0, 1, 'paid', NOW(), ?)
                ");
                
                $sqlQuery->execute([
                    $transaction['first_name'] . ' ' . $transaction['last_name'],
                    $transaction['email'],
                    $transaction['phone_number'],
                    $transaction['password'] ?? password_hash('default123', PASSWORD_DEFAULT),
                    $transaction['membership_type'] ?? 'standard',
                    $transaction['fan_label'] ?? 'supporter',
                    $tx_ref
                ]);
                
                error_log("Fan registered successfully with TX Ref: $tx_ref");
            }
            
            // Update pending registration status
            $sqlQuery = $db->conn->prepare("UPDATE pending_registrations SET status = 'completed' WHERE tx_ref = ?");
            $sqlQuery->execute([$tx_ref]);
            
            $db->conn->commit();
            
            $payment_success = true;
            $payment_details = [
                'tx_ref' => $transaction['tx_ref'],
                'amount' => $transaction['amount'],
                'membership' => $transaction['membership_type'] ?? 'standard',
                'email' => $transaction['email'],
                'name' => $transaction['first_name'] . ' ' . $transaction['last_name'],
                'fan_label' => $transaction['fan_label'] ?? 'supporter'
            ];
            
            error_log("Payment success processed for: " . $payment_details['email']);
            
        } catch (Exception $e) {
            $db->conn->rollBack();
            throw $e;
        }
        
    } else {
        throw new Exception("Payment was not successful. Status: $status");
    }
    
} catch (Exception $e) {
    error_log("Payment success page error: " . $e->getMessage());
    $error_message = $e->getMessage();
}

function getMembershipBenefits($membership_type) {
    $benefits = [
        'digital' => [
            'Access to digital content',
            'Monthly newsletter',
            'Fan community access'
        ],
        'standard' => [
            'All digital membership benefits',
            '10% discount on club merchandise',
            'Priority ticket booking access',
            'Exclusive match highlights',
            'Monthly newsletter and updates'
        ],
        'premium' => [
            'All standard membership benefits',
            '20% discount on club merchandise',
            'Behind-the-scenes exclusive content',
            'Player meet & greet opportunities',
            'Training session access',
            'Premium fan community access'
        ],
        'vip' => [
            'All premium membership benefits',
            '30% discount on club merchandise',
            'VIP match day experience',
            'Direct access to coaching staff',
            'Annual club dinner invitation',
            'Personalized jersey with your name',
            'Exclusive VIP lounge access'
        ]
    ];
    
    return $benefits[$membership_type] ?? $benefits['standard'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Payment <?= $payment_success ? 'Successful' : 'Failed' ?> - Wolaita Dicha FC</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        .success-animation {
            animation: bounce 1s ease-in-out;
        }
        @keyframes bounce {
            0%, 20%, 60%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            80% { transform: translateY(-10px); }
        }
        .payment-details {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }
        .membership-benefits {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .receipt-section {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
        }
        .print-btn {
            background: #6c757d;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        @media print {
            .no-print { display: none !important; }
            .receipt-section { border: 2px solid #000; }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        
                        <?php if ($payment_success && $payment_details): ?>
                            <!-- Success Message -->
                            <div class="success-animation">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            
                            <h2 class="text-success mt-3">🎉 Payment Successful!</h2>
                            <p class="lead">Welcome to the Wolaita Dicha FC family!</p>
                            
                            <!-- Payment Receipt -->
                            <div class="receipt-section" id="receipt">
                                <h4><i class="bi bi-receipt me-2"></i>Payment Receipt</h4>
                                <hr>
                                <div class="row text-start">
                                    <div class="col-6">
                                        <p><strong>Receipt #:</strong> <?= htmlspecialchars($payment_details['tx_ref']) ?></p>
                                        <p><strong>Name:</strong> <?= htmlspecialchars($payment_details['name']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($payment_details['email']) ?></p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Date:</strong> <?= date('Y-m-d H:i:s') ?></p>
                                        <p><strong>Membership:</strong> <?= ucfirst($payment_details['membership']) ?></p>
                                        <p><strong>Amount:</strong> <?= number_format($payment_details['amount'], 2) ?> ETB</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <h5 class="text-success">✅ PAYMENT CONFIRMED</h5>
                                    <p class="mb-0"><strong>Status:</strong> Paid & Registered</p>
                                </div>
                            </div>
                            
                            <!-- Payment Details -->
                            <div class="payment-details">
                                <h4><i class="bi bi-person-check me-2"></i>Registration Complete</h4>
                                <p class="mt-3">You are now a <strong><?= ucfirst($payment_details['fan_label']) ?></strong> with <strong><?= ucfirst($payment_details['membership']) ?> Membership</strong>!</p>
                                <p><strong>Transaction ID:</strong> <?= htmlspecialchars($payment_details['tx_ref']) ?></p>
                            </div>
                            
                            <!-- Membership Benefits -->
                            <div class="membership-benefits">
                                <h5><i class="bi bi-gift me-2"></i>Your Membership Benefits</h5>
                                <ul class="list-unstyled mt-3 text-start">
                                    <?php 
                                    $benefits = getMembershipBenefits($payment_details['membership']);
                                    foreach ($benefits as $benefit): 
                                    ?>
                                        <li><i class="bi bi-check-circle text-success me-2"></i><?= $benefit ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Next Steps:</strong> You can now login to your account and access all membership benefits.
                            </div>
                            
                            <div class="mt-4 no-print">
                                <button onclick="window.print()" class="btn btn-secondary me-3">
                                    <i class="bi bi-printer me-2"></i>Print Receipt
                                </button>
                                <a href="index.php" class="btn btn-primary me-3">
                                    <i class="bi bi-house me-2"></i>Go to Homepage
                                </a>
                                <a href="pages_login.php" class="btn btn-outline-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to Account
                                </a>
                            </div>
                            
                        <?php else: ?>
                            <!-- Error Message -->
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                            <h2 class="text-danger mt-3">Payment Processing Error</h2>
                            <p class="lead">There was an issue processing your payment.</p>
                            
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($error_message ?: 'Unknown error occurred') ?>
                            </div>
                            
                            <div class="mt-4">
                                <a href="reg_fans.php" class="btn btn-primary btn-lg me-3">
                                    <i class="bi bi-arrow-repeat me-2"></i>Try Again
                                </a>
                                <a href="index.php" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-house me-2"></i>Go to Homepage
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to top on page load
        window.onload = function() {
            window.scrollTo(0, 0);
        };
    </script>
</body>
</html>