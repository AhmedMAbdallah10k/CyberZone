<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
</head>

<body>
    <?php
    // import PHPMailer classes into global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load composer's autoloader
    require '../vendor/autoload.php';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cyberzone";

    $con = new mysqli($servername, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if (isset($_POST["register"])) {

        // instalation and passing 'true' enables exceptions
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0; //enables verbose debug output
            $mail->isSMTP(); //send using SMTP
            $mail->Host = 'smtp.gmail.com'; //set smtp server to send through
            $mail->SMTPAuth = true; //enable smtp authentication
            $mail->Username = 'cyberzonever88@gmail.com'; //smtp username
            $mail->Password = 'liuykwhykqzeukem'; //smtp password
            // the pass of app password liuy kwhy kqze ukem
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //enables TLS encryption
            $mail->Port = 587; //TCP port to connect to, use 465 for 'PHPMailer::ENCRYPTION_SMTPS' above
            $mail->setFrom('cyberzonever88@gmail.com', 'CyberZone.com'); //Recipients
            $mail->addAddress($_POST['email'], $_POST['firstName']); //add a recipient
            $mail->isHTML(true); //set email format to html

            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body = '<p>Your Verification code is: <b style = "font-size: 30px;">' . $verification_code . '</b></p>';
            $mail->send();

            $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (firstName, secondName, userName, email, password, phoneNumber, isStudent,verification_code,email_verified_at)
                    VALUES ('" . $_POST['firstName'] . "','" . $_POST['secondName'] . "',
                    '" . $_POST['userName'] . "','" . $_POST['email'] . "',
                    '" . $encrypted_password . "', '" . $_POST['phoneNumber'] . "',
                    '" . $_POST['isStudent'] . "','" . $verification_code . "',NULL)";
            mysqli_query($con, $sql);

            header("Location: ./emailVerification.php?email=" . urlencode($_POST['email']));
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    $con->close();
    ?>
</body>

</html>