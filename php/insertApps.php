<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Apps</title>
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


    $sql = "INSERT INTO applications (applicationName) VALUES ('Caesar Cipher'), ('Playfair Cipher'),('Rail Fence Cipher'),('Vigenère Cipher'),('Hash Generator'),('Hill Cipher'),('Password Generator')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
    ?>
</body>

</html>