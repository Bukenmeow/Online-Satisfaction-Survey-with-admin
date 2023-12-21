<?php

include("../logics/config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionnaire = $_POST['indicator_questions'];

    $query = "INSERT INTO indicator_questions (question_text) VALUES (:question_text)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':question_text', $questionnaire);
    $stmt->execute();

    header('Location: survey.php');
}
?>