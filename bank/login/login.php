<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["login-username"];
    $password = $_POST["login-password"];

    
    $sql = "SELECT user_id, username, email, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        .
        session_start();
        $_SESSION["user_id"] = $user["user_id"];
        header("Location: ../index.php"); 
        exit();
    } else {
       
        echo "Login failed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
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
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="login-username">Username:</label>
                <input type="text" id="login-username" name="login-username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="login-password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <div class="form-switch">
            <a href="signup.php">Don't have an account? Sign up</a>
        </div>
    </div>
    <script src="js/login.js"></script>
    
</body>
</html>
