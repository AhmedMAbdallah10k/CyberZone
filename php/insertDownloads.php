<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Downloads</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";

    // Create connection
    $con = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $sqlInsertDownloads = "INSERT INTO downloads (downloadName) VALUES
                    ('Applications.zip'),
                    ('passwordCracker.zip'),
                    ('EscapeRoom.zip'),
                    ('KeyLogger.zip'),
                    ('Ransomware.zip'),
                    ('ComputerCrasher.zip');";

    if ($con->query($sqlInsertDownloads) === TRUE) {
        echo "New downloads created successfully<br>";
    } else {
        echo "Error: " . $sqlInsertDownloads . "<br>" . $con->error . "<br>";
    }

    $con->close();
    ?>
</body>

</html>