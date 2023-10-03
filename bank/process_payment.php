<?php
session_start();
include "login/config.php";


if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit();
}

include "login/config.php"; 

$userID = $_SESSION['user_id'];


$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found";
    exit();
}
$paymentAmount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
if ($user['balance'] >= $paymentAmount) {
    $newBalance = $user['balance'] - $paymentAmount;
    $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$newBalance, $userID]);

    
    $insertSql = "INSERT INTO trx_electricity (billerID, merchantID, user_ID, accNum, amount, billMonth, consumer, dueDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $pdo->prepare($insertSql);


    $billerID = 1;
    $merchantID = 1; 
    $accNum = $_POST['accountNo'];
    $consumer = $_POST['consumer'];
    $bill = $_POST['billMonth'];
    $due = $_POST['dueDate'];
    $user_ID = $userID; 
    $insertStmt->execute([$billerID, $merchantID, $user_ID, $accNum, $paymentAmount, $bill, $consumer, $due]);   
    echo "success";
} else {
    
    echo "Insufficient balance. Please top up your account.";
}
?>
