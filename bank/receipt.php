<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt</title>
</head>

<style>
 table {
    border-collapse: collapse;
  }

  td {
    /*padding-left: 15px;*/
    padding: 10px;
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
</style>

<body>
    <div class="container">
        <h3><center>Successful Payment</center></h3>
        <h4><center>Payment Receipt</center></h4>
        <hr>
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
            <tr>
              <td>Reference ID:</td>
              <td id="refOut"></td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
               <td>Updated Balance: </td>
               <td id="balOut"></td>
            </tr>
        </table>
        <hr>
        <br>
        <button onclick="redirectToIndex()">Done</button> <!-- Added button -->
    </div>

    <script>
        // JavaScript function to redirect to index.php
        function redirectToIndex() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>