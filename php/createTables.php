<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tables</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";

    // Create Connection
    $con = new mysqli($servername, $username, $password, $database);

    // Check Connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Create tables in the correct order
    $sqlPaths = "CREATE TABLE paths (
        pathId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        pathName VARCHAR(255)
    ) ENGINE=InnoDB;";

    $sqlDownloads = "CREATE TABLE downloads (
        downloadId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        downloadName VARCHAR(255)
    ) ENGINE=InnoDB;";

    $sqlApplications = "CREATE TABLE applications (
        applicationId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        applicationName VARCHAR(255)
    ) ENGINE=InnoDB;";

    $sqlUsers = "CREATE TABLE users (
        userId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        secondName VARCHAR(50) NOT NULL,
        userName VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        phoneNumber VARCHAR(20) NOT NULL,
        isStudent ENUM('yes', 'no') NOT NULL,
        verification_code INT NOT NULL,
        email_verified_at DATETIME
    ) ENGINE=InnoDB;";

    $sqlModules = "CREATE TABLE modules (
        moduleId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        moduleName VARCHAR(255),
        pathId INT UNSIGNED,
        FOREIGN KEY (pathId) REFERENCES paths(pathId) ON DELETE CASCADE
    ) ENGINE=InnoDB;";


    $sqlTasks = "CREATE TABLE tasks (
        taskId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        moduleId INT UNSIGNED,
        sectionId INT UNSIGNED,
        taskName VARCHAR(255),
        taskDescription TEXT,
        taskQuestion TEXT,
        correctAnswer VARCHAR(255),
        FOREIGN KEY (moduleId) REFERENCES modules(moduleId)
    ) ENGINE=InnoDB;";

    $sqlEnrollment = "CREATE TABLE enrollment (
        enrollmentId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        enrollmentDate DATE,
        userId INT UNSIGNED,
        moduleId INT UNSIGNED,
        FOREIGN KEY (userId) REFERENCES users(userId),
        FOREIGN KEY (moduleId) REFERENCES modules(moduleId)
    ) ENGINE=InnoDB;";

    $sqlUserProgress = "CREATE TABLE userProgress (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userId INT UNSIGNED,
        moduleId INT UNSIGNED,
        progress FLOAT UNSIGNED DEFAULT 0,  -- Assuming this is a percentage or a calculated value
        FOREIGN KEY (userId) REFERENCES users(userId),
        FOREIGN KEY (moduleId) REFERENCES modules(moduleId),
        UNIQUE KEY unique_user_module (userId, moduleId)  -- Ensures one progress record per user per module
    ) ENGINE=InnoDB;
    ";

    $sqlTaskCompletion = "CREATE TABLE taskCompletion (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        taskId INT UNSIGNED,
        userId INT UNSIGNED,
        moduleId INT UNSIGNED,
        isCompleted BOOLEAN DEFAULT 0,  -- Tracks if the task is completed
        completionDate DATETIME,        -- Optionally track when the task was completed
        FOREIGN KEY (taskId) REFERENCES tasks(taskId),
        FOREIGN KEY (userId) REFERENCES users(userId),
        FOREIGN KEY (moduleId) REFERENCES modules(moduleId),
        UNIQUE KEY unique_user_module_task (userId, moduleId, taskId)  -- Ensures each task is only completed once per user per module
    ) ENGINE=InnoDB;
    ";

    $createTableStatements = [$sqlPaths, $sqlDownloads, $sqlApplications, $sqlUsers, $sqlModules, $sqlTasks, $sqlEnrollment, $sqlUserProgress, $sqlTaskCompletion];

    foreach ($createTableStatements as $sql) {
        if (mysqli_query($con, $sql)) {
            echo "Table created successfully<br>";
        } else {
            echo "Error creating table: " . $con->error . "<br>";
        }
    }

    $con->close();
    ?>
</body>

</html>