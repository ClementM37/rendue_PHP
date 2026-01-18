<?php
require_once '../Classes/autoloader.php';
session_start();

if (!isset($_SESSION['nom_joueur']) || !isset($_GET['action']) || $_GET['action'] !== 'start') {
    header('Location: ../index.php');
    exit;
}

$quiz = new Quiz\QuizManager('../Data/model.json');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Quiz</title>
</head>
<body>
    <h1>Quiz - Bienvenue <?= htmlspecialchars($_SESSION['nom_joueur']) ?> !</h1>
    <p>Répondez aux questions suivantes :</p>
    
    <form method="POST" action="result.php">
        <?= $quiz->renderFormulaire() ?>
        <button type="submit">Valider mes réponses</button>
    </form>
</body>
</html>
