<?php


function logout() {
    // Start or resume session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Unset all session variables
    $_SESSION = [];

    // Destroy the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000, // Expired in the past
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session data on the server
    session_destroy();

    // Redirect safely
    header("Location: pages_login.php?logout=success");
    exit();
}

logout(); // Call Logout Function
