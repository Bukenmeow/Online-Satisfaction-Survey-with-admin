<?php

include("../logics/config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionnaire = $_POST['questionnaire'];
    $choices = $_POST['choices'];

    $query = "INSERT INTO questions (question_text, choices) VALUES (:questionnaire, :choices)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':questionnaire', $questionnaire);
    $stmt->bindParam(':choices', $choices);
    $stmt->execute();

    header('Location: survey.php');
}
?>