<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "cyberzone";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $stmt = $conn->prepare("SELECT progress FROM userProgress WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['progress' => $row['progress']]);
    } else {
        echo json_encode(['progress' => 0]); // Default to 0 if no progress found
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'User not logged in']);
}

$conn->close();
