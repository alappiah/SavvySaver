<?php
// Include the database connection file
require '../db/database.php'; // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id'] ?? null; // Replace with your session variable for the user

// Fetch all recipes from the database
$query = "SELECT recipe_id, recipe_name, instructions FROM recipes ORDER BY recipe_name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission to create a new recipe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_name = $_POST['recipe-title'];
    $instructions = $_POST['instructions'];

    // Ensure recipe_name and instructions are not empty
    if (!empty($recipe_name) && !empty($instructions)) {
        // Insert the new recipe into the database
        $insert_query = "INSERT INTO recipes (recipe_name, instructions) VALUES (:recipe_name, :instructions)";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute(['recipe_name' => $recipe_name, 'instructions' => $instructions]);

        // Redirect to the same page after submission to avoid resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        // Handle the error if fields are empty
        echo "Both recipe name and instructions are required!";
    }
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
                <div class="dashboard-header__search">
                    <input type="search" placeholder="Search...">
                </div>
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>

            <!-- Dashboard Content Panels -->
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="tasks">
                <div class="dashboard-list">
                    <!-- Display first recipe dynamically -->
                    <?php if (!empty($recipes)): ?>
                        <div class="dashboard-list__item">
                            <h2><?php echo htmlspecialchars($recipes[0]['recipe_name']); ?></h2>
                            <span><?php echo htmlspecialchars($recipes[0]['instructions'] ?? 'No instructions available'); ?></span>
                        </div>

                        <!-- Display the rest of the recipes dynamically -->
                        <?php for ($i = 1; $i < count($recipes); $i++): ?>
                            <div class="dashboard-list__item">
                                <h2><?php echo htmlspecialchars($recipes[$i]['recipe_name']); ?></h2>
                                <span><?php echo htmlspecialchars($recipes[$i]['instructions'] ?? 'No instructions available'); ?></span>
                            </div>
                        <?php endfor; ?>
                    <?php else: ?>
                        <div class="dashboard-list__item dashboard-list__item--placeholder">
                            <h2>No recipes available</h2>
                            <span>Start adding your favorite recipes to see them here.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Create Recipe Button -->
            <div class="create-task">
                <button id="create-recipe-btn">Create Recipe</button>
            </div>

            <!-- Recipe Creation Form (hidden by default) -->
            <div id="create-recipe-form" style="display: none;">
                <form action="" method="POST">
                    <label for="recipe-title">Recipe Name:</label>
                    <input type="text" id="recipe-title" name="recipe-title" required>
                    <label for="instructions">Instructions:</label>
                    <textarea id="instructions" name="instructions" required></textarea>
                    <button type="submit">Create Recipe</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle Recipe Creation Form
        document.getElementById('create-recipe-btn').addEventListener('click', function() {
            var form = document.getElementById('create-recipe-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
