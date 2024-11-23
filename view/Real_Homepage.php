<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Savvy Saver</title>
    <style>
        <?php include '../assets/css/Real_Homepage.css'; ?>
    </style>
    <!-- Add Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

  <class="container">
    <!-- Nav -->
    <nav class="main-nav">
      <img src="assets/images/Savvysaver.png" alt="Savvy Saver Logo" class="logo">

      <ul class="main-menu">
        <li><a href="Real_Homepage.php">Home</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="userProfile.php">Profile</a></li>
      </ul>

      <ul class="right-menu">
        <li>
            <a href="#"><i class="fas fa-search"></i></a>
        </li>
        <li>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
        </li>
    </ul>
</nav>

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
    <a href="#" class="btn">Get Started <i class="fas fa-chevron-right"></i></a>
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

</body>
</html>
