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
$accountNo = isset($_POST['accountNo']) ? $_POST['accountNo'] : '';
$accountName = isset($_POST['accountName']) ? $_POST['accountName'] : '';
$billerID = 2; 
$merchantID = 2; 


if ($user['balance'] >= $paymentAmount) {
    $newBalance = $user['balance'] - $paymentAmount;
    $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$newBalance, $userID]);

    
    $insertSql = "INSERT INTO trx_water (billerID, merchantID, user_id, accNum, amount, accName) VALUES (?, ?, ?, ?, ?, ?)";

    
    $insertStmt = $pdo->prepare($insertSql);
    $insertStmt->execute([$billerID, $merchantID, $userID, $accountNo, $paymentAmount, $accountName]);

    
    echo "success";
} else {
    
    echo "Insufficient balance. Please top up your account.";
}
?>
