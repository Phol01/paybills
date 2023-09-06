<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
  }
  a {
      text-decoration: none; 
      color: inherit; 
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
    font-size: 24px; 
    margin-bottom: 8px;
  }
  .text-center {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Adjust the number of columns as needed */
    gap: 10px;
    justify-content: center; /* Center the grid horizontally */
}

.user-details {
    text-align: center;
    margin-bottom: 20px;
}

.user-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.user-balance {
    font-size: 18px;
    color: #007bff;
}

</style>
<title>Pay Bills</title>
</head>
<body>
<?php
session_start();
include "login/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection code here (config.php or any other file)
include "login/config.php";

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

<div class="container">
    <div class="title">Categories</div>
    <div class="search-bar">
      <input type="text" class="search-input" placeholder="Search categories">
      <button>Search</button>
    </div>
    <div class="user-details">
        <div class="user-name">Hello, <?php echo $userName; ?></div>
        <div class="user-balance">Balance: <?php echo $userBalance; ?></div>
    </div>
    <div class="save-favorites">
      <div class="save-favorites-title">Save your favorite billers</div>
      <div class="category">
        <div class="category-icon">➕</div>
        Add
      </div>
      <!-- You can list your favorite billers here -->
    </div>
   
    <div class="categories text-center">
        <a href="electricity.php" class="category">
            <div class="category-icon">💡</div>
            Electricity
        </a>
        <a href="waterbill.php" class="category">
            <div class="category-icon">🚰</div>
            Water Bill
        </a>
    </div>
    <div class="content-container">
      
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      const categoriesContainer = document.querySelector(".categories");
      const contentContainer = document.querySelector(".content-container");
  
      categoriesContainer.addEventListener("click", function (event) {
        const targetCategory = event.target.closest(".category");
        if (targetCategory) {
          const category = targetCategory.getAttribute("data-category");
          if (category) {
            loadContent(`${category}.html`);
          }
        }
      });
  
      function loadContent(url) {
        fetch(url)
          .then(response => response.text())
          .then(data => {
            contentContainer.innerHTML = data;
          })
          .catch(error => {
            console.error('Error loading content:', error);
          });
      }
    });
</script>
  
</body>
</html>
