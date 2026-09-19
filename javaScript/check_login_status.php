<?php
session_start();
header('Content-Type: application/json');

// Database connection settings - update these as per your configuration
$host = 'localhost'; // or your host
$username = 'root';
$password = '';
$dbname = 'cyberzone';


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];

        // Prepare a statement to fetch progress
        $stmt = $conn->prepare("SELECT progress FROM userProgress WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

        // Fetch the progress data
        $progressData = $stmt->fetch(PDO::FETCH_ASSOC);
        $progress = $progressData ? $progressData['progress'] : 0; // Default to 0 if no data found

        echo json_encode(['isLoggedIn' => true, 'progress' => $progress]);
    } else {
        echo json_encode(['isLoggedIn' => false]);
    }
} catch (PDOException $e) {
    // Handle the PDOException here
    echo json_encode(['error' => $e->getMessage()]);
}
