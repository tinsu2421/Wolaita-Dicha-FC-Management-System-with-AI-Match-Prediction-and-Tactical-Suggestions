<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Wolaita-Dicha-Fc/php_errors.log');

// Load payment configuration first
require_once __DIR__.'/Configuration/payment_config.php';

// Check if we have pending registration data
if (!isset($_SESSION['pending_registration'])) {
    header('Location: reg_fans.php');
    exit;
}

$pendingReg = $_SESSION['pending_registration'];

// Use fake payment handler if fake mode is enabled
if (defined('PAYMENT_FAKE_MODE') && PAYMENT_FAKE_MODE) {
    require_once __DIR__.'/Payment/FakePaymentHandler.php';
    $paymentHandler = new FakePaymentHandler();
} else {
    require_once __DIR__.'/Payment/PaymentHandler.php';
    $paymentHandler = new PaymentHandler();
}
$amount = $paymentHandler->getMembershipPrice($pendingReg['membership']);
$paymentMethods = $paymentHandler->getPaymentMethods();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_method'])) {
    $selectedMethod = $_POST['payment_method'];
    
    error_log("Payment method form submitted with: " . $selectedMethod);
    
    // Store selected payment method in session
    $_SESSION['selected_payment_method'] = $selectedMethod;
    
    error_log("Session updated, redirecting to process_payment.php");
    
    // Redirect to payment processing
    header('Location: process_payment.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Select Payment Method - Wolaita Dicha FC</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-method-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0,123,255,0.1);
        }
        .payment-method-card.selected {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        .payment-logo {
            width: 60px;
            height: 40px;
            object-fit: contain;
        }
        .amount-display {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="bi bi-credit-card me-2"></i>Select Payment Method</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- Registration Summary -->
                        <div class="amount-display">
                            <h4>Registration Summary</h4>
                            <p class="mb-2"><strong><?= htmlspecialchars($pendingReg['fullname']) ?></strong></p>
                            <p class="mb-2"><?= ucfirst($pendingReg['membership']) ?> Membership (<?= ucfirst($pendingReg['fan_label']) ?>)</p>
                            <h2 class="mb-0"><?= $paymentHandler->formatAmount($amount) ?></h2>
                        </div>

                        <form method="POST" id="paymentMethodForm">
                            <h5 class="mb-3">Choose your preferred payment method:</h5>
                            
                            <?php foreach ($paymentMethods as $method_key => $method): ?>
                            <div class="payment-method-card" onclick="selectPaymentMethod('<?= $method_key ?>')">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <input type="radio" name="payment_method" value="<?= $method_key ?>" id="<?= $method_key ?>" class="form-check-input" onchange="enableProceedButton()">
                                    </div>
                                    <div class="col-3 text-center">
                                        <?php if ($method_key == 'chapa'): ?>
                                            <div class="payment-logo d-flex align-items-center justify-content-center" style="background: #007bff; color: white; border-radius: 8px; height: 40px;">
                                                <strong>CHAPA</strong>
                                            </div>
                                        <?php elseif ($method_key == 'telebirr'): ?>
                                            <div class="payment-logo d-flex align-items-center justify-content-center" style="background: #ff6b35; color: white; border-radius: 8px; height: 40px;">
                                                <strong>telebirr</strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-7">
                                        <h6 class="mb-1"><?= $method['name'] ?></h6>
                                        <small class="text-muted"><?= $method['description'] ?></small>
                                        
                                        <?php if ($method_key == 'chapa'): ?>
                                            <div class="mt-2">
                                                <span class="badge bg-primary me-1">Bank Cards</span>
                                                <span class="badge bg-success me-1">Mobile Banking</span>
                                                <span class="badge bg-info">CBE Birr</span>
                                            </div>
                                        <?php elseif ($method_key == 'telebirr'): ?>
                                            <div class="mt-2">
                                                <span class="badge bg-warning me-1">Mobile Wallet</span>
                                                <span class="badge bg-secondary">USSD</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg" id="proceedBtn" disabled>
                                    <i class="bi bi-arrow-right me-2"></i>
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="reg_fans.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Registration
                            </a>
                        </div>
                        
                        <!-- Security Notice -->
                        <div class="alert alert-info mt-4">
                            <i class="bi bi-shield-check me-2"></i>
                            <strong>Secure Payment:</strong> Your payment information is encrypted and secure. We do not store your payment details.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add debugging
        console.log('Payment method selection page loaded');
        
        function selectPaymentMethod(method) {
            console.log('selectPaymentMethod called with:', method);
            
            // Remove selected class from all cards
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
            
            // Check the radio button
            document.getElementById(method).checked = true;
            
            // Enable proceed button
            enableProceedButton();
        }
        
        function enableProceedButton() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            const proceedBtn = document.getElementById('proceedBtn');
            proceedBtn.disabled = !selectedMethod;
            console.log('Proceed button enabled:', !proceedBtn.disabled);
        }
        
        // Handle radio button clicks directly
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up event listeners');
            
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    console.log('Radio button changed:', this.value);
                    enableProceedButton();
                    // Also update the visual selection
                    document.querySelectorAll('.payment-method-card').forEach(card => {
                        card.classList.remove('selected');
                    });
                    this.closest('.payment-method-card').classList.add('selected');
                });
            });
            
            // Add form submission debugging
            document.getElementById('paymentMethodForm').addEventListener('submit', function(e) {
                console.log('Form submitted');
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!selectedMethod) {
                    e.preventDefault();
                    alert('Please select a payment method');
                    console.log('Form submission prevented - no method selected');
                    return false;
                }
                console.log('Selected method:', selectedMethod.value);
                console.log('Form will be submitted to process_payment.php');
                
                // Show loading state
                document.getElementById('proceedBtn').innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
                document.getElementById('proceedBtn').disabled = true;
            });
        });
    </script>
</body>
</html>