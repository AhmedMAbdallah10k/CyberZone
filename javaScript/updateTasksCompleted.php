<?php
session_start();

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$database = "cyberzone";
$userId = $_POST['userId'];
$moduleId = $_POST['moduleId'];
$taskId = $_POST['taskId'];  // Ensure taskId is sent from the client-side

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the task has already been marked as completed
$query = "SELECT id FROM taskCompletion WHERE userId = $userId AND moduleId = $moduleId AND taskId = $taskId";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // If the task has not been completed yet, mark it as completed
    $insertQuery = "INSERT INTO taskCompletion (userId, moduleId, taskId, isCompleted, completionDate) VALUES (?, ?, ?, 1, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iii", $userId, $moduleId, $taskId);
    $success = $stmt->execute();

    if ($success) {
        // Update the user's progress in the userProgress table
        $updateProgressSql = "UPDATE userProgress SET progress = (SELECT COUNT(*) FROM taskCompletion WHERE moduleId = $moduleId AND userId = $userId AND isCompleted = 1) / (SELECT COUNT(*) FROM tasks WHERE moduleId = $moduleId) * 100 WHERE userId = $userId AND moduleId = $moduleId";
        $conn->query($updateProgressSql);
        echo "Task completed and progress updated successfully.";
    } else {
        echo "Error marking task as completed: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Task already marked as completed.";
}

$conn->close();
