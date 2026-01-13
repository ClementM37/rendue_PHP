<?php

spl_autoload_register(function ($class) {
    // Afficher pour debug (à retirer après test)
    // echo "Tentative de chargement : $class<br>";
    
    // Le chemin de base est le dossier Classes
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
    
    // Remplacer les backslashes par des slashes pour les namespaces
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Construire le chemin complet du fichier
    $file = $baseDir . $classPath . '.php';
    
    // Afficher pour debug (à retirer après test)
    // echo "Chemin recherché : $file<br>";
    
    // Vérifier si le fichier existe et l'inclure
    if (file_exists($file)) {
        require_once $file;
        // echo "Fichier chargé : $file<br>";
        return true;
    }
    
    // echo "Fichier NON trouvé : $file<br>";
    return false;
});
