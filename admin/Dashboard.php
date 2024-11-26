<?php
$mysqli = new mysqli('localhost', 'root', '', 'savvy');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id'];

// 1. Count the total number of recipes
$totalRecipesQuery = "SELECT COUNT(*) AS total_recipes FROM team_project_recipes";
$totalRecipesResult = $mysqli->query($totalRecipesQuery);
$totalRecipes = $totalRecipesResult->fetch_assoc()['total_recipes'];

// 2. Count active (non-completed) tasks
$activeTasksQuery = "SELECT COUNT(*) AS active_tasks FROM team_project_tasks WHERE is_completed = 0";
$activeTasksResult = $mysqli->query($activeTasksQuery);
$activeTasks = $activeTasksResult->fetch_assoc()['active_tasks'];

// 3. Count total food inventory items
$totalInventoryQuery = "SELECT SUM(quantity) AS total_inventory FROM team_project_food_items";
$totalInventoryResult = $mysqli->query($totalInventoryQuery);
$totalInventory = $totalInventoryResult->fetch_assoc()['total_inventory'];

// Close the MySQLi connection
$mysqli->close();
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
    <!-- Add Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard">
        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar">
            <div class="dashboard-sidebar__brand">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_logo.svg" alt="Logo">
            </div>
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
            <div class="dashboard-header">
                <div class="dashboard-header__search">
                    <input type="search" placeholder="Search...">
                </div>
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>

            <div class="dashboard-content__panel dashboard-content__panel--active">
                <h2>WELCOME TO SAVVY SAVER DASHBOARD</h2>
                <!-- Add a canvas for the bar chart -->
                <canvas id="dashboardBarChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- JavaScript to Initialize the Gridless Chart -->
    <script>
        // Embed PHP variables into JavaScript
        const totalRecipes = <?php echo $totalRecipes; ?>;
        const activeTasks = <?php echo $activeTasks; ?>;
        const totalInventory = <?php echo $totalInventory; ?>;

        const ctx = document.getElementById('dashboardBarChart').getContext('2d');
        const dashboardBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Recipes Added', 'Tasks Active', 'Food Inventory'],
                datasets: [{
                    label: 'Dashboard Stats',
                    data: [totalRecipes, activeTasks, totalInventory], // Dynamic data
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(192, 192, 192, 0.8)',
                        'rgba(135, 206, 235, 0.8)'  
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(192, 192, 192, 0.8)',
                        'rgba(135, 206, 235, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Dashboard Overview'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Hide grid lines on x-axis
                        }
                    },
                    y: {
                        grid: {
                            display: false // Hide grid lines on y-axis
                        },
                        beginAtZero: true // Ensure the chart starts at zero
                    }
                }
            }
        });
    </script>
</body>
</html>
