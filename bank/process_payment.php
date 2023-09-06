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

// Get the payment amount and other details from the AJAX request
$paymentAmount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$accountNo = isset($_POST['accountNo']) ? $_POST['accountNo'] : '';
$accountName = isset($_POST['accountName']) ? $_POST['accountName'] : '';
$billType = isset($_POST['bill_type']) ? $_POST['bill_type'] : '';

// Define billerID and merchantID (replace with your actual values)
$billerID = 'your_biller_id'; // Replace with your biller ID
$merchantID = 'your_merchant_id'; // Replace with your merchant ID

// Check if the user has sufficient balance
if ($user['balance'] >= $paymentAmount) {
    // Deduct the payment amount from the user's balance
    $newBalance = $user['balance'] - $paymentAmount;

    // Update the user's balance in the database
    $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$newBalance, $userID]);

    // Define the $insertSql variable
    $insertSql = "";

    // Insert payment data into the appropriate table based on the bill type
    if ($billType === 'electricity') {
        // Insert into trx_electricity table
        $insertSql = "INSERT INTO trx_electricity (billerID, merchantID, user_id, accNum, amount) VALUES (?, ?, ?, ?, ?)";
    } elseif ($billType === 'water') {
        // Insert into trx_water table
        $insertSql = "INSERT INTO trx_water (billerID, merchantID, user_id, accNum, amount, accName) VALUES (?, ?, ?, ?, ?, ?)";
    }

    // Check if $insertSql is empty before preparing the statement
    if (!empty($insertSql)) {
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute([$billerID, $merchantID, $userID, $accountNo, $paymentAmount, $accountName]);
        
        // Return a success message to the AJAX request
        echo "success";
    } else {
        // Handle the case where $insertSql is empty (no valid bill_type)
        echo "Invalid bill type";
    }
} else {
    // Insufficient balance, return an error message to the AJAX request
    echo "Insufficient balance. Please top up your account.";
}
?>
