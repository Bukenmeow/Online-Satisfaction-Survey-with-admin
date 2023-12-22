<?php
include("config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password_hash'];
    $confirmPassword = $_POST['password_hashed'];
    $email = $_POST['email'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contact_number'];
    $category = $_POST['category'];
    $registrationDate = date('Y-m-d H:i:s');

    function generateRandomUserId()
    {
        return mt_rand(100, 9999999999);
    }
    $insertQuery = $pdo->prepare('INSERT INTO users (user_id, username, password, email, first_name, last_name, birthday, address, contact_number, category, profile_picture, date_registered) VALUES (:user_id, :username, :password, :email, :first_name, :last_name, :birthday, :address, :contact_number, :category, :profile_picture, :date_registered)');

    $md5Filename = '';
    if (!empty($_FILES['profile_picture']['name'])) {
        $profilePicture = $_FILES['profile_picture'];
        $fileExtension = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);
        $md5Filename = md5(uniqid(rand(), true)) . '.' . $fileExtension;
        $destinationFolder = '../uploads/';
        $destinationPath = $destinationFolder . $md5Filename;

        if (move_uploaded_file($profilePicture['tmp_name'], $destinationPath)) {
            $insertQuery->bindParam(':profile_picture', $md5Filename);
        } else {
            $error_message = 'Error uploading profile picture.';
        }
    }

    if (empty($username) || empty($password) || empty($confirmPassword) || empty($email) || empty($firstName) || empty($lastName) || empty($birthday) || empty($address) || empty($contactNumber) || empty($category)) {
        $error_message = 'All fields are required.';
    } elseif ($password != $confirmPassword) {
        $error_message = 'Passwords do not match.';
    } else {
        $checkUserQuery = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username OR email = :email');
        $checkUserQuery->bindParam(':username', $username);
        $checkUserQuery->bindParam(':email', $email);
        $checkUserQuery->execute();
        $userCount = $checkUserQuery->fetchColumn();

        if ($userCount > 0) {
            $error_message = 'Username or email already exists.';
        } else {
            $user_id = generateRandomUserId();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insertQuery->bindParam(':user_id', $user_id);
            $insertQuery->bindParam(':username', $username);
            $insertQuery->bindParam(':password', $hashedPassword);
            $insertQuery->bindParam(':email', $email);
            $insertQuery->bindParam(':first_name', $firstName);
            $insertQuery->bindParam(':last_name', $lastName);
            $insertQuery->bindParam(':birthday', $birthday);
            $insertQuery->bindParam(':address', $address);
            $insertQuery->bindParam(':contact_number', $contactNumber);
            $insertQuery->bindParam(':category', $category);
            $insertQuery->bindParam(':profile_picture', $md5Filename);
            $insertQuery->bindParam(':date_registered', $registrationDate);


            if ($insertQuery->execute()) {
                header('Location: ../login.php');
                exit();
            } else {
                $error_message = 'Error: ' . $insertQuery->errorInfo()[2];
            }

            $insertQuery->closeCursor();
        }
    }

    $checkUserQuery->closeCursor();
}
?>