<?php
session_start();

// Réinitialiser la session
unset($_SESSION['quiz']);
unset($_SESSION['resultats']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz PHP - Accueil</title>
</head>
<body>
    <h1>Quiz PHP - Accueil</h1>
    <p>Testez vos connaissances en développement web et PHP.</p>
    <p><a href="Views/form.php">Commencer le Quiz</a></p>
</body>
</html>
