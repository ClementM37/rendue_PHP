<?php

namespace Quiz;

use Provider\DataLoaderJson;

class QuizManager
{
    private array $questions = [];
    private int $scoreTotal = 0;
    private int $scoreObtenu = 0;

    public function __construct(string $jsonFile)
    {
        $this->chargerQuestions($jsonFile);
    }

    private function chargerQuestions(string $jsonFile): void
    {
        $loader = new DataLoaderJson($jsonFile);
        $data = $loader->load($jsonFile);
        
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            throw new \Exception("Format de données invalide");
        }

        foreach ($data['questions'] as $questionData) {
            $question = $this->creerQuestion($questionData);
            if ($question) {
                $this->questions[] = $question;
                $this->scoreTotal += $question['points'];
            }
        }
    }

    private function creerQuestion(array $data): ?array
    {
        if (!isset($data['id'], $data['type'], $data['intitule'], $data['points'])) {
            return null;
        }

        switch ($data['type']) {
            case 'choix_multiple':
                if (!isset($data['choix'], $data['reponse'])) {
                    return null;
                }
                return [
                    'id' => $data['id'],
                    'type' => 'choix_multiple',
                    'intitule' => $data['intitule'],
                    'points' => $data['points'],
                    'choix' => $data['choix'],
                    'reponse' => $data['reponse']
                ];

            case 'choix_multiple_checkbox':
                if (!isset($data['choix'], $data['reponse']) || !is_array($data['reponse'])) {
                    return null;
                }
                return [
                    'id' => $data['id'],
                    'type' => 'choix_multiple_checkbox',
                    'intitule' => $data['intitule'],
                    'points' => $data['points'],
                    'choix' => $data['choix'],
                    'reponse' => array_map('intval', $data['reponse'])
                ];

            case 'ouverture':
                if (!isset($data['reponse'])) {
                    return null;
                }
                return [
                    'id' => $data['id'],
                    'type' => 'ouverture',
                    'intitule' => $data['intitule'],
                    'points' => $data['points'],
                    'reponse' => $data['reponse']
                ];

            default:
                return null;
        }
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function getScoreTotal(): int
    {
        return $this->scoreTotal;
    }

    public function evaluerReponses(array $reponses): array
    {
        $resultats = [];
        $this->scoreObtenu = 0;

        foreach ($this->questions as $question) {
            $idQuestion = $question['id'];
            $cleReponse = 'question_' . $idQuestion;

            if (isset($reponses[$cleReponse])) {
                $reponseUtilisateur = $reponses[$cleReponse];
                $estCorrect = $this->verifierReponse($question, $reponseUtilisateur);

                if ($estCorrect) {
                    $this->scoreObtenu += $question['points'];
                }

                $resultats[] = [
                    'id' => $idQuestion,
                    'question' => $question['intitule'],
                    'correct' => $estCorrect,
                    'points' => $estCorrect ? $question['points'] : 0,
                    'pointsMax' => $question['points']
                ];
            }
        }

        return $resultats;
    }

    private function verifierReponse(array $question, $reponseUtilisateur): bool
    {
        switch ($question['type']) {
            case 'choix_multiple':
                return (int)$reponseUtilisateur === $question['reponse'];

            case 'choix_multiple_checkbox':
                if (!is_array($reponseUtilisateur)) {
                    return false;
                }
                $reponseInt = array_map('intval', $reponseUtilisateur);
                sort($reponseInt);
                $reponsesCorrectes = $question['reponse'];
                sort($reponsesCorrectes);
                return $reponseInt === $reponsesCorrectes;

            case 'ouverture':
                return strtolower(trim($reponseUtilisateur)) === strtolower(trim($question['reponse']));

            default:
                return false;
        }
    }

    public function getScoreObtenu(): int
    {
        return $this->scoreObtenu;
    }

    public function getPourcentage(): float
    {
        if ($this->scoreTotal === 0) {
            return 0;
        }
        return round(($this->scoreObtenu / $this->scoreTotal) * 100, 2);
    }

    public function renderFormulaire(): string
    {
        $html = '';
        foreach ($this->questions as $question) {
            $html .= $this->renderForm($question);
        }
        return $html;
    }

    private function renderForm(array $question): string
    {
        switch ($question['type']) {
            case 'choix_multiple':
                return $this->renderChoixMultiple($question);

            case 'choix_multiple_checkbox':
                return $this->renderChoixMultipleCheckbox($question);

            case 'ouverture':
                return $this->renderOuverture($question);

            default:
                return '';
        }
    }

    private function renderChoixMultiple(array $question): string
    {
        $html = '<div>';
        $html .= '<p>' . htmlspecialchars($question['intitule']) . ' (' . $question['points'] . ' points)</p>';
        
        foreach ($question['choix'] as $index => $choixTexte) {
            $html .= '<label>';
            $html .= '<input type="radio" name="question_' . $question['id'] . '" value="' . $index . '" required>';
            $html .= htmlspecialchars($choixTexte);
            $html .= '</label><br>';
        }
        
        $html .= '</div>';
        return $html;
    }

    private function renderChoixMultipleCheckbox(array $question): string
    {
        $html = '<div>';
        $html .= '<p>' . htmlspecialchars($question['intitule']) . ' (' . $question['points'] . ' points)</p>';
        
        foreach ($question['choix'] as $index => $choixTexte) {
            $html .= '<label>';
            $html .= '<input type="checkbox" name="question_' . $question['id'] . '[]" value="' . $index . '">';
            $html .= htmlspecialchars($choixTexte);
            $html .= '</label><br>';
        }
        
        $html .= '</div>';
        return $html;
    }

    private function renderOuverture(array $question): string
    {
        $html = '<div>';
        $html .= '<label>';
        $html .= htmlspecialchars($question['intitule']) . ' (' . $question['points'] . ' points)<br>';
        $html .= '<input type="text" name="question_' . $question['id'] . '" required>';
        $html .= '</label>';
        $html .= '</div>';
        return $html;
    }
}
