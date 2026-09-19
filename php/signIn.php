<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";

    $con = new mysqli($servername, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if (isset($_POST["signin"])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Perform SQL query to check if userName and password match
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_object($result);

        if (mysqli_num_rows($result) == 0) {
            die("email not found.");
        } elseif (!password_verify($password, $user->password)) {
            die("Password is not correct");
        } elseif ($user->email_verified_at == null) {
            header("Location: emailVerification.php?email=" . urlencode($email));
        } else {
            $_SESSION['userId'] = $user->userId;
            header("Location: ../html/home.html");
            exit();
        }
    } else {
        // Form submission failed
        echo "Please provide valid email and password.";
    }

    $con->close();
    ?>

</body>

</html>