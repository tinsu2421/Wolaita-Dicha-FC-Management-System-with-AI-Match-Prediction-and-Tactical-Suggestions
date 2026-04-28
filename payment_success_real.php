<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Wolaita-Dicha-Fc/php_errors.log');

// Load payment configuration first
require_once __DIR__.'/Configuration/payment_config.php';

// Use fake payment handler if fake mode is enabled
if (defined('PAYMENT_FAKE_MODE') && PAYMENT_FAKE_MODE) {
    require_once __DIR__.'/Payment/FakePaymentHandler.php';
    $paymentHandler = new FakePaymentHandler();
} else {
    require_once __DIR__.'/Payment/PaymentHandler.php';
    $paymentHandler = new PaymentHandler();
}

require_once __DIR__.'/Configuration/Dbconfig.php';
require_once __DIR__.'/Auth/auth.php';

// Include PHPMailer for email notifications
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

include 'MailerSrc/PHPMailer/src/Exception.php';
include 'MailerSrc/PHPMailer/src/SMTP.php';
include 'MailerSrc/PHPMailer/src/PHPMailer.php';
include 'MailerSrc/PHPMailer/constant.php';

$payment_success = false;
$error_message = '';
$payment_details = null;

try {
    // Get transaction reference from URL or session
    $tx_ref = $_GET['tx_ref'] ?? $_SESSION['payment_success']['tx_ref'] ?? null;
    
    if (!$tx_ref) {
        throw new Exception("Transaction reference not provided");
    }
    
    $paymentHandler = new PaymentHandler();
    $db = new Database();
    
    // Check if we already have success data in session
    if (isset($_SESSION['payment_success']) && $_SESSION['payment_success']['tx_ref'] === $tx_ref) {
        $payment_success = true;
        $payment_details = $_SESSION['payment_success'];
        unset($_SESSION['payment_success']); // Clear session data
    } else {
        // Verify payment status from database
        if (defined('PAYMENT_FAKE_MODE') && PAYMENT_FAKE_MODE) {
            // For fake payments, check fake transaction tables
            $transaction = null;
            
            // Try Chapa transactions first
            $sqlQuery = $db->conn->prepare("
                SELECT 
                    fct.tx_ref, fct.amount, fct.email, fct.first_name, fct.last_name, fct.status,
                    pr.full_name, pr.membership_type, pr.fan_label, pr.phone, pr.password
                FROM fake_chapa_transactions fct 
                LEFT JOIN pending_registrations pr ON fct.tx_ref = pr.tx_ref 
                WHERE fct.tx_ref = ?
            ");
            $sqlQuery->execute([$tx_ref]);
            $transaction = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            
            // If not found in Chapa, try Telebirr transactions
            if (!$transaction) {
                $sqlQuery = $db->conn->prepare("
                    SELECT 
                        ftt.tx_ref, ftt.amount, ftt.email, ftt.first_name, ftt.last_name, ftt.status,
                        pr.full_name, pr.membership_type, pr.fan_label, pr.phone, pr.password
                    FROM fake_telebirr_transactions ftt 
                    LEFT JOIN pending_registrations pr ON ftt.tx_ref = pr.tx_ref 
                    WHERE ftt.tx_ref = ?
                ");
                $sqlQuery->execute([$tx_ref]);
                $transaction = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            // For real payments, check payment_transactions table
            $sqlQuery = $db->conn->prepare("
                SELECT pt.*, pr.full_name, pr.membership_type, pr.fan_label, pr.phone, pr.password
                FROM payment_transactions pt 
                JOIN pending_registrations pr ON pt.tx_ref = pr.tx_ref 
                WHERE pt.tx_ref = ?
            ");
            $sqlQuery->execute([$tx_ref]);
            $transaction = $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        
        if (!$transaction) {
            throw new Exception("Transaction not found");
        }
        
        $payment_status = $transaction['status'] ?? $transaction['payment_status'] ?? 'pending';
        
        if ($payment_status === 'success') {
            // Payment already successful, complete registration if not done
            $payment_success = true;
            
            // Check if fan already registered
            $sqlQuery = $db->conn->prepare("SELECT id FROM fans WHERE tx_ref = ?");
            $sqlQuery->execute([$tx_ref]);
            $existing_fan = $sqlQuery->fetch(PDO::FETCH_ASSOC);
            
            if (!$existing_fan) {
                // Complete registration
                $db->conn->beginTransaction();
                
                try {
                    // Insert into fans table
                    $sqlQuery = $db->conn->prepare("
                        INSERT INTO `fans`(`full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `is_verified`, `status`, `payment_status`, `payment_date`, `tx_ref`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'paid', NOW(), ?)
                    ");
                    
                    $sqlQuery->execute([
                        $transaction['full_name'],
                        $transaction['email'],
                        $transaction['phone'] ?? '0000000000',
                        $transaction['password'] ?? password_hash('default123', PASSWORD_DEFAULT),
                        $transaction['membership_type'],
                        $transaction['fan_label'],
                        0, // is_verified
                        1, // status (active)
                        $tx_ref
                    ]);
                    
                    // Update pending registration status
                    $sqlQuery = $db->conn->prepare("UPDATE pending_registrations SET status = 'completed' WHERE tx_ref = ?");
                    $sqlQuery->execute([$tx_ref]);
                    
                    // Update payment transaction status if using real payments
                    if (!defined('PAYMENT_FAKE_MODE') || !PAYMENT_FAKE_MODE) {
                        $sqlQuery = $db->conn->prepare("
                            UPDATE payment_transactions 
                            SET payment_status = 'success', updated_at = NOW() 
                            WHERE tx_ref = ?
                        ");
                        $sqlQuery->execute([$tx_ref]);
                    }
                    
                    $db->conn->commit();
                    
                    // Send congratulation email
                    sendCongratulationEmail($transaction);
                    
                } catch (Exception $e) {
                    $db->conn->rollBack();
                    error_log("Registration completion error: " . $e->getMessage());
                    // Continue anyway, payment was successful
                }
            }
            
            $payment_details = [
                'tx_ref' => $transaction['tx_ref'],
                'amount' => $transaction['amount'],
                'membership' => $transaction['membership_type'],
                'email' => $transaction['email'],
                'name' => $transaction['full_name'],
                'fan_label' => $transaction['fan_label']
            ];
            
        } elseif ($payment_status === 'pending') {
            // Payment is still pending, try to verify with gateway
            $verification_result = $paymentHandler->verifyPayment($tx_ref, $transaction['payment_method']);
            
            if ($verification_result['status'] === 'success' && 
                (isset($verification_result['data']['status']) && $verification_result['data']['status'] === 'success')) {
                
                // Payment successful - complete registration
                $db->conn->beginTransaction();
                
                try {
                    // Get pending registration data
                    $sqlQuery = $db->conn->prepare("SELECT * FROM pending_registrations WHERE tx_ref = ?");
                    $sqlQuery->execute([$tx_ref]);
                    $pendingReg = $sqlQuery->fetch(PDO::FETCH_ASSOC);
                    
                    if ($pendingReg) {
                        // Insert into fans table
                        $sqlQuery = $db->conn->prepare("
                            INSERT INTO `fans`(`full_name`, `email`, `phone`, `password`, `membership_type`, `fan_label`, `is_verified`, `status`, `payment_status`, `payment_date`, `tx_ref`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'paid', NOW(), ?)
                        ");
                        
                        $sqlQuery->execute([
                            $pendingReg['full_name'],
                            $pendingReg['email'],
                            $pendingReg['phone'],
                            $pendingReg['password'],
                            $pendingReg['membership_type'],
                            $pendingReg['fan_label'],
                            0, // is_verified
                            1, // status (active)
                            $tx_ref
                        ]);
                        
                        // Update pending registration status
                        $sqlQuery = $db->conn->prepare("UPDATE pending_registrations SET status = 'completed' WHERE tx_ref = ?");
                        $sqlQuery->execute([$tx_ref]);
                        
                        // Update payment transaction
                        $sqlQuery = $db->conn->prepare("
                            UPDATE payment_transactions 
                            SET payment_status = 'success', gateway_response = ?, updated_at = NOW() 
                            WHERE tx_ref = ?
                        ");
                        
                        $sqlQuery->execute([json_encode($verification_result), $tx_ref]);
                        
                        $db->conn->commit();
                        
                        // Send congratulation email
                        sendCongratulationEmail($pendingReg);
                        
                        $payment_success = true;
                        $payment_details = [
                            'tx_ref' => $tx_ref,
                            'amount' => $pendingReg['amount'],
                            'membership' => $pendingReg['membership_type'],
                            'email' => $pendingReg['email'],
                            'name' => $pendingReg['full_name'],
                            'fan_label' => $pendingReg['fan_label']
                        ];
                    }
                    
                } catch (Exception $e) {
                    $db->conn->rollBack();
                    throw $e;
                }
            } else {
                throw new Exception("Payment verification failed");
            }
        } else {
            throw new Exception("Payment failed or was cancelled");
        }
    }
    
} catch (Exception $e) {
    error_log("Payment success page error: " . $e->getMessage());
    $error_message = $e->getMessage();
}

function sendCongratulationEmail($pendingReg) {
    try {
        $mail = new PHPMailer(true);
        
        // Server Setting
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom(EMAIL, 'Wolaita Dicha FC');
        $mail->addAddress($pendingReg['email'], $pendingReg['full_name']);
        $mail->isHTML(true);
        $mail->Subject = "🎉 Welcome to Wolaita Dicha FC - Payment Successful!";

        // Create membership benefits based on type
        $membershipBenefits = getMembershipBenefits($pendingReg['membership_type']);

        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f8f9fa; padding: 20px;">
            <div style="background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                
                <!-- Header with Logo -->
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #204060; margin: 0; font-size: 28px;">🎉 Welcome to Wolaita Dicha FC!</h1>
                    <p style="color: #666; font-size: 16px; margin: 10px 0 0 0;">The Bees of Tona Family</p>
                </div>

                <!-- Welcome Message -->
                <div style="background: linear-gradient(135deg, #204060, #3a6b8c); color: white; padding: 25px; border-radius: 8px; margin-bottom: 25px;">
                    <h2 style="margin: 0 0 15px 0; font-size: 24px;">🏆 Payment Successful!</h2>
                    <p style="margin: 0; font-size: 16px; line-height: 1.5;">
                        Congratulations, ' . htmlspecialchars($pendingReg['full_name']) . '! Your payment has been processed successfully and you are now a 
                        <strong>' . ucfirst($pendingReg['fan_label']) . '</strong> with <strong>' . ucfirst($pendingReg['membership_type']) . ' Membership</strong>!
                    </p>
                </div>

                <!-- Payment Details -->
                <div style="background-color: #e8f5e9; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #28a745;">
                    <h3 style="color: #155724; margin: 0 0 15px 0;">💳 Payment Details:</h3>
                    <p style="margin: 5px 0; color: #155724;"><strong>Transaction ID:</strong> ' . $pendingReg['tx_ref'] . '</p>
                    <p style="margin: 5px 0; color: #155724;"><strong>Amount:</strong> ' . number_format($pendingReg['amount'], 2) . ' ETB</p>
                    <p style="margin: 5px 0; color: #155724;"><strong>Membership:</strong> ' . ucfirst($pendingReg['membership_type']) . '</p>
                </div>

                <!-- Membership Benefits -->
                <div style="background-color: #fff3cd; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ffc107;">
                    <h3 style="color: #856404; margin: 0 0 15px 0;">🎁 Your Membership Benefits:</h3>
                    <ul style="margin: 0; padding-left: 20px; color: #856404;">
                        <li>' . implode('</li><li>', $membershipBenefits) . '</li>
                    </ul>
                </div>

                <!-- Footer -->
                <div style="text-align: center; padding-top: 20px; border-top: 1px solid #dee2e6;">
                    <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">
                        Thank you for joining the Wolaita Dicha FC family!
                    </p>
                    <p style="color: #666; font-size: 14px; margin: 0;">
                        <strong>የጦና ንቦች - The Bees of Tona</strong><br>
                        <em>Passion. Pride. Wolaita Dicha.</em>
                    </p>
                </div>

            </div>
        </div>';

        $mail->AltBody = "Welcome to Wolaita Dicha FC, {$pendingReg['full_name']}! Your {$pendingReg['membership_type']} membership payment has been processed successfully.";
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->send();
        error_log("Congratulation email sent successfully to: " . $pendingReg['email']);
        
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
    }
}

function getMembershipBenefits($membership_type) {
    $benefits = [
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
                            
                            <!-- Payment Details -->
                            <div class="payment-details">
                                <h4><i class="bi bi-person-check me-2"></i>Registration Complete</h4>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> <?= htmlspecialchars($payment_details['name']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($payment_details['email']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Membership:</strong> <?= ucfirst($payment_details['membership']) ?></p>
                                        <p><strong>Amount Paid:</strong> <?= number_format($payment_details['amount'], 2) ?> ETB</p>
                                    </div>
                                </div>
                                <p class="mt-3"><strong>Transaction ID:</strong> <?= htmlspecialchars($payment_details['tx_ref']) ?></p>
                            </div>
                            
                            <!-- Membership Benefits -->
                            <div class="membership-benefits">
                                <h5><i class="bi bi-gift me-2"></i>Your Membership Benefits</h5>
                                <ul class="list-unstyled mt-3">
                                    <?php 
                                    $benefits = getMembershipBenefits($payment_details['membership']);
                                    foreach ($benefits as $benefit): 
                                    ?>
                                        <li><i class="bi bi-check-circle text-success me-2"></i><?= $benefit ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="bi bi-envelope me-2"></i>
                                A confirmation email has been sent to your email address with all the details.
                            </div>
                            
                            <div class="mt-4">
                                <a href="index.php" class="btn btn-primary btn-lg me-3">
                                    <i class="bi bi-house me-2"></i>Go to Homepage
                                </a>
                                <a href="pages_login.php" class="btn btn-outline-primary btn-lg">
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
</body>
</html>