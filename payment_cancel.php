<?php
// Payment cancelled page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Payment Cancelled - Wolaita Dicha FC</title>
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
                        <h3>Payment Cancelled</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Your payment was cancelled. Your registration has not been completed.
                        </div>
                        
                        <p>Don't worry! You can try again anytime.</p>
                        
                        <div class="mt-4">
                            <a href="reg_fans.php" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Try Registration Again
                            </a>
                            <a href="index.php" class="btn btn-outline-secondary ms-2">
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