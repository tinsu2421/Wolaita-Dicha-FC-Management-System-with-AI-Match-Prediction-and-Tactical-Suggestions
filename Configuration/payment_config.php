<?php
/**
 * Payment Configuration for Wolaita Dicha FC
 * Supporting Chapa and Telebirr Payment Gateways (Ethiopian)
 */

// Chapa Configuration (Test Mode)
define('CHAPA_SECRET_KEY', 'CHASECK_TEST-your-secret-key-here'); // Replace with your actual test secret key
define('CHAPA_PUBLIC_KEY', 'CHAPUBK_TEST-your-public-key-here'); // Replace with your actual test public key
define('CHAPA_BASE_URL', 'https://api.chapa.co/v1/');

// Telebirr Configuration (Test Mode)
define('TELEBIRR_APP_ID', 'your-telebirr-app-id'); // Get from Ethio Telecom
define('TELEBIRR_APP_KEY', 'your-telebirr-app-key'); // Get from Ethio Telecom
define('TELEBIRR_SHORT_CODE', 'your-short-code'); // Your business short code
define('TELEBIRR_BASE_URL', 'https://196.188.120.3:38443/'); // Telebirr API URL

// Payment Configuration
define('CURRENCY', 'ETB'); // Ethiopian Birr
define('PAYMENT_SUCCESS_URL', 'http://localhost/Wolaita-Dicha-Fc/payment_success_real.php');
define('PAYMENT_CANCEL_URL', 'http://localhost/Wolaita-Dicha-Fc/payment_cancel.php');
define('PAYMENT_CALLBACK_URL', 'http://localhost/Wolaita-Dicha-Fc/payment_callback.php');

// Membership Prices (in ETB)
$MEMBERSHIP_PRICES = [
    'digital' => 0,      // Free
    'standard' => 500,   // 500 ETB (~$19.99)
    'premium' => 1250,   // 1250 ETB (~$49.99)
    'vip' => 2500        // 2500 ETB (~$99.99)
];

// Payment Methods Available
$PAYMENT_METHODS = [
    'chapa' => [
        'name' => 'Chapa',
        'description' => 'Pay with Bank Cards, Mobile Banking & More',
        'logo' => 'assets/img/chapa-logo.png',
        'enabled' => true
    ],
    'telebirr' => [
        'name' => 'Telebirr',
        'description' => 'Pay with Telebirr Mobile Wallet',
        'logo' => 'assets/img/telebirr-logo.png',
        'enabled' => true
    ]
];

// Test Mode Configuration
define('PAYMENT_TEST_MODE', true); // Set to false for production
define('PAYMENT_FAKE_MODE', true); // Set to true to use fake database instead of real APIs

// Test Credentials (for development only)
if (PAYMENT_TEST_MODE) {
    // These are example test credentials - replace with your actual test keys
    define('CHAPA_TEST_SECRET', 'CHASECK_TEST-example-secret-key');
    define('CHAPA_TEST_PUBLIC', 'CHAPUBK_TEST-example-public-key');
}

?>