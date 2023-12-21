<?php
include("../logics/config.php");

// Fetch all inquiries from the database
$sql = "SELECT * FROM inquiries ORDER BY date_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($inquiries);
?>