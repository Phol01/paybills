<?php
session_start();
include "login/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

// Include your database connection code here (config.php or any other file)
include "login/config.php"; // Corrected the include path

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Retrieve the user's balance from the database
$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found";
    exit();
}

// Get the payment amount from the AJAX request
$paymentAmount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

// Check if the user has sufficient balance
if ($user['balance'] >= $paymentAmount) {
    // Deduct the payment amount from the user's balance
    $newBalance = $user['balance'] - $paymentAmount;

    // Update the user's balance in the database
    $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$newBalance, $userID]);

    // Return a success message to the AJAX request
    echo "success";
} else {
    // Insufficient balance, return an error message to the AJAX request
    echo "Insufficient balance. Please top up your account.";
}
?>
