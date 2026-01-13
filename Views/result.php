<?php
session_start();
require_once __DIR__ . '/../Classes/autoloader.php';

use Quiz\QuizManager;

// Vérifier que le quiz existe en session; si non, recréer le quiz depuis le modèle
if (!isset($_SESSION['quiz'])) {
    try {
        $quiz = new QuizManager(__DIR__ . '/../Data/model.json');
        $_SESSION['quiz'] = serialize($quiz);
    } catch (Exception $e) {
        // Si la création échoue, rediriger vers l'accueil
        header('Location: ../index.php');
        exit;
    }
} else {
    // Récupérer le quiz depuis la session
    $quiz = unserialize($_SESSION['quiz']);
}

// Évaluer les réponses
$resultats = $quiz->evaluerReponses($_POST);
$_SESSION['resultats'] = $resultats;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz PHP - Résultats</title>
</head>
<body>
    <h1>Résultats du Quiz</h1>
    
    <div class="score-card">
        <h2>Votre score</h2>
        <p><strong><?= $quiz->getScoreObtenu() ?> / <?= $quiz->getScoreTotal() ?> points</strong></p>
        <?php $nombreBonnes = count(array_filter($resultats, function($r) { return $r['correct']; })); $totalQuestions = count($quiz->getQuestions()); ?>
        <p><strong><?= $nombreBonnes ?> / <?= $totalQuestions ?> bonnes réponses</strong></p>
    </div>

    <h2>Détail des réponses</h2>
    <?php foreach ($resultats as $resultat): ?>
        <div class="<?= $resultat['correct'] ? 'correct' : 'incorrect' ?>">
            <h3><?= htmlspecialchars($resultat['question']) ?></h3>
            <p>
                <strong><?= $resultat['correct'] ? 'Correct' : 'Incorrect' ?></strong>
                - <?= $resultat['points'] ?> / <?= $resultat['pointsMax'] ?> points
            </p>
        </div>
    <?php endforeach; ?>

    <p><a href="../index.php">Recommencer</a></p>
</body>
</html>
