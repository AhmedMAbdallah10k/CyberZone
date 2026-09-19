<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task and Enrollment Management</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is logged in
    if (!isset($_SESSION['userId'])) {
        echo "<script>alert('Please log in to enroll or complete tasks.'); window.history.back();</script>";
        exit;
    }

    $userId = intval($_SESSION['userId']);
    $message = '';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['moduleId'])) {
            $moduleId = intval($_POST['moduleId']);

            // Check if the user is already enrolled in the module
            $checkEnrollment = "SELECT * FROM enrollment WHERE userId = $userId AND moduleId = $moduleId";
            $enrollmentResult = $conn->query($checkEnrollment);

            if ($enrollmentResult->num_rows == 0) {
                $enrollmentDate = date("Y-m-d");
                $enrollSql = "INSERT INTO enrollment (enrollmentDate, userId, moduleId) VALUES ('$enrollmentDate', $userId, $moduleId)";

                if ($conn->query($enrollSql) === TRUE) {
                    $message = 'You have been enrolled successfully!';
                    echo "<script>alert('$message'); window.location='../html/introduction-to-cybersecurity-path/path-page-enrolled.html'</script>";
                    // Initialize the user progress for the module
                    $initProgressSql = "INSERT INTO userProgress (userId, moduleId, progress) VALUES ($userId, $moduleId, 0)";
                    $conn->query($initProgressSql);
                } else {
                    $message = 'Error enrolling in the module: ' . $conn->error;
                }
            } else {
                $message = 'You are already enrolled in this module!';
                echo "<script>alert('$message'); window.location='../html/introduction-to-cybersecurity-path/path-page-enrolled.html'</script>";
            }
        }
    }

    $conn->close();

    if (!empty($message)) {
        echo "<script>alert('$message'); window.history.back();</script>";
    }
    ?>
</body>

</html>