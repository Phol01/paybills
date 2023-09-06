<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["signup-username"];
    $email = $_POST["signup-email"];
    $password = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);

    // Default balance for a new user
    $defaultBalance = 1000.00; // You can set any initial balance value here

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $pdo->prepare($checkEmailQuery);
    $stmt->execute([$email]);
    $emailExists = (bool) $stmt->fetchColumn();

    if ($emailExists) {
        // Handle the case where the email already exists (e.g., display an error message).
        echo "Email address already exists. Please choose another email.";
    } else {
        // Insert user data into the database, including the default balance
        $sql = "INSERT INTO users (username, email, password, balance) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$username, $email, $password, $defaultBalance])) {
            // Registration successful, you can redirect the user to a login page.
            header("Location: login.php");
            exit();
        } else {
            // Handle registration failure.
            echo "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign Up</title>
</head>
<style>
    /* styles.css */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.form-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
    text-align: center;
}

.form-container h2 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.form-switch {
    margin-top: 10px;
}

.form-switch a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

</style>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="signup-username">Username:</label>
                <input type="text" id="signup-username" name="signup-username" required>
            </div>
            <div class="form-group">
                <label for="signup-email">Email:</label>
                <input type="email" id="signup-email" name="signup-email" required>
            </div>
            <div class="form-group">
                <label for="signup-password">Password:</label>
                <input type="password" id="signup-password" name="signup-password" required>
            </div>
            <button type="submit" class="btn-primary">Sign Up</button>
        </form>
        <div class="form-switch">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>
    <script src="js/signup.js"></script>
</body>
</html>