<?php
// Include your database connection code here (config.php or any other file)
include "login/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Retrieve the user's name from the database
$sql = "SELECT username FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if ($user) {
    $userName = $user['username'];
} else {
    // Handle the case where the user's data couldn't be retrieved
    $userName = "User"; // Default value
}

// Retrieve the user's balance from the database
// Replace 'balance' with the actual column name for the user's balance
$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if ($user) {
    $userBalance = $user['balance'];
} else {
    // Handle the case where the user's balance couldn't be retrieved
    $userBalance = "N/A"; // Default value
}
?>

<div class="header">
    <div class="user-details">
        <div class="user-name">Hello, <?php echo $userName; ?></div>
        <div class="user-balance">Balance: $<?php echo $userBalance; ?></div>
    </div>
    <!-- Add other header elements as needed -->
</div>
