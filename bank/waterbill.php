<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    a {
      text-decoration: none; 
      color: inherit; 
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
  .supplier-logo {
    width: 40px; 
    height: 40px; 
    border-radius: 50%; 
    overflow: hidden; 
    margin-right: 10px; 
    background-color: #f0f0f0; 
}
.supplier-logo img {
    width: 100%; 
    height: auto; 
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
        <a href="nawasa.php" class="supplier-item">
          <div class="supplier-logo">
            <img src="https://ph.top10place.com/img_files/1413492542198392" width="35px" alt="Logo">
          </div>
          <div class="supplier-name">&nbsp;Prime Water Nasugbu</div>
          <div class="supplier-icon">></div>
        </a>
        <!-- Add more suppliers here -->
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