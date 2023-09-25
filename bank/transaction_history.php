<?php
session_start();
include "login/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "login/config.php";

$userID = $_SESSION['user_id'];

$sql = "SELECT username, fullname FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if ($user) {
    $userName = $user['username'];
    $name = $user['fullname'];
} else {
    $userName = "User";
}

// Include your database connection configuration here (same as in index.php)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bank';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch electricity transaction history for the logged-in user from trx_electricity table
$sqlElectricity = "SELECT accNum, amount, billMonth, consumer, dueDate FROM trx_electricity WHERE user_id = ? ORDER BY billMonth DESC";
$stmtElectricity = $conn->prepare($sqlElectricity);
$stmtElectricity->bind_param("i", $userID);
$stmtElectricity->execute();
$resultElectricity = $stmtElectricity->get_result();

// Query to fetch water transaction history for the logged-in user from trx_water table
$sqlWater = "SELECT accNum, amount, accName FROM trx_water WHERE user_id = ? ORDER BY accNum DESC";
$stmtWater = $conn->prepare($sqlWater);
$stmtWater->bind_param("i", $userID);
$stmtWater->execute();
$resultWater = $stmtWater->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        /* Add your CSS styles for formatting the receipt-like content here */
        body {
    font-family: Arial, sans-serif;
    background-image: url('bills_background.jpg'); /* Replace 'bills_background.jpg' with the actual file path */
    background-size: cover; /* Ensure the image covers the entire background */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    margin: 0;
    padding: 0;
}
        .container {
            background-color: rgba(255, 255, 255, 1); /* Solid white background */
    border-radius: 10px; /* Optional: Add rounded corners for a smoother blend */
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for depth */
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;    
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .print-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
        .back-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.back-button:hover {
  background-color: #0056b3;
}


    </style>
</head>
<body>
    <h1>Transaction History</h1>
    <div class="container">
        <h2>Electricity Transactions</h2>
        <?php
        if ($resultElectricity->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Bill Month</th>
                    <th>Consumer</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>";
            while ($row = $resultElectricity->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["accNum"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    <td>" . $row["billMonth"] . "</td>
                    <td>" . $row["consumer"] . "</td>
                    <td>" . $row["dueDate"] . "</td>
                    <td><button class='print-button' onclick='printTransaction(this)'>Print</button></td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No electricity transaction history found.";
        }
        ?>

        <h2>Water Transactions</h2>
        <?php
        if ($resultWater->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Account Name</th>
                    <th>Action</th>
                </tr>";
            while ($row = $resultWater->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["accNum"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    <td>" . $row["accName"] . "</td>
                    <td><button class='print-button' onclick='printTransaction(this)'>Print</button></td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No water transaction history found.";
        }
        ?>
        <div>
  <a href="index.php" class="back-button">Back to Home</a>
</div>



    </div>

    <script>
        function printTransaction(button) {
            const row = button.closest("tr");
            const receiptContent = `
                <style>
                    /* Include your CSS styles for the receipt here */
                </style>
                <h2>Transaction Receipt</h2>
                <table>
                    ${row.innerHTML}
                </table>`;
            
            const printWindow = window.open('', '', 'width=600,height=600');
            printWindow.document.open();
            printWindow.document.write(receiptContent);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>
