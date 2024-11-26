<?php
// Include the database connection file
include('../db/database.php'); // Adjust the path as needed

// Start session to handle logged-in user
session_start();
$user_id = $_SESSION['user_id']; // Replace with your session variable for the user

// Initialize the search term
$search = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch recipes based on the search term
$query = "SELECT recipe_id, recipe_name, instructions 
          FROM team_project_recipes 
          WHERE recipe_name LIKE ? OR instructions LIKE ? 
          ORDER BY recipe_name";
$stmt = $conn->prepare($query);

// Bind parameters (with % for partial matching in SQL)
$search_term = "%" . $search . "%"; // Adding % for wildcard search
$stmt->bind_param("ss", $search_term, $search_term); // "s" for string
$stmt->execute();
$result = $stmt->get_result();
$recipes = $result->fetch_all(MYSQLI_ASSOC);

// Handle form submission to create a new recipe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if it's a request to add a new recipe
    if (isset($_POST['recipe-title']) && isset($_POST['instructions'])) {
        $recipe_name = $_POST['recipe-title'];
        $instructions = $_POST['instructions'];

        // Ensure recipe_name and instructions are not empty
        if (!empty($recipe_name) && !empty($instructions)) {
            // Insert the new recipe into the database
            $insert_query = "INSERT INTO team_project_recipes (recipe_name, instructions) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query); // Prepare the statement

            // Bind parameters (s = string, s = string)
            $stmt->bind_param("ss", $recipe_name, $instructions);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to the same page after submission to avoid resubmission
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } else {
                // Handle the error if insertion fails
                echo "Error adding recipe: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Handle the error if fields are empty
            echo "Both recipe name and instructions are required!";
        }
    }

    // Handle recipe deletion
    if (isset($_POST['delete_recipe_id'])) {
        $recipe_id = $_POST['delete_recipe_id'];
        $delete_query = "DELETE FROM team_project_recipes WHERE recipe_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $recipe_id);

        if ($stmt->execute()) {
            // Redirect to refresh the page after deletion
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Error deleting recipe: " . $stmt->error;
        }
        $stmt->close();
    }

    // Handle recipe editing
    if (isset($_POST['edit_recipe_id']) && isset($_POST['edited_recipe_name']) && isset($_POST['edited_instructions'])) {
        $recipe_id = $_POST['edit_recipe_id'];
        $edited_recipe_name = $_POST['edited_recipe_name'];
        $edited_instructions = $_POST['edited_instructions'];

        $update_query = "UPDATE team_project_recipes SET recipe_name = ?, instructions = ? WHERE recipe_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $edited_recipe_name, $edited_instructions, $recipe_id);

        if ($stmt->execute()) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Error updating recipe: " . $stmt->error;
        }
        $stmt->close();
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
                    <form method="GET" action="">
                        <input type="search" name="search" placeholder="Search tasks..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </form>
                </div>
                <div class="dashboard-header__new">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/planner_dashboard_new_plan.svg" alt="New Plan">
                </div>
            </div>

            <!-- Dashboard Content Panels -->
            <div class="dashboard-content__panel dashboard-content__panel--active" data-panel-id="recipes">
                <div class="dashboard-list">
                    <!-- Display recipes dynamically -->
                    <?php if (!empty($recipes)): ?>
                        <?php foreach ($recipes as $recipe): ?>
                            <div class="dashboard-list__item">
                                <h2><?php echo htmlspecialchars($recipe['recipe_name']); ?></h2>
                                <span><?php echo htmlspecialchars($recipe['instructions'] ?? 'No instructions available'); ?></span>
                                
                                <!-- Delete Button -->
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_recipe_id" value="<?php echo $recipe['recipe_id']; ?>">
                                    <button type="submit">Delete</button>
                                </form>

                                <!-- Edit Button -->
                                <button class="edit-recipe-btn" onclick="editRecipe(<?php echo $recipe['recipe_id']; ?>, '<?php echo addslashes($recipe['recipe_name']); ?>', '<?php echo addslashes($recipe['instructions']); ?>')">Edit</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="dashboard-list__item dashboard-list__item--placeholder">
                            <h2>No recipes found</h2>
                            <span>Try a different search term or add a new recipe.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recipe Editing Form (hidden by default) -->
            <div id="edit-recipe-form" style="display: none;">
                <form action="" method="POST">
                    <input type="hidden" id="edit-recipe-id" name="edit_recipe_id">
                    <label for="edited-recipe-name">Recipe Name:</label>
                    <input type="text" id="edited-recipe-name" name="edited_recipe_name" required>
                    <label for="edited-instructions">Instructions:</label>
                    <textarea id="edited-instructions" name="edited_instructions" required></textarea>
                    <button type="submit">Update Recipe</button>
                </form>
            </div>

            <div id="create-recipe-form">
                <form action="" method="POST">
                    <label for="recipe-title">Recipe Name:</label>
                    <input type="text" id="recipe-title" name="recipe-title" required>
                    <label for="instructions">Instructions:</label>
                    <textarea id="instructions" name="instructions" required></textarea>
                    <button type="submit">Create Recipe</button>
                </form>
            </div>

            <script>
                function editRecipe(id, name, instructions) {
                    // Fill the form with the current recipe data
                    document.getElementById('edit-recipe-id').value = id;
                    document.getElementById('edited-recipe-name').value = name;
                    document.getElementById('edited-instructions').value = instructions;

                    // Show the edit form
                    document.getElementById('edit-recipe-form').style.display = 'block';
                }
            </script>
        </div>
    </div>
</body>
</html>
