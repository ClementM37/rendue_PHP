<?php
session_start();
require_once __DIR__ . '/../Classes/autoloader.php';

use Quiz\QuizManager;
use Form\Type\Button;

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
    <style>
        .question {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ccc;
        }
        .points {
            font-weight: bold;
        }
        .radio-group label {
            display: block;
            margin: 8px 0;
        }
        .text-input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Questionnaire</h1>
    <form action="result.php" method="POST">
        <?= $quiz->renderFormulaire() ?>
        
        <?php
        $submitButton = new Button('submit', 'submit', 'Valider mes réponses');
        echo $submitButton->render();
        ?>
    </form>
</body>
</html>
