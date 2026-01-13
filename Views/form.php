<?php
session_start();
require_once __DIR__ . '/../Classes/autoloader.php';

use Quiz\QuizManager;

try {
    // Créer le quiz
    $quiz = new QuizManager(__DIR__ . '/../Data/model.json');
    
    // Stocker le quiz en session
    $_SESSION['quiz'] = serialize($quiz);
    
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz PHP - Questionnaire</title>
</head>
<body>
    <h1>Questionnaire</h1>
    <form action="result.php" method="POST">
        <?= $quiz->renderFormulaire() ?>
        
        <button type="submit">Valider mes réponses</button>
    </form>
</body>
</html>
