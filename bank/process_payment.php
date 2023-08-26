<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accountNumber = $_POST["accountNumber"];
    $amount = $_POST["amount"];
    $receiverName = $_POST["receiver"];

    // Perform necessary payment processing logic here
    // For example, update balances, log transactions, etc.

    $response = "Payment of $$amount successfully made to account $accountNumber for $receiverName.";
    echo $response; // Send the response back to the JavaScript for display
}
?>
