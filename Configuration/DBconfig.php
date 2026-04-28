<?php

require_once __DIR__ . '/ini.php';

// error_reporting(0);
// ini_set('display_errors', 0);

// Prevent multiple class definitions
if (!class_exists('Database')) {
    class Database{

        private $serverHost = SERVERHOST;
        private $serverUname = SERVERUNAME;
        private $serverPassword = SERVERPASSWORD;
        private $serverDB = SERVERDB;

        public $conn;

        public function __construct() {
            // parent::__construct();

            try {
                $this->conn = new PDO(
                    "mysql:host=$this->serverHost;dbname=$this->serverDB",
                    $this->serverUname,
                    $this->serverPassword
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // ✅ Success message for main DB
                // $this->showSuccessUI("Main Database Connected Successfully");

            } catch (PDOException $e) {
                $this->showErrorUI("Main Database Connection Failed", $e->getMessage());
            }
        }

        private function showSuccessUI($title) {
            echo "
            <style>
                .db-success {
                    background: #d1e7dd;
                    color: #0f5132;
                    border: 1px solid #badbcc;
                    padding: 20px;
                    border-radius: 10px;
                    font-family: 'Segoe UI', sans-serif;
                    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                    margin: 20px auto;
                    width: 90%;
                    max-width: 600px;
                }
            </style>
            <div class='db-success'>
                ✅ <b>$title</b>
            </div>
            ";
        }

        private function showErrorUI($title, $message) {
            echo "
            <style>
                .db-error {
                    background: #f8d7da;
                    color: #842029;
                    border: 1px solid #f5c2c7;
                    padding: 20px;
                    border-radius: 10px;
                    font-family: 'Segoe UI', sans-serif;
                    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                    margin: 20px auto;
                    width: 90%;
                    max-width: 600px;
                }
                .db-error h3 {
                    margin-top: 0;
                    font-size: 18px;
                }
                .db-error small {
                    color: #6c757d;
                }
            </style>
            <div class='db-error'>
                <h3>🚨 $title</h3>
                <p><b>Error:</b> Connection not established.</p>
                <small>$message</small>
            </div>
            ";
        }
    }
}

// Create object
// $object = new Database;

?>