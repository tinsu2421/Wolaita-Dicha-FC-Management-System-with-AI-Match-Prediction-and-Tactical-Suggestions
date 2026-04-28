<?php

/**
  * File name Database Config file..
  * Developer : Rediet Tesfaye
  * Mobile : 0919315685
  * Country : Ethiopia
  * Date Nov 12
  */

// Prevent multiple inclusions
if (!defined('DB_CONFIG_LOADED')) {
    define('DB_CONFIG_LOADED', true);
    
    define('SERVERHOST', 'localhost'); // Run Time machine Lookup Address
    define('SERVERUNAME', 'root');  // Username by defualt root
    define('SERVERPASSWORD', '');  // Password null for my Apache Server
    define('SERVERDB', 'wolaita_dichafcdb');
}
  
?>