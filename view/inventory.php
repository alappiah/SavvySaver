<?php
// Include the database connection file
include('../db/database.php'); // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id']; // Replace with your session variable for the user

// Initialize the search term from GET request
$search_query = isset($_GET['search']) ? $_GET['search'] : '';  // Use GET for search

// Prepare the search query with a LIKE condition for both item name and expiration date
$query = "SELECT * FROM team_project_food_items WHERE user_id = ? AND (item_name LIKE ? OR expiration_date LIKE ?) ORDER BY added_on DESC";
$stmt = $conn->prepare($query);

// Add wildcards for LIKE search
$search_term = "%$search_query%"; 

// Bind the parameters for the prepared statement
$stmt->bind_param("iss", $user_id, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result(); // Get the result set
$food_items = $result->fetch_all(MYSQLI_ASSOC);

// Handle Delete action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_food_item_id'])) {
    $food_item_id = $_POST['delete_food_item_id'];

    $query = "DELETE FROM team_project_food_items WHERE item_id = ?";  // Corrected column name
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $food_item_id); // Bind the item_id
    $stmt->execute();
    $stmt->close();

    // Redirect to the inventory page or show success message
    header("Location: inventory.php");
    exit();
}

// Handle Edit action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_food_item_id'])) {
    $food_item_id = $_POST['edit_food_item_id'];
    $item_name = $_POST['item-name'];
    $expiration_date = $_POST['expiration-date'];
    $quantity = $_POST['quantity'];

    // Update the food item in the database
    $query = "UPDATE team_project_food_items SET item_name = ?, expiration_date = ?, quantity = ? WHERE item_id = ?";  // Corrected column name
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $item_name, $expiration_date, $quantity, $food_item_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the inventory page or show success message
    header("Location: inventory.php");
    exit();
}
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
                <!-- Search Input Form -->
                <form method="GET" action="">
                    <div class="dashboard-header__search">
                        <input type="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                    </div>
                </form>
            </div>

            <!-- Dashboard Content Panels -->
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="tasks">
                <div class="dashboard-list">
                    <!-- Check if there are no items -->
                    <?php if (empty($food_items)): ?>
                        <p>No food items found matching your search.</p>
                    <?php else: ?>
                        <!-- Display Food Items -->
                        <?php foreach ($food_items as $item): ?>
                            <div class="dashboard-list__item">
                                <h2><?php echo htmlspecialchars($item['item_name']); ?></h2>
                                <span>Expiration Date: <?php echo htmlspecialchars($item['expiration_date']); ?></span>
                                <span>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Create Food Item Button -->
            <div class="create-task">
                <button id="create-item-btn">Add Food Item</button>
            </div>

            <!-- Food Item Creation Form (hidden by default) -->
            <div id="create-item-form" style="display: none;">
                <form action="../functions/email_notifications.php" method="POST">
                    <label for="item-name">Item Name:</label>
                    <input type="text" id="item-name" name="item-name" required>

                    <label for="expiration-date">Expiration Date:</label>
                    <input type="date" id="expiration-date" name="expiration-date" required>

                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>

                    <button type="submit">Add Item</button>
                </form>
            </div>
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
