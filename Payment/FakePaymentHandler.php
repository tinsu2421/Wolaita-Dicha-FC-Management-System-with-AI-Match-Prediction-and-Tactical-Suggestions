<?php

require_once __DIR__ . '/../Configuration/payment_config.php';
require_once __DIR__ . '/../Configuration/Dbconfig.php';

/**
 * Fake Payment Handler Class for Wolaita Dicha FC
 * Simulates Chapa and Telebirr payment gateway responses using database
 * For testing purposes only - does not make real API calls
 */
class FakePaymentHandler {
    
    private $db;
    private $secret_key;
    private $public_key;
    private $base_url;
    
    public function __construct() {
        $this->db = new Database();
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
                'name' => 'Chapa (Fake)',
                'description' => 'Fake Chapa - Testing Mode',
                'logo' => 'assets/img/chapa-logo.png',
                'enabled' => true
            ],
            'telebirr' => [
                'name' => 'Telebirr (Fake)',
                'description' => 'Fake Telebirr - Testing Mode',
                'logo' => 'assets/img/telebirr-logo.png',
                'enabled' => true
            ]
        ];
        return array_filter($PAYMENT_METHODS, function($method) {
            return $method['enabled'];
        });
    }
    
    /**
     * Initialize fake Chapa payment
     */
    public function initializeChapaPayment($data) {
        try {
            // Generate fake checkout URL
            $checkout_url = "http://localhost/Wolaita-Dicha-Fc/fake_chapa_checkout.php?tx_ref=" . $data['tx_ref'];
            $reference = 'CH_FAKE_' . time() . '_' . rand(1000, 9999);
            
            // Store in fake Chapa transactions table
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_chapa_transactions 
                (tx_ref, amount, currency, email, first_name, last_name, phone_number, description, checkout_url, reference, meta_data, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
            ");
            
            $meta_data = json_encode([
                'membership_type' => $data['membership_type'],
                'fan_label' => $data['fan_label'],
                'payment_method' => 'chapa'
            ]);
            
            $stmt->execute([
                $data['tx_ref'],
                $data['amount'],
                'ETB',
                $data['email'],
                $data['first_name'],
                $data['last_name'],
                $data['phone_number'],
                $data['description'],
                $checkout_url,
                $reference,
                $meta_data
            ]);
            
            // Store fake response
            $response_data = json_encode([
                'status' => 'success',
                'message' => 'Hosted Link',
                'data' => [
                    'checkout_url' => $checkout_url
                ]
            ]);
            
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_payment_responses (tx_ref, gateway, response_type, response_data, http_code) 
                VALUES (?, 'chapa', 'initialize', ?, 200)
            ");
            $stmt->execute([$data['tx_ref'], $response_data]);
            
            return [
                'status' => 'success',
                'message' => 'Hosted Link',
                'data' => [
                    'checkout_url' => $checkout_url
                ]
            ];
            
        } catch (Exception $e) {
            error_log("Fake Chapa initialization error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Fake Chapa payment initialization failed'];
        }
    }
    
    /**
     * Initialize fake Telebirr payment
     */
    public function initializeTelebirrPayment($data) {
        try {
            // Generate fake checkout URL and prepay ID
            $checkout_url = "http://localhost/Wolaita-Dicha-Fc/fake_telebirr_checkout.php?tx_ref=" . $data['tx_ref'];
            $prepay_id = 'TB_FAKE_' . time() . '_' . rand(1000, 9999);
            $trade_no = 'TRADE_' . time() . '_' . rand(10000, 99999);
            
            // Store in fake Telebirr transactions table
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_telebirr_transactions 
                (tx_ref, amount, currency, email, first_name, last_name, phone_number, description, checkout_url, prepay_id, trade_no, meta_data, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
            ");
            
            $meta_data = json_encode([
                'membership_type' => $data['membership_type'],
                'fan_label' => $data['fan_label'],
                'payment_method' => 'telebirr'
            ]);
            
            $stmt->execute([
                $data['tx_ref'],
                $data['amount'],
                'ETB',
                $data['email'],
                $data['first_name'],
                $data['last_name'],
                $data['phone_number'],
                $data['description'],
                $checkout_url,
                $prepay_id,
                $trade_no,
                $meta_data
            ]);
            
            // Store fake response
            $response_data = json_encode([
                'code' => 200,
                'msg' => 'success',
                'data' => [
                    'toPayUrl' => $checkout_url,
                    'prepayId' => $prepay_id
                ]
            ]);
            
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_payment_responses (tx_ref, gateway, response_type, response_data, http_code) 
                VALUES (?, 'telebirr', 'initialize', ?, 200)
            ");
            $stmt->execute([$data['tx_ref'], $response_data]);
            
            return [
                'status' => 'success',
                'data' => [
                    'checkout_url' => $checkout_url,
                    'prepay_id' => $prepay_id
                ]
            ];
            
        } catch (Exception $e) {
            error_log("Fake Telebirr initialization error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Fake Telebirr payment initialization failed'];
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
     * Verify fake Chapa payment
     */
    public function verifyChapaPayment($tx_ref) {
        try {
            // Get transaction from fake database
            $stmt = $this->db->conn->prepare("SELECT * FROM fake_chapa_transactions WHERE tx_ref = ?");
            $stmt->execute([$tx_ref]);
            $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$transaction) {
                return ['status' => 'error', 'message' => 'Transaction not found'];
            }
            
            // Create fake verification response
            $response_data = [
                'status' => 'success',
                'message' => 'Payment details',
                'data' => [
                    'first_name' => $transaction['first_name'],
                    'last_name' => $transaction['last_name'],
                    'email' => $transaction['email'],
                    'currency' => $transaction['currency'],
                    'amount' => $transaction['amount'],
                    'charge' => round($transaction['amount'] * 0.05, 2), // 5% fake charge
                    'mode' => 'test',
                    'method' => 'fake_chapa',
                    'type' => 'payment',
                    'status' => $transaction['status'],
                    'reference' => $transaction['reference'],
                    'tx_ref' => $transaction['tx_ref'],
                    'customization' => [
                        'title' => 'Wolaita Dicha FC',
                        'description' => $transaction['description']
                    ],
                    'meta' => json_decode($transaction['meta_data'], true),
                    'created_at' => $transaction['created_at'],
                    'updated_at' => $transaction['updated_at']
                ]
            ];
            
            // Store verification response
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_payment_responses (tx_ref, gateway, response_type, response_data, http_code) 
                VALUES (?, 'chapa', 'verify', ?, 200)
            ");
            $stmt->execute([$tx_ref, json_encode($response_data)]);
            
            return $response_data;
            
        } catch (Exception $e) {
            error_log("Fake Chapa verification error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Fake Chapa payment verification failed'];
        }
    }
    
    /**
     * Verify fake Telebirr payment
     */
    public function verifyTelebirrPayment($tx_ref) {
        try {
            // Get transaction from fake database
            $stmt = $this->db->conn->prepare("SELECT * FROM fake_telebirr_transactions WHERE tx_ref = ?");
            $stmt->execute([$tx_ref]);
            $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$transaction) {
                return ['status' => 'error', 'message' => 'Transaction not found'];
            }
            
            // Create fake verification response
            $trade_status = $transaction['status'] === 'success' ? 'TRADE_SUCCESS' : 'TRADE_FAILED';
            
            $response_data = [
                'status' => 'success',
                'data' => [
                    'status' => $transaction['status'],
                    'reference' => $transaction['trade_no']
                ]
            ];
            
            // Store verification response
            $stmt = $this->db->conn->prepare("
                INSERT INTO fake_payment_responses (tx_ref, gateway, response_type, response_data, http_code) 
                VALUES (?, 'telebirr', 'verify', ?, 200)
            ");
            $stmt->execute([$tx_ref, json_encode($response_data)]);
            
            return $response_data;
            
        } catch (Exception $e) {
            error_log("Fake Telebirr verification error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Fake Telebirr payment verification failed'];
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
     * Simulate payment completion (for testing)
     */
    public function completePayment($tx_ref, $status = 'success') {
        try {
            // Update Chapa transaction
            $stmt = $this->db->conn->prepare("UPDATE fake_chapa_transactions SET status = ? WHERE tx_ref = ?");
            $stmt->execute([$status, $tx_ref]);
            
            // Update Telebirr transaction
            $stmt = $this->db->conn->prepare("UPDATE fake_telebirr_transactions SET status = ? WHERE tx_ref = ?");
            $stmt->execute([$status, $tx_ref]);
            
            return ['status' => 'success', 'message' => 'Payment status updated'];
            
        } catch (Exception $e) {
            error_log("Fake payment completion error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Failed to update payment status'];
        }
    }
    
    /**
     * Generate unique transaction reference
     */
    public function generateTxRef($prefix = 'FAKE_WDFC') {
        return $prefix . '_' . time() . '_' . rand(1000, 9999);
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
    
    /**
     * Get all fake transactions for debugging
     */
    public function getAllTransactions() {
        try {
            $chapa_stmt = $this->db->conn->prepare("SELECT *, 'chapa' as gateway FROM fake_chapa_transactions ORDER BY created_at DESC");
            $chapa_stmt->execute();
            $chapa_transactions = $chapa_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $telebirr_stmt = $this->db->conn->prepare("SELECT *, 'telebirr' as gateway FROM fake_telebirr_transactions ORDER BY created_at DESC");
            $telebirr_stmt->execute();
            $telebirr_transactions = $telebirr_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return array_merge($chapa_transactions, $telebirr_transactions);
            
        } catch (Exception $e) {
            error_log("Error getting fake transactions: " . $e->getMessage());
            return [];
        }
    }
}

?>