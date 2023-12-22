<?php
include('../logics/config.php');
$user_id = $_POST['user_id'];
$stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
?>