<?php
// Include the database connection file
require '../db/database.php'; // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = 1; // Replace with your session variable for the user, for example $_SESSION['user_id']

// Fetch all tasks for the logged-in user from the database
$query_tasks = "SELECT task_id, task_name, task_description, due_date, is_completed FROM tasks WHERE user_id = :user_id ORDER BY due_date";
$stmt_tasks = $pdo->prepare($query_tasks);
$stmt_tasks->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Bind the user_id parameter
$stmt_tasks->execute();
$tasks = $stmt_tasks->fetchAll(PDO::FETCH_ASSOC);

// Fetch the latest two tips from the database
$query_tips = "SELECT tip_text FROM daily_tips ORDER BY created_at DESC LIMIT 2";
$stmt_tips = $pdo->prepare($query_tips);
$stmt_tips->execute();
$tips = $stmt_tips->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        <?php include '../assets/css/dailytipsdash.css'; ?>
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
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="my_trip">
                <div class="dashboard-list">
                    <!-- Display Tips -->
                    <?php foreach ($tips as $tip): ?>
                        <div class="dashboard-list__item">
                            <p><?php echo htmlspecialchars($tip['tip_text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <div class="dashboard-preview">
                <div class="dashboard-preview__panel dashboard-preview__panel--active" data-panel-id="tasks">
                    <div class="dashboard-preview__content">
                        <section>
                            <h2>My Tasks</h2>
                            <?php foreach ($tasks as $task): ?>
                                <div class="task-container">
                                    <label>
                                        <strong><?php echo htmlspecialchars($task['task_name']); ?></strong>: 
                                        <?php echo htmlspecialchars($task['task_description']); ?>
                                        <br>
                                        Due: <?php echo $task['due_date'] == '0000-00-00' ? 'No due date' : $task['due_date']; ?>
                                    </label>
                                    <?php if ($task['is_completed'] == 0): ?>
                                        <form method="post" action="../functions/mark_completed.php">
                                            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                            <button type="submit">Mark as Completed</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Completed</span>
                                    <?php endif; ?>
                                </div>
                                <br>
                            <?php endforeach; ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
