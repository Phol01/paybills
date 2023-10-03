<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pay Bills</title>
</head>
<style>
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
    background-color: rgba(173, 216, 230, 0.85); /* Slightly lighter baby blue background */
    border-radius: 10px; /* Optional: Add rounded corners for a smoother blend */
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for depth */
    padding: 20px;
    width: 90%;
    max-width: 400px;
    margin: 40px auto;
}





a {
      text-decoration: none; 
      color: inherit; 
    }


  
  .title {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333333; /* Gray color */
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
    color: #333333; /* Gray color */
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
    background-color: #ffffff;
  }

  .category:hover {
    background-color: #f0f0f0;
  }

  .category-icon {
    font-size: 24px; 
    margin-bottom: 8px;
    color: #333333; /* Gray color */
  }
  .text-center {
    display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 10px;
    justify-content: center; 
}

.user-details {
    text-align: center;
    margin-bottom: 20px;
}

.user-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333333; /* Gray color */
}

.user-balance {
    font-size: 18px;
    color: #007bff;
}

.divider {
    border: none;
    border-top: 1px solid #ccc; /* Color of the line */
    margin: 20px 0; /* Spacing above and below the line */
}

.transaction-history {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}
* Add your CSS styles here */
  .content-container {
    text-align: center;
  }

  .logout-button {
    background-color: #007BFF; /* Background color */
    color: #fff; /* Text color */
    border: none;
    padding: 10px 20px; /* Adjust padding as needed */
    font-size: 16px; /* Adjust font size as needed */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer;
  }

  /* Hover effect */
  .logout-button:hover {
    background-color: #0056b3; /* Darker background color on hover */
  }
.transaction-history:hover {
    background-color: #f0f0f0;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.close-button {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}
.chosen-biller-container {
    margin-top: 10px;
}

.category {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    background-color: #ffffff;
    text-decoration: none;
    color: inherit;
    position: relative; /* Add this line *
}

.category:hover {
    background-color: #f0f0f0;
}

.category-icon {
    font-size: 24px; 
    margin-bottom: 8px;
    color: #333333; /* Gray color */
}
.close-button {
    position: absolute;
    top: 0;
    right: 0;
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}


</style>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Choose a Biller</h2>
        <button id="electricityBtn">Electricity</button>
        <button id="waterBtn">Water</button>
    </div>
</div>



<body>
<?php
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


$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();

if ($user) {
    $userBalance = $user['balance'];
} else {
    
    $userBalance = "N/A"; 
}

$sql = "SELECT * FROM biller WHERE billerID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([1]);
$biller = $stmt->fetch();

if ($biller) {
  // $elecID = $biller['billerID'];
  $_SESSION['electID'] = $biller['billerID'];
  $elecCat = $biller['billerCategory'];
} 

$sql = "SELECT * FROM biller WHERE billerID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([2]);
$biller1 = $stmt->fetch();

if ($biller1) {
  // $h20ID = $biller1['billerID'];
  $_SESSION['h20ID'] = $biller1['billerID'];
  $h2oCat = $biller1['billerCategory'];
} 

?>

<div class="container">
    <div class="title">Categories</div>
    <div class="search-bar">
      <input type="text" class="search-input" placeholder="Search categories">
      <button>Search</button>
    </div>
    <div class="user-details">
        <div class="user-name">Hello, <?php echo $name; ?></div>
        <div class="user-balance" style="color: black;">Balance: <?php echo $userBalance; ?></div>

        
    </div>
    <div class="save-favorites">
    <div class="save-favorites-title">Save your favorite billers</div>
    <div class="category">
        <div class="category-icon">➕</div>
        Add
    </div>
    <div id="chosenBillerContainer" class="chosen-biller-container"></div>
</div>


    <div class="categories text-center">
    <a href="electricity.php" class="category">
        <div class="category-icon">💡</div>
        <?php echo $elecCat; ?>
    </a>
    <a href="waterbill.php" class="category">
        <div class="category-icon">🚰</div>
        <?php echo $h2oCat; ?>
    </a>
</div>

<div class="transaction-history">
    <a href="transaction_history.php" class="category">
        <div class="category-icon">📚</div>
        Transaction History
    </a>
</div>
    <div class="content-container">
  <button class="logout-button" onclick="logout()">Logout</button>
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
<script>
        function logout() {
            // Clear any session data or perform other logout tasks if necessary
            window.location.href = 'login/login.php'; // Redirect to the login page
        }
    </script>

    <script>
      // Add this at the end of your <script> section
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("myModal");
    const electricityBtn = document.getElementById("electricityBtn");
    const waterBtn = document.getElementById("waterBtn");

    // When the user clicks the button, open the modal
    document.querySelector(".save-favorites").addEventListener("click", function() {
        modal.style.display = "block";
    });

    // When the user clicks on <span> (x), close the modal
    document.querySelector(".close").addEventListener("click", function() {
        modal.style.display = "none";
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Handle button clicks in the modal
    electricityBtn.addEventListener("click", function() {
        displayChosenBiller("Electricity");
    });

    waterBtn.addEventListener("click", function() {
        displayChosenBiller("Water");
    });

    function displayChosenBiller(biller) {
    const chosenBillerContainer = document.getElementById("chosenBillerContainer");

    const newCategoryElement = document.createElement("a");
    newCategoryElement.classList.add("category");
    newCategoryElement.href = "#" // Set the appropriate href

    const categoryIcon = document.createElement("div");
    categoryIcon.classList.add("category-icon");
    
    // Set the category icon based on the chosen biller
    if (biller === "Electricity") {
        categoryIcon.textContent = "💡";
    } else if (biller === "Water") {
        categoryIcon.textContent = "🚰";
    } else {
        categoryIcon.textContent = "❓"; // Default icon if biller is not recognized
    }

    const categoryText = document.createElement("div");
    categoryText.textContent = biller;

    newCategoryElement.appendChild(categoryIcon);
    newCategoryElement.appendChild(categoryText);

    const closeButton = document.createElement("button");
    closeButton.classList.add("close-button");
    closeButton.textContent = "X";
    closeButton.addEventListener("click", function() {
        newCategoryElement.remove();
        updateLocalStorage();
    });
    newCategoryElement.appendChild(closeButton);

    chosenBillerContainer.appendChild(newCategoryElement);

    updateLocalStorage();

    modal.style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    const chosenBillerContainer = document.getElementById("chosenBillerContainer");

    const chosenBillers = JSON.parse(localStorage.getItem("chosenBillers")) || [];
    chosenBillers.forEach(biller => {
        const newCategoryElement = document.createElement("div");
        newCategoryElement.classList.add("category");
        newCategoryElement.textContent = biller;

        const closeButton = document.createElement("button");
        closeButton.classList.add("close-button");
        closeButton.textContent = "X";
        closeButton.addEventListener("click", function() {
            newCategoryElement.remove();
            updateLocalStorage();
        });

        newCategoryElement.appendChild(closeButton);

        chosenBillerContainer.appendChild(newCategoryElement);

        newCategoryElement.addEventListener("click", function() {
            redirectToPage(biller);
        });
    });
});

function redirectToPage(biller) {
    switch (biller) {
        case "Electricity":
            window.location.href = "batelec.php";
            break;
        case "Water":
            window.location.href = "nawasa.php";
            break;
        default:
            console.error("Unknown biller:", biller);
    }
}

});

    </script>
  
</body>
</html>
