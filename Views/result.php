<?php
require_once '../Classes/autoloader.php';
session_start();

if (!isset($_SESSION['nom_joueur']) || empty($_POST)) {
    header('Location: ../index.php');
    exit;
}

$quiz = new Quiz\QuizManager('../Data/model.json');
$resultats = $quiz->evaluerReponses($_POST);
$_SESSION['resultats'] = $resultats;

$totalQuestions = count($quiz->getQuestions());
$nombreBonnes = 0;
foreach ($resultats as $resultat) {
    if ($resultat['correct']) {
        $nombreBonnes++;
    }
}

$pourcentage = $quiz->getPourcentage();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Quiz</title>
</head>
<body>
    <h1>Résultats de <?= htmlspecialchars($_SESSION['nom_joueur']) ?></h1>
    
    <div>
        <h2>Score final</h2>
        <p><strong><?= $quiz->getScoreObtenu() ?> / <?= $quiz->getScoreTotal() ?> points</strong></p>
        <p><strong><?= $nombreBonnes ?> / <?= $totalQuestions ?> bonnes réponses</strong></p>
    </div>
    
    <h2>Détails des réponses</h2>
    <?php foreach ($resultats as $resultat): ?>
        <div>
            <h3>Question <?= $resultat['id'] ?></h3>
            <p><?= htmlspecialchars($resultat['question']) ?></p>
            <p><strong>Statut : <?= $resultat['correct'] ? ' Correct' : ' Incorrect' ?></strong></p>
            <p>Points obtenus : <?= $resultat['points'] ?> / <?= $resultat['pointsMax'] ?></p>
        </div>
    <?php endforeach; ?>
    
    <form method="GET" action="../index.php">
        <button type="submit">Recommencer avec un nouveau joueur</button>
    </form>
</body>
</html>
