<?php
session_start();
include("config.php");
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];

    $sql = "UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, contact_number = :contact_number, address = :address, birthday = :birthday WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':email' => $email,
        ':contact_number' => $contactNumber,
        ':address' => $address,
        ':birthday' => $birthday,
        ':user_id' => $userId
    ]);

    header('Location: ../profile.php');
    exit();
}
?>