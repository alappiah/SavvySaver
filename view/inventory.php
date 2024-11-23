<?php
// Include the database connection file
require '../db/database.php'; // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = 1; // Replace with your session variable for the user, for example $_SESSION['user_id']

// Handle form submission for adding a new food item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $item_name = $_POST['item-name'];
    $expiration_date = $_POST['expiration-date'];
    $quantity = $_POST['quantity'];

    // Prepare the SQL query to insert data into the database
    $query = "INSERT INTO food_items (user_id, item_name, expiration_date, quantity, added_on) 
              VALUES (:user_id, :item_name, :expiration_date, :quantity, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
    $stmt->bindParam(':expiration_date', $expiration_date, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

    // Execute the query and check if the insertion was successful
    if ($stmt->execute()) {
        $message = "Food item added successfully!";
    } else {
        $message = "Error adding food item. Please try again.";
    }
}

// Fetch the list of food items for the logged-in user
$query = "SELECT * FROM food_items WHERE user_id = :user_id ORDER BY added_on DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$food_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        <?php include '../assets/css/Dashboard.css'; ?>
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar">
            <!-- Brand -->
            <div class="dashboard-sidebar__brand">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_logo.svg" alt="Logo">
            </div>
            <!-- Dashboard Navigation -->
            <ul class="dashboard-nav">
                <li class="dashboard-nav__item"><a href="../view/Real_Homepage.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_discover_places.svg" alt="Home">Home</a></li>
                <li class="dashboard-nav__item"><a href="../view/daily_tips.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_home.svg" alt="Daily Tips">Daily Tips</a></li>
                <li class="dashboard-nav__item"><a href="../view/recipe_recommendation.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_home.svg" alt="Recipe Recommendations">Recipe Recommendations</a></li>
                <li class="dashboard-nav__item"><a href="../view/notifications.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_notifications.svg" alt="Notifications">Notifications</a></li>
                <li class="dashboard-nav__item"><a href="../view/inventory.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_my_trip.svg" alt="Food Inventory">Food Inventory</a></li>
                <li class="dashboard-nav__item"><a href="../view/recipes.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_discover_places.svg" alt="Recipes">Recipes</a></li>
                <li class="dashboard-nav__item"><a href="../view/Tasks.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_discover_places.svg" alt="Tasks">Tasks</a></li>
            </ul>
        </div>
        
        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <!-- Search Input -->
                <div class="dashboard-header__search">
                    <input type="search" placeholder="Search...">
                </div>
                <!-- New Plan Icon -->
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>

            <!-- Dashboard Content Panels -->
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="tasks">
                <div class="dashboard-list">
                    <!-- Display Food Items -->
                    <?php foreach ($food_items as $item): ?>
                        <div class="dashboard-list__item">
                            <h2><?php echo htmlspecialchars($item['item_name']); ?></h2>
                            <span>Expiration Date: <?php echo htmlspecialchars($item['expiration_date']); ?></span>
                            <span>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Create Food Item Button -->
            <div class="create-task">
                <button id="create-item-btn">Add Food Item</button>
            </div>
            
            <!-- Food Item Creation Form (hidden by default) -->
            <div id="create-item-form" style="display: none;">
                <form action="" method="POST">
                    <label for="item-name">Item Name:</label>
                    <input type="text" id="item-name" name="item-name" required>

                    <label for="expiration-date">Expiration Date:</label>
                    <input type="date" id="expiration-date" name="expiration-date" required>

                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>

                    <button type="submit">Add Item</button>
                </form>
            </div>

            <!-- Display success or error message -->
            <?php if (isset($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Toggle Food Item Creation Form
        document.getElementById('create-item-btn').addEventListener('click', function() {
            var form = document.getElementById('create-item-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
