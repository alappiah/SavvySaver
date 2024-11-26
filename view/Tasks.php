<?php
// Include the database connection file
include('../db/database.php'); // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id']; // Replace with your session variable for the user

// Initialize the search term
$search = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch tasks based on the search term
$query = "SELECT task_id, task_name, task_description 
          FROM team_project_tasks 
          WHERE user_id = ? AND is_completed = 0 
          AND (task_name LIKE ? OR task_description LIKE ?)
          ORDER BY task_name";
$stmt = $conn->prepare($query);

// Bind parameters (with % for partial matching in SQL)
$search_term = "%" . $search . "%"; // Adding % for wildcard search
$stmt->bind_param("iss", $user_id, $search_term, $search_term); // "i" for integer, "s" for string
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// Handle form submission to create a new task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task-title'];
    $task_description = $_POST['task-description'];

    // Ensure task_name and task_description are not empty
    if (!empty($task_name) && !empty($task_description)) {
        // Insert the new task into the database
        $insert_query = "INSERT INTO team_project_tasks (user_id, task_name, task_description) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iss", $user_id, $task_name, $task_description); // "i" for integer, "s" for string
        $insert_stmt->execute();

        // Redirect to the same page after submission to avoid resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        // Handle the error if fields are empty
        echo "Both task name and task description are required!";
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
                <li class="dashboard-nav__item"><a href="../view/Real_Homepage.php">Home</a></li>
                <li class="dashboard-nav__item"><a href="../view/daily_tips.php">Daily Tips</a></li>
                <li class="dashboard-nav__item"><a href="../view/recipe_recommendation.php">Recipe Recommendations</a></li>
                <li class="dashboard-nav__item"><a href="../view/notifications.php">Notifications</a></li>
                <li class="dashboard-nav__item"><a href="../view/inventory.php">Food Inventory</a></li>
                <li class="dashboard-nav__item"><a href="../view/recipes.php">Recipes</a></li>
                <li class="dashboard-nav__item"><a href="../view/Tasks.php">Tasks</a></li>
            </ul>
        </div>
        
        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="dashboard-header__search">
                    <!-- Search form with button -->
                    <form method="GET" action="">
                        <input type="search" name="search" placeholder="Search tasks..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="search-input">
                    </form>
                </div>
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>


            <!-- Dashboard Content Panels -->
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="tasks">
                <div class="dashboard-list">
                    <!-- Display tasks dynamically -->
                    <?php if (!empty($tasks)): ?>
                        <?php foreach ($tasks as $task): ?>
                            <div class="dashboard-list__item">
                                <h2><?php echo htmlspecialchars($task['task_name']); ?></h2>
                                <span><?php echo htmlspecialchars($task['task_description'] ?? 'No description available'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="dashboard-list__item dashboard-list__item--placeholder">
                            <h2>No tasks found</h2>
                            <span>Try a different search term or add a new task.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Create Task Button -->
            <div class="create-task">
                <button id="create-task-btn">Create Task</button>
            </div>

            <!-- Task Creation Form (hidden by default) -->
            <div id="create-task-form" style="display: none;">
                <form action="" method="POST">
                    <label for="task-title">Task Title:</label>
                    <input type="text" id="task-title" name="task-title" required>
                    <label for="task-description">Task Description:</label>
                    <textarea id="task-description" name="task-description" required></textarea>
                    <button type="submit">Create Task</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle Task Creation Form
        document.getElementById('create-task-btn').addEventListener('click', function() {
            var form = document.getElementById('create-task-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
