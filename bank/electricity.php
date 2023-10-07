<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php 
  session_start();
  include "login/config.php";

  $elecID = $_SESSION['electID'];

  $sql = "SELECT * FROM merchant WHERE merchantID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([1]);
  $merchant = $stmt->fetch();

  if ($merchant) {
    $merchID = $merchant['merchantID'];
    $_SESSION['merchantID'] = $merchant['merchantID'];
    $merName = $merchant['name'];
  } 
?>

<style>
    a {
      text-decoration: none; 
      color: inherit; 
    }
    body::before {
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
  
  .title {
    font-size: 24px;
    margin-bottom: 20px;
  }

  .search-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 6px;
    margin-bottom: 20px;
  }

  .search-input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .save-favorites {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 6px;
  }

  .save-favorites-title {
    font-weight: bold;
    margin-bottom: 10px;
  }

  .add-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    cursor: pointer;
  }

  .add-button:hover {
    background-color: #0056b3;
  }

  .categories {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }

  .category {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
  }

  .category:hover {
    background-color: #f0f0f0;
  }

  .category-icon {
    font-size: 32px;
    margin-bottom: 8px;
  }
  .supplier-list {
    margin-top: 20px;
  }

  .supplier-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-bottom: 10px;
    box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.1);
  }

  .supplier-name {
    flex: 1;
  }

  .supplier-icon {
    font-size: 20px;
    margin-left: 10px;
  }

  
</style>
<title>Pay Bills</title>
</head>
<body>
<div class="container">
    <div class="back-button">
      <a href="index.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"/>
          <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
        </svg>
        Back to Categories
      </a>
    </div>
    <div class="search-bar">
      <input type="text" class="search-input" placeholder="Search suppliers">
      <button>Search</button>
    </div>
    <div class="supplier-list">
        <a href="batelec.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://www.batelec1.com.ph/asset/images/batelec1logowhite.png" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;<?php echo $merName ?></div>
          <div class="supplier-icon">></div>
        </a>
        <!-- Add more suppliers here -->
        <div class="supplier-list">
        <a href="meralco.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://upload.wikimedia.org/wikipedia/en/thumb/f/fc/Meralco.svg/1200px-Meralco.svg.png" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Meralco</div>
          <div class="supplier-icon">></div>
        </a>
        <div class="supplier-list">
        <a href="aboitiz.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://visayanelectric.com/admin/we_uploads/aplogo.jpg" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Aboitiz Power</div>
          <div class="supplier-icon">></div>
        </a>
        <div class="supplier-list">
        <a href="veco.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://d1hbpr09pwz0sk.cloudfront.net/logo_url/visayan-electric-company-inc-32fd47dd" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Veco</div>
          <div class="supplier-icon">></div>
        </a>
        <div class="supplier-list">
        <a href="visayanelectric.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://aboitizpower.com/uploads/media/Visayan-Electric-1.png" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Visayan Electric</div>
          <div class="supplier-icon">></div>
        </a>
        <div class="supplier-list">
        <a href="peco.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://imtnews.ph/dashboard/uploads/2019/11/08/1573189708243.jpg" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Peco</div>
          <div class="supplier-icon">></div>
        </a>

      </div>
<script>
    function loadContent(url) {
      const contentContainer = document.querySelector('.content-container');
  
      fetch(url)
        .then(response => response.text())
        .then(data => {
          contentContainer.innerHTML = data;
        });
    }
  </script>


</body>
</html>
