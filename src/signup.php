<?php
session_start();
include("logics/config.php");
include("logics/register.php");
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
    <title>OSMS - Sign Up</title>
    <link rel="stylesheet" href="styles/reg.css" class="style">
</head>

<body>

    <div id="logo">
        <img src="dst_logo.jpg" alt="Logo">
    </div>

    <form method="post" enctype="multipart/form-data">
        <h1>Sign Up</h1>

        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password_hash" required>
        </div>

        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="password_hashed" required>
        </div>

        <div>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>
        </div>

        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>
        </div>

        <div>
            <label for="birthday">Birthday:</label>
            <input type="date" name="birthday" required>
        </div>

        <div>
            <label for="address">Address:</label>
            <input type="text" name="address" required>
        </div>

        <div>
            <label for="contact_number">Contact Number:</label>
            <input type="number" name="contact_number" required>
        </div>

        <div>
            <label for="category">Role:</label>
            <select name="category" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture">
        </div>

        <button type="submit">Sign Up</button>

        <div class="login-link">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </form>

</body>

</html>