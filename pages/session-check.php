<?php
// Set session timeout duration (e.g., 30 minutes)
$session_timeout = 30 * 60; // 30 minutes in seconds

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    // Destroy session if timeout is reached
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();
