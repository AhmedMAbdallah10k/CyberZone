<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // create Connection
    $con = new mysqli($servername, $username, $password);

    // check Connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // create Database
    $sql = "CREATE DATABASE cyberzone";
    if ($con->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $con->error;
    }

    $con->close();
    ?>
</body>

</html>