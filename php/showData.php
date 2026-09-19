<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Database Tables</title>
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

    // List of tables
    $tables = ['paths', 'downloads', 'applications', 'users', 'modules', 'tasks', 'enrollment', 'userProgress', 'taskCompletion'];

    foreach ($tables as $table) {
        echo "<h2>Table: $table</h2>";
        $sql = "SELECT * FROM $table";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1' width='100%'>";
            // Output header with column names
            $fields = $result->fetch_fields();
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";

            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($fields as $field) {
                    echo "<td>" . $row[$field->name] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        echo "<br>";
    }

    $con->close();
    ?>
</body>

</html>