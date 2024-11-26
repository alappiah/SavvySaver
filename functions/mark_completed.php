<?php
// Include the database connection file
require '../db/database.php'; 

// Get the task ID from the POST request
if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];


    $query_delete = "DELETE FROM team_project_tasks WHERE task_id = ?";
    $stmt_delete = $conn->prepare($query_delete);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $task_id); // Bind task_id as an integer
        if ($stmt_delete->execute()) {
            header("Location: ../view/Tasks.php");
            exit();
        } else {
            echo "Error deleting task: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
} else {
    echo "Task ID not provided.";
}
?>
