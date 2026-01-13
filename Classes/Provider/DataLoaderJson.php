<?php

namespace Provider;

class DataLoaderJson extends DataLoader
{
    public function load(string $source): array
    {
        if (!$this->validateSource()) {
            throw new \Exception("Le fichier JSON n'existe pas : " . $source);
        }

        $content = file_get_contents($source);
        
        if ($content === false) {
            throw new \Exception("Impossible de lire le fichier : " . $source);
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur JSON : " . json_last_error_msg());
        }

        return $data;
    }
}
