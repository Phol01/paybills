<?php
session_start();
include "login/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login/login.php");
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

if ($user) {
    $userBalance = $user['balance'];
} else {
    // Handle the case where the user's balance couldn't be retrieved
    $userBalance = "N/A"; // Default value
}

// Process the payment and deduct from the user's balance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the payment amount from the form
    $paymentAmount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $accountNo = isset($_POST['accountNo']) ? $_POST['accountNo'] : '';
    $accountName = isset($_POST['accountName']) ? $_POST['accountName'] : '';

    // Check if the user has sufficient balance
    if ($userBalance >= $paymentAmount) {
        // Deduct the payment amount from the user's balance
        $newBalance = $userBalance - $paymentAmount;

        // Update the user's balance in the session
        $_SESSION['balance'] = $newBalance;

        // Update the user's balance in the database
        $updateSql = "UPDATE users SET balance = ? WHERE user_id = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$newBalance, $userID]);

        // Insert payment data into the trx_water table
        $insertSql = "INSERT INTO trx_water (billerID, merchantID, user_id, accNum, amount, accName) VALUES (?, ?, ?, ?, ?, ?)";
        $billerID = '2'; // Replace with your biller ID
        $merchantID = '2'; // Replace with your merchant ID

        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->execute([$billerID, $merchantID, $userID, $accountNo, $paymentAmount, $accountName]);

        // Redirect to the same page to display the updated balance
        header("Location: nawasa.php");
        exit();
    } else {
        // Insufficient balance, you can handle it as needed (e.g., display an error message)
        $paymentError = "Insufficient balance. Please top up your account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

<style>
  table {
    border-collapse: collapse;
  }

  td {
    /*padding-left: 15px;*/
    padding-bottom: 10px;
    text-align: left;
  }
  td:nth-child(2) {
    padding-left: 20px; /* Adjust the value to increase or decrease left padding */
  }
 body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
  }
  
  .container {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 90%;
    max-width: 400px;
    margin: 40px auto;
  }

  .back-button {
    margin-bottom: 10px;
  }

  .back-button a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: black;
    font-weight: bold;
  }

  .back-button svg {
    width: 20px;
    height: 20px;
    margin-right: 6px;
  }

  .supplier-details {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
  }

  .supplier-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
  }

  .detail-item {
    font-size: 16px;
    margin-bottom: 10px;
    color: #555;
  }

  .next-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }

  .next-button:hover {
    background-color: #0056b3;
  }
  
  .supplier-details {
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }

  .detail-item {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
  }

  .detail-label {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
  }

  .detail-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
  }

  .next-button {
    width: 100%; 
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 16px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .next-button:hover {
    background-color: #0056b3;
  }
  .circle {
    width: 65px; /* Adjust this value to control the size of the circle */
    height: 65px; /* Make the width and height equal for a perfect circle */
    border-radius: 50%; /* Make it a circle by using 50% border radius */
    overflow: hidden; /* Hide any content that goes beyond the circle */
    text-align: center; /* Center the image horizontally within the circle */
    margin: 0 auto; /* Center the circle horizontally on the page */
    background-color: #f0f0f0; /* Set a background color if you want a circular container */
}
.circle img {
    max-width: 100%; /* Make the image fill the circular container */
    height: auto; /* Maintain the aspect ratio of the image */
    display: block; /* Remove any extra spacing below the image */
    margin: 0 auto; /* Center the image horizontally within the circle */
}

  
</style>
<title>Pay Bills</title>
</head>
<body>
    <div class="container">
        <div class="back-button">
            <a href="waterbill.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
              </svg>
              Back to Suppliers
            </a>
          </div>
        <div class="supplier-details">
            <div class="circle">
            <div style="text-align: center;"><img src="https://ph.top10place.com/img_files/1413492542198392" width="65px" height="65px"></div>
            </div>
            <div class="supplier-name" id="merchant"><center>Prime Water Nasugbu</center></div>
            <div class="detail-item">
              <span class="detail-label">Amount I'm paying:</span>
              <input type="text" class="detail-input" id="amount" placeholder="Enter amount" />
            </div>
            <div class="detail-item">
              <span class="detail-label">Account No.:</span>
              <input type="text" class="detail-input" id="accountNo" placeholder="Enter account number" />
            </div>
            <div class="detail-item">
              <span class="detail-label">Account Name:</span>
              <input type="text" class="detail-input" id="accountName" placeholder="Enter account name" />
            </div>
            <div class="detail-item">
              <span class="detail-label">Email:</span>
              <input type="email" class="detail-input" id="email" placeholder="Enter email (Optional)" />
            </div>
            <button class="next-button" id="nextButton">Next</button>
          </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script>
        // JavaScript logic for processing payment and deducting balance will go here
        document.getElementById("nextButton").addEventListener("click", function() {
            // Get payment details from input fields
            const amount = parseFloat(document.getElementById("amount").value);
            const accountNo = document.getElementById("accountNo").value;
            const accountName = document.getElementById("accountName").value;
            const email = document.getElementById("email").value;

            // Make sure the amount is valid and not negative
            if (isNaN(amount) || amount <= 0) {
                Swal.fire({
                    title: "Invalid Amount",
                    text: "Please enter a valid positive amount.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            // Perform balance deduction logic here
            // You need to fetch the user's balance from the database and update it accordingly
            // If the deduction is successful, you can show a success message and redirect to a receipt page
            // If the deduction fails (insufficient balance), show an error message

            // For demonstration purposes, I'll assume a successful deduction for now
            const remainingBalance = 500 - amount; // Replace with actual logic

            
        });
    </script>


<script>
  const nextButton = document.getElementById("nextButton");
  const nameInput = document.getElementById("accountName");
  const accNumInput = document.getElementById("accountNo");
  const amtInput = document.getElementById("amount");
  const mailInput = document.getElementById("email");

  nextButton.addEventListener("click", function() {
      
      // document.getElementById("nameOut").textContent = "Account Name: " + nameInput.value;
      // document.getElementById("amtOut").textContent = "Amount: " + amtInput.value;
      // document.getElementById("numOut").textContent = "Account Number: " + accNumInput.value;
      // document.getElementById("mailOut").textContent = "Email: " + mailInput.value;
      document.getElementById("nameOut").textContent = nameInput.value;
      document.getElementById("amtOut").textContent = amtInput.value;
      document.getElementById("numOut").textContent = accNumInput.value;
      document.getElementById("mailOut").textContent = mailInput.value;

      
      $('#myModal').modal('show');
  });
</script> 

<script>
  $(document).ready(function() {
    $("#cropsBtn").click(function(e) {
        if ($('#cropsForm')[0].checkValidity()) {
            e.preventDefault();

              var formData = new FormData($('#cropsForm')[0]);
              formData.append('action', 'inputHarvest');
              $.ajax({
                  url: 'php/action.php',
                  method: 'post',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                      if (response === 'inputHarvest') {
                          Swal.fire({
                              icon: 'success',
                              text: 'Your input has been Recorded!',
                              allowOutsideClick: false,
                              allowEscapeKey: false
                          }).then(function() {
                              // this gets run after the OK button is clicked
                              window.location = 'main.php'
                          });

                      } else {
                          alert(response);
                      }
                  }
                });
          }
      })
  });
  
  nextButton.addEventListener("click", function() {
    
    $('#myModal').modal('show');
  });

 
$(document).on('click', '.btn-primary', function() {
  Swal.fire({
    title: "Payment Successful",
    text: "Your payment has been successfully processed.",
    icon: "success",
    confirmButtonText: "OK"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "receipt.php";
    }
  });
});
</script>


<script>
    // JavaScript logic for processing payment and deducting balance will go here
    document.getElementById("nextButton").addEventListener("click", function() {
        // Get payment details from input fields
        const amount = parseFloat(document.getElementById("amount").value);
        const accountNo = document.getElementById("accountNo").value;
        const accountName = document.getElementById("accountName").value;
        const email = document.getElementById("email").value;

        // Make sure the amount is valid and not negative
        if (isNaN(amount) || amount <= 0) {
            Swal.fire({
                title: "Invalid Amount",
                text: "Please enter a valid positive amount.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        // Send an AJAX request to process the payment
        $.ajax({
            type: "POST",
            url: "process_payment.php", // Create a new PHP file for payment processing
            data: {
                amount: amount,
                accountNo: accountNo,
                accountName: accountName,
                email: email
            },
            success: function(response) {
                // Handle the response from the server (e.g., success or error message)
                if (response === "success") {
                    // Payment successful, show success message and redirect
                    Swal.fire({
                        title: "Payment Successful",
                        text: "Your payment has been successfully processed.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "receipt.php"; // Redirect to receipt page
                        }
                    });
                } else {
                    // Payment failed, show an error message
                    Swal.fire({
                        title: "Payment Failed",
                        text: response, // Display the error message from the server
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            }
        });
    });
</script>



<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <!-- <p id="nameOut"></p>
        <p id="amtOut"></p>
        <p id="numOut"></p>
        <p id="mailOut"></p> -->
        <table>
            <tr>
              <td>Account Name:</td>
              <td id="nameOut"></td>
            </tr>
            <tr>
              <td>Amount:</td>
              <td id="amtOut"></td>
            </tr>
            <tr>
              <td>Account Number:</td>
              <td id="numOut"></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td id="mailOut"></td>
            </tr>
          </table>
        <p><b>Do you want to proceed?</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
</html>
