<?php
session_start(); // Start the session if not already started
include('../db/database.php'); // Include the database connection

// Check if the user_id session is set
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Prepare SQL query to fetch items nearing expiration
    $sql = "
    SELECT item_name, expiration_date 
    FROM team_project_food_items 
    WHERE user_id = ? 
      AND expiration_date > CURDATE() 
      AND expiration_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY)
    ORDER BY expiration_date ASC 
    LIMIT 2
    ";

    // Prepare the query statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId); // Bind the user_id parameter (integer)
    $stmt->execute();
    $result = $stmt->get_result();

    // Output the result inside the notification box
    echo '<div id="notification-box" style="display: none; position: absolute; background: #fff; border: 1px solid #ccc; padding: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); width: 300px;">';
    if ($result->num_rows > 0) {
        echo '<ul>';
        while ($item = $result->fetch_assoc()) {
            echo "<li>{$item['item_name']} (Expires: {$item['expiration_date']})</li>";
        }
        echo '</ul>';
    } else {
        echo '<p>No items nearing expiry.</p>';
    }
    echo '<div style="text-align: center; margin-top: 10px;">
            <a href="notifications.php" style="text-decoration: none; color: #007BFF; font-weight: bold;">View All</a>
          </div>';
    echo '</div>';

    $stmt->close(); // Close the statement
} else {
    echo '<p>User ID not set. Please log in.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Savvy Saver</title>
     
     <link rel="stylesheet" href="../assets/css/Real_Homepage.css">
    
    <!-- Add Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <nav class="main-nav">
      <img src="../assets/images/savvy3.png" alt="Savvy Saver Logo" class="logo">

      <ul class="main-menu">
        <li><a href="Real_Homepage.php">Home</a></li>
        <li><a href="settings.php">Settings</a></li>
      </ul>

      <ul class="right-menu">
        <li>
            <a href="#"><i class="fas fa-bell" id="notification-bell"><span> Notifications </span></i></a>
        </li>
    </ul>
</nav>

<div id="notification-box">
    <div class="view-all">
        <a href="notifications.php">View All</a>
    </div>
</div>

    <!-- Showcase -->
    <header class="showcase">
  <div class="box-container">
    <div class="box">
      <img src="../assets/images/girl.jpg" alt="Image 1">
    </div>
    <div class="box">
      <img src="../assets/images/fridge.jpg" alt="Image 2">
    </div>
    <div class="box">
      <img src="../assets/images/also_fridge.jpeg" alt="Image 3">
    </div>
  </div>
  <div class="showcase-text">
    <h2>SAVVY SAVER</h2>
    <p>Minimize Waste, Maximize Taste.</p>
  </div>
</header>

    <!-- Featured Products -->
    <section class="home-cards">
      <div>
        <i class="fas fa-tachometer-alt fa-3x"></i>
        <h3>Dashboard</h3>
        <p>
          Keep your food fresh longer with sustainable, reusable storage solutions.
        </p>
        <a href="../admin/Dashboard.php">Learn More <i class="fas fa-chevron-right"></i></a>
      </div>
      <div>
        <i class="fas fa-lightbulb fa-3x"></i>
        <h3>Daily Tips</h3>
        <p>
          Reduce food spoilage with our energy-efficient fridges designed to keep track of expiry dates.
        </p>
        <a href="../view/daily_tips.php">Learn More <i class="fas fa-chevron-right"></i></a>
      </div>
      <div>
        <i class="fas fa-utensils fa-3x"></i>
        <h3>Recipe Recommendations</h3>
        <p>
          Turn food scraps into valuable compost to nourish your garden.
        </p>
        <a href="../view/recipe_recommendation.php">Learn More <i class="fas fa-chevron-right"></i></a>
      </div>
      <div>
        <i class="fas fa-bell fa-3x"></i>
        <h3>Notifications</h3>
        <p>
          Track your food inventory and receive alerts for items approaching their expiration date.
        </p>
        <a href="../view/notifications.php">Learn More <i class="fas fa-chevron-right"></i></a>
      </div>
    </section>

    <!-- Footer -->
    <section class="follow">
        <p>Follow Savvy Saver</p>
        <a href="https://facebook.com">
          <i class="fab fa-facebook fa-2x"></i>
        </a>
        <a href="https://twitter.com">
          <i class="fab fa-twitter fa-2x"></i>
        </a>
        <a href="https://linkedin.com">
          <i class="fab fa-linkedin fa-2x"></i>
        </a>
      </section>

    <!-- Footer Links -->
    <section class="links">
      <div class="links-inner">
        <ul>
          <li><h3>Explore More</h3></li>
          <li><a href="#">Sustainable Living</a></li>
          <li><a href="#">Eco-Friendly Products</a></li>
          <li><a href="#">Healthy Recipes</a></li>
        </ul>
        <ul>
          <li><h3>Company</h3></li>
          <li><a href="#">About Savvy Saver</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press</a></li>
        </ul>
        <ul>
          <li><h3>Help</h3></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </section>

    <footer class="footer">
      <div class="footer-inner">
        <div><i class="fas fa-globe fa-2x"></i> English (United States)</div>
        <ul>
          <li><a href="#">Contact Savvy Saver</a></li>
          <li><a href="#">Privacy & cookies</a></li>
          <li><a href="#">Terms of use</a></li>
          <li><a href="#">Safety & eco</a></li>
          <li><a href="#">&copy; Savvy Saver 2024</a></li>
        </ul>
      </div>
    </footer>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bellIcon = document.getElementById('notification-bell');
    const notifBox = document.getElementById('notification-box');

    bellIcon.addEventListener('click', function () {
        notifBox.style.display = notifBox.style.display === 'block' ? 'none' : 'block';
    });
});
</script>

</body>
</html>
