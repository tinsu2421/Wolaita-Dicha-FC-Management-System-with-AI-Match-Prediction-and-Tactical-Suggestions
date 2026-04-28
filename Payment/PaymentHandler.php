<?php

require_once __DIR__ . '/../Configuration/payment_config.php';

/**
 * Payment Handler Class for Wolaita Dicha FC
 * Handles Chapa and Telebirr payment gateway integrations
 */
class PaymentHandler {
    
    private $secret_key;
    private $public_key;
    private $base_url;
    
    public function __construct() {
        $this->secret_key = CHAPA_SECRET_KEY;
        $this->public_key = CHAPA_PUBLIC_KEY;
        $this->base_url = CHAPA_BASE_URL;
    }
    
    /**
     * Get membership price
     */
    public function getMembershipPrice($membership_type) {
        $MEMBERSHIP_PRICES = [
            'digital' => 0,      // Free
            'standard' => 500,   // 500 ETB (~$19.99)
            'premium' => 1250,   // 1250 ETB (~$49.99)
            'vip' => 2500        // 2500 ETB (~$99.99)
        ];
        return $MEMBERSHIP_PRICES[$membership_type] ?? 0;
    }
    
    /**
     * Get available payment methods
     */
    public function getPaymentMethods() {
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
        return array_filter($PAYMENT_METHODS, function($method) {
            return $method['enabled'];
        });
    }
    
    /**
     * Initialize Chapa payment
     */
    public function initializeChapaPayment($data) {
        $url = $this->base_url . 'transaction/initialize';
        
        $payment_data = [
            'amount' => $data['amount'],
            'currency' => CURRENCY,
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'tx_ref' => $data['tx_ref'],
            'callback_url' => PAYMENT_CALLBACK_URL,
            'return_url' => PAYMENT_SUCCESS_URL,
            'description' => $data['description'],
            'meta' => [
                'membership_type' => $data['membership_type'],
                'fan_label' => $data['fan_label'],
                'payment_method' => 'chapa'
            ]
        ];
        
        $headers = [
            'Authorization: Bearer ' . $this->secret_key,
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        } else {
            return ['status' => 'error', 'message' => 'Chapa payment initialization failed'];
        }
    }
    
    /**
     * Initialize Telebirr payment
     */
    public function initializeTelebirrPayment($data) {
        $url = TELEBIRR_BASE_URL . 'payment/v1/merchant/preAuthorize';
        
        // Generate timestamp and nonce
        $timestamp = time();
        $nonce = $this->generateNonce();
        
        $payment_data = [
            'appId' => TELEBIRR_APP_ID,
            'appKey' => TELEBIRR_APP_KEY,
            'timestamp' => $timestamp,
            'nonce' => $nonce,
            'notifyUrl' => PAYMENT_CALLBACK_URL,
            'returnUrl' => PAYMENT_SUCCESS_URL,
            'shortCode' => TELEBIRR_SHORT_CODE,
            'subject' => $data['description'],
            'outTradeNo' => $data['tx_ref'],
            'totalAmount' => $data['amount'],
            'timeoutExpress' => '30m', // 30 minutes timeout
            'receiveName' => $data['first_name'] . ' ' . $data['last_name']
        ];
        
        // Generate signature
        $signature = $this->generateTelebirrSignature($payment_data);
        $payment_data['sign'] = $signature;
        
        $headers = [
            'Content-Type: application/json',
            'X-APP-Key: ' . TELEBIRR_APP_KEY
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $result = json_decode($response, true);
            if ($result && $result['code'] == 200) {
                return [
                    'status' => 'success',
                    'data' => [
                        'checkout_url' => $result['data']['toPayUrl'],
                        'prepay_id' => $result['data']['prepayId']
                    ]
                ];
            } else {
                return ['status' => 'error', 'message' => 'Telebirr payment initialization failed: ' . ($result['msg'] ?? 'Unknown error')];
            }
        } else {
            return ['status' => 'error', 'message' => 'Telebirr API connection failed'];
        }
    }
    
    /**
     * Initialize payment based on selected method
     */
    public function initializePayment($data, $payment_method = 'chapa') {
        switch ($payment_method) {
            case 'telebirr':
                return $this->initializeTelebirrPayment($data);
            case 'chapa':
            default:
                return $this->initializeChapaPayment($data);
        }
    }
    
    /**
     * Verify Chapa payment
     */
    public function verifyChapaPayment($tx_ref) {
        $url = $this->base_url . 'transaction/verify/' . $tx_ref;
        
        $headers = [
            'Authorization: Bearer ' . $this->secret_key,
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        } else {
            return ['status' => 'error', 'message' => 'Chapa payment verification failed'];
        }
    }
    
    /**
     * Verify Telebirr payment
     */
    public function verifyTelebirrPayment($tx_ref) {
        $url = TELEBIRR_BASE_URL . 'payment/v1/merchant/query';
        
        $timestamp = time();
        $nonce = $this->generateNonce();
        
        $query_data = [
            'appId' => TELEBIRR_APP_ID,
            'appKey' => TELEBIRR_APP_KEY,
            'timestamp' => $timestamp,
            'nonce' => $nonce,
            'outTradeNo' => $tx_ref
        ];
        
        // Generate signature
        $signature = $this->generateTelebirrSignature($query_data);
        $query_data['sign'] = $signature;
        
        $headers = [
            'Content-Type: application/json',
            'X-APP-Key: ' . TELEBIRR_APP_KEY
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $result = json_decode($response, true);
            if ($result && $result['code'] == 200) {
                return [
                    'status' => 'success',
                    'data' => [
                        'status' => $result['data']['tradeStatus'] == 'TRADE_SUCCESS' ? 'success' : 'failed',
                        'reference' => $result['data']['tradeNo']
                    ]
                ];
            } else {
                return ['status' => 'error', 'message' => 'Telebirr payment verification failed'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Telebirr API connection failed'];
        }
    }
    
    /**
     * Verify payment based on method
     */
    public function verifyPayment($tx_ref, $payment_method = 'chapa') {
        switch ($payment_method) {
            case 'telebirr':
                return $this->verifyTelebirrPayment($tx_ref);
            case 'chapa':
            default:
                return $this->verifyChapaPayment($tx_ref);
        }
    }
    
    /**
     * Generate unique transaction reference
     */
    public function generateTxRef($prefix = 'WDFC') {
        return $prefix . '_' . time() . '_' . rand(1000, 9999);
    }
    
    /**
     * Generate nonce for Telebirr
     */
    private function generateNonce($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Generate signature for Telebirr API
     */
    private function generateTelebirrSignature($data) {
        // Remove sign field if exists
        unset($data['sign']);
        
        // Sort parameters
        ksort($data);
        
        // Create query string
        $query_string = '';
        foreach ($data as $key => $value) {
            if ($value !== '' && $value !== null) {
                $query_string .= $key . '=' . $value . '&';
            }
        }
        $query_string = rtrim($query_string, '&');
        
        // Add app key
        $query_string .= TELEBIRR_APP_KEY;
        
        // Generate SHA256 hash
        return hash('sha256', $query_string);
    }
    
    /**
     * Format amount for display
     */
    public function formatAmount($amount) {
        return number_format($amount, 2) . ' ' . CURRENCY;
    }
    
    /**
     * Get payment method display name
     */
    public function getPaymentMethodName($method) {
        $methods = $this->getPaymentMethods();
        return $methods[$method]['name'] ?? ucfirst($method);
    }
}

?>