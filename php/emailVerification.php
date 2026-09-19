<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/emailVerification.css">

    <!--link for icons envelope and lock-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="/images/Hacker.png" type="images/x-icon">
    <title>Email Verification</title>
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

    if (isset($_POST["verify_email"])) {
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];

        // check if credintial are okay and email is verified
        $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = '" . $email . "' and verification_code = '" . $verification_code . "'";
        $result = mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) == 0) {
            die("verification code failed.");
        }
        header("Location: ../html/sign-in.html");
        exit();
    }
    ?>
    <nav>
        <div class="all">
            <div class="logo">
                <a href="/html/index.html">
                    <h1><span>Cyber</span>zone</h1>
                </a>
            </div>
            <div class="choice"> <!--choice for desktop-->
                <a href="/html/home.html">Home</a> <!--<i></i> tag "icon"-->
                <a href="/html/paths.html">Paths</a>
                <a href="/html/modules.html">Modules</a>
                <a href="./downloads.php">Downloads</a>
                <a href="/html/applications.html">Apps</a>
                <a href="/html/ubuntu.html">Ubuntu</i></a>
            </div>
            <div class="register">
                <a href="/html/sign-in.html" class="login"><button>Login</button></a>
                <a href="/html/sign-up.html" class="signup"><button>sign up</button></a>
            </div>
        </div>
    </nav>
    <form class="login-form" method="POST">
        <div class="text">Email Verification</div>
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
        <div class="field">
            <div class="fas fa-lock"></div>
            <input type="text" name="verification_code" placeholder="enter verification code" required>
        </div>
        <input type="submit" class="submit-button" name="verify_email" value="verify email">
    </form>
    <footer>
        <div class="main">
            <div class="tag">
                <h1>Core Team</h1>
                <div class="social_link">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <div class="copyright">
                    <p>Copyright © 2024 <a href="#">Core</a> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/tsparticles-slim@2.0.6/tsparticles.slim.bundle.min.js"></script>
    <script src="/javaScript/particles-config.js"></script>
    <script>
        const navBar = document.querySelector('nav');

        function toggleBlurOnScroll() {
            if (window.scrollY > 50) {
                navBar.classList.add('blurred');
            } else {
                navBar.classList.remove('blurred');
            }
        }

        window.addEventListener('scroll', toggleBlurOnScroll);
    </script>
</body>

</html>