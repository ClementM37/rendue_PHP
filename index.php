<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom_joueur'])) {
    $_SESSION['nom_joueur'] = htmlspecialchars(trim($_POST['nom_joueur']));
    header('Location: Views/form.php?action=start');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz PHP - Accueil</title>
</head>
<body>
    <h1>Quiz PHP</h1>
    <p>Testez vos connaissances sur le judo.</p>
    
    <form method="POST" action="index.php">
        <label for="nom_joueur">Entrez votre nom :</label>
        <input type="text" id="nom_joueur" name="nom_joueur" required minlength="2" maxlength="50">
        <button type="submit">Commencer le Quiz</button>
    </form>
</body>
</html>
