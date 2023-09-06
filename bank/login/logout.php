<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // If the user is logged in, destroy the session to log them out
    session_destroy();
}

// Redirect to the login page after logging out
header("Location: login.php");
exit();
?>
