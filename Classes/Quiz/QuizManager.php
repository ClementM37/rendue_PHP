<?php

namespace Quiz;

use Provider\DataLoaderJson;
use Quiz\Question;
use Quiz\QuestionChoixMultiple;
use Quiz\QuestionOuverture;

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
                $this->scoreTotal += $question->getPoints();
            }
        }
    }

    private function creerQuestion(array $data): ?Question
    {
        if (!isset($data['id'], $data['type'], $data['intitule'], $data['points'])) {
            return null;
        }

        switch ($data['type']) {
            case 'choix_multiple':
                if (!isset($data['choix'], $data['reponse'])) {
                    return null;
                }
                return new QuestionChoixMultiple(
                    $data['id'],
                    $data['intitule'],
                    $data['points'],
                    $data['choix'],
                    $data['reponse']
                );

            case 'ouverture':
                if (!isset($data['reponse'])) {
                    return null;
                }
                return new QuestionOuverture(
                    $data['id'],
                    $data['intitule'],
                    $data['points'],
                    $data['reponse']
                );

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
            $idQuestion = $question->getId();
            $cleReponse = 'question_' . $idQuestion;

            if (isset($reponses[$cleReponse])) {
                $reponseUtilisateur = $reponses[$cleReponse];
                $estCorrect = $question->verifierReponse($reponseUtilisateur);

                if ($estCorrect) {
                    $this->scoreObtenu += $question->getPoints();
                }

                $resultats[] = [
                    'id' => $idQuestion,
                    'question' => $question->getIntitule(),
                    'correct' => $estCorrect,
                    'points' => $estCorrect ? $question->getPoints() : 0,
                    'pointsMax' => $question->getPoints()
                ];
            }
        }

        return $resultats;
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
            $html .= $question->renderForm();
        }
        return $html;
    }
}
