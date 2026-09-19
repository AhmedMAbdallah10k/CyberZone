<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Modules</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";

    $con = new mysqli($servername, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }


    $sql = "INSERT INTO modules (moduleName,pathId) VALUES
            ('Introduction to Cyber Security',1), 
            ('Introduction to Offensive Security',1),
            ('Introduction to Defensive Security',1)";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $sqlNewModule = "INSERT INTO modules (moduleName, pathId) VALUES 
                    ('Introduction to Cyber Security', 2),
                    ('Network Fundamentals',2),
                    ('How The Web Works',2),
                    ('Linux Fundamentals',2),
                    ('Windows Fundamentals',2)";

    if ($con->query($sqlNewModule) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sqlNewModule . "<br>" . $con->error;
    }

    $sqlNewModule2 = "INSERT INTO modules (moduleName) VALUES ('XSS')";

    if ($con->query($sqlNewModule2) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sqlNewModule2 . "<br>" . $con->error;
    }

    $con->close();
    ?>
</body>

</html>