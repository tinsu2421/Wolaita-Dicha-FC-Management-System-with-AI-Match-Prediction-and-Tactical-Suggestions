<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/Configuration/payment_config.php';
require_once __DIR__.'/Payment/FakePaymentHandler.php';
require_once __DIR__.'/Configuration/Dbconfig.php';

$tx_ref = $_GET['tx_ref'] ?? '';

if (empty($tx_ref)) {
    die('Invalid transaction reference');
}

$fakePaymentHandler = new FakePaymentHandler();

// Get transaction details
$db = new Database();
$stmt = $db->conn->prepare("SELECT * FROM fake_chapa_transactions WHERE tx_ref = ?");
$stmt->execute([$tx_ref]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {
    die('Transaction not found');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'pay') {
        // Simulate successful payment
        $fakePaymentHandler->completePayment($tx_ref, 'success');
        header('Location: payment_success_fake.php?tx_ref=' . $tx_ref . '&status=success');
        exit;
    } elseif ($action === 'cancel') {
        // Simulate cancelled payment
        $fakePaymentHandler->completePayment($tx_ref, 'cancelled');
        header('Location: payment_cancel.php?tx_ref=' . $tx_ref . '&status=cancelled');
        exit;
    } elseif ($action === 'fail') {
        // Simulate failed payment
        $fakePaymentHandler->completePayment($tx_ref, 'failed');
        header('Location: payment_cancel.php?tx_ref=' . $tx_ref . '&status=failed');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Fake Chapa Checkout - Testing Mode</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        .fake-gateway {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .payment-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            background: white;
        }
        .amount-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-pay {
            background: #28a745;
            border-color: #28a745;
            padding: 15px 30px;
            font-size: 18px;
        }
        .btn-fail {
            background: #dc3545;
            border-color: #dc3545;
            padding: 10px 20px;
        }
        .btn-cancel {
            background: #6c757d;
            border-color: #6c757d;
            padding: 10px 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <!-- Fake Gateway Header -->
                <div class="fake-gateway text-center">
                    <h2><i class="bi bi-credit-card me-2"></i>FAKE CHAPA GATEWAY</h2>
                    <p class="mb-0">Testing Mode - No Real Money Involved</p>
                </div>
                
                <div class="payment-card">
                    <h4 class="text-center mb-4">Complete Your Payment</h4>
                    
                    <!-- Transaction Details -->
                    <div class="amount-display">
                        <h3 class="text-primary"><?= $fakePaymentHandler->formatAmount($transaction['amount']) ?></h3>
                        <p class="mb-1"><strong><?= htmlspecialchars($transaction['first_name'] . ' ' . $transaction['last_name']) ?></strong></p>
                        <p class="mb-0 text-muted"><?= htmlspecialchars($transaction['description']) ?></p>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <strong>Email:</strong><br>
                            <span class="text-muted"><?= htmlspecialchars($transaction['email']) ?></span>
                        </div>
                        <div class="col-6">
                            <strong>Phone:</strong><br>
                            <span class="text-muted"><?= htmlspecialchars($transaction['phone_number']) ?></span>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <strong>Transaction ID:</strong><br>
                            <span class="text-muted"><?= htmlspecialchars($transaction['tx_ref']) ?></span>
                        </div>
                        <div class="col-6">
                            <strong>Reference:</strong><br>
                            <span class="text-muted"><?= htmlspecialchars($transaction['reference']) ?></span>
                        </div>
                    </div>
                    
                    <!-- Fake Payment Actions -->
                    <form method="POST" class="text-center">
                        <div class="d-grid gap-3">
                            <button type="submit" name="action" value="pay" class="btn btn-success btn-pay">
                                <i class="bi bi-check-circle me-2"></i>
                                Simulate Successful Payment
                            </button>
                            
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" name="action" value="fail" class="btn btn-danger btn-fail w-100">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Simulate Failed Payment
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" name="action" value="cancel" class="btn btn-secondary btn-cancel w-100">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        Cancel Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Testing Instructions -->
                    <div class="alert alert-info mt-4">
                        <h6><i class="bi bi-info-circle me-2"></i>Testing Instructions:</h6>
                        <ul class="mb-0">
                            <li><strong>Successful Payment:</strong> Click green button to simulate successful payment</li>
                            <li><strong>Failed Payment:</strong> Click red button to simulate payment failure</li>
                            <li><strong>Cancel Payment:</strong> Click gray button to cancel the transaction</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>