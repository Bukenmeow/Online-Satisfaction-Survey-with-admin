<?php
session_start();
include("logics/login_logic.php");
if (isset($_SESSION["user_id"])) {
    header("Location: user.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSMS - Login Page</title>
    <link rel="stylesheet" href="styles/styles.css" class="styles">
</head>

<body>
    <div id="container">
        <div id="logo-container">
            <div id="logo">
                <img src="dst_logo.jpg" alt="Logo">
            </div>
            <div id="logo-name">
                Online Satisfaction Management System
            </div>
        </div>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

            <div class="error-message">
                <?php
                if (isset($error_message)) {
                    echo $error_message;
                }
                ?>
            </div>

            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up here</a>
            </div>

        </form>
    </div>

</body>

</html>