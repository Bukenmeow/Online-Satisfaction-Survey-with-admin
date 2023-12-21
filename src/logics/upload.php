<?php
include("config.php");
$userId = $_SESSION['user_id'];

if (isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];

    if ($file['error'] !== 0) {
        die("An error occurred while uploading the file.");
    }

    if ($file['size'] > 5000000) {
        die("The file is too large.");
    }

    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Only JPG and PNG files are allowed.");
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $extension;
    $destination = 'uploads/' . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Failed to move the uploaded file.");
    }

    $sql = "SELECT profile_picture FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $oldPicture = $stmt->fetchColumn();

    if ($oldPicture && file_exists('../uploads/' . $oldPicture)) {
        unlink('uploads/' . $oldPicture);
    }

    $sql = "UPDATE users SET profile_picture = :profile_picture WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':profile_picture' => $newFileName, ':user_id' => $userId]);

}
?>