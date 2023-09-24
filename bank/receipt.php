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
    padding: 10px;
    text-align: left;
  }
  td:nth-child(2) {
    padding-left: 20px; 
  }body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    z-index: -1; /* Place the overlay behind the content */
}

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
        <button onclick="redirectToIndex()">Done</button> 
    </div>

    <script>
    
        function redirectToIndex() {
            window.location.href = "index.php";
        }

        
        document.getElementById("nameOut").textContent = sessionStorage.getItem("nameOut");
        document.getElementById("amtOut").textContent = sessionStorage.getItem("amtOut");
        document.getElementById("numOut").textContent = sessionStorage.getItem("numOut");
        document.getElementById("mailOut").textContent = sessionStorage.getItem("mailOut");
        
        
        const referenceID = generateReferenceID();
        document.getElementById("refOut").textContent = referenceID;

        
        const updatedBalance = sessionStorage.getItem("balance");
        document.getElementById("balOut").textContent = Balance;

      

        function generateReferenceID() {
            const characters = "0123456789";
            const length = 10; 
            let result = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }
            return result;
        }
    </script>
</body>
</html>
