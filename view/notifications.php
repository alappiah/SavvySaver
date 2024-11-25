<?php
// Include the database connection file
require '../db/database.php'; // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id']; // Replace with your session variable for the user, e.g., $_SESSION['user_id']




// Fetch the list of food items that are nearing expiration for the logged-in user
$query = "SELECT item_name, expiration_date 
          FROM team_project_food_items 
          WHERE user_id = ? 
          AND expiration_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY) 
          ORDER BY expiration_date ASC";

$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $food_notifications = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    echo "Error preparing the query: " . $conn->error;
    $food_notifications = [];
}

// Close the connection
$conn->close();
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
                <li class="dashboard-nav__item"><a href="../view/Tasks.php"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_discover_places.svg" alt="Home">Tasks</a></li>
            </ul>
        </div>
        
        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="dashboard-header__search">
                    <input type="search" placeholder="Search...">
                </div>
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>

            <!-- Dashboard Content Panels -->
            <div class="dashboard-list">
                <!-- Display Food Expiration Notifications -->
                <?php foreach ($food_notifications as $notification): ?>
                    <div class="dashboard-list__item">
                        <h2><?php echo "'" . htmlspecialchars($notification['item_name']) . "' expires by " . htmlspecialchars($notification['expiration_date']); ?></h2>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($food_notifications)): ?>
                    <div class="dashboard-list__item">
                        <h2>No upcoming food expiration notifications.</h2>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
