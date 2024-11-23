<?php
// Include the database connection file
require '../db/database.php'; 

// Get the task ID from the POST request
if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    // Delete the task from the database
    $query_delete = "DELETE FROM tasks WHERE task_id = :task_id";
    $stmt_delete = $pdo->prepare($query_delete);
    $stmt_delete->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    
    if ($stmt_delete->execute()) {
        // Optionally, you can redirect back to the task page
        header("Location: ../view/Tasks.php"); 
        exit();
    } else {
        echo "Error deleting task.";
    }
} else {
    echo "Task ID not provided.";
}
?>
