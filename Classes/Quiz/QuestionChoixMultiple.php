<?php

namespace Quiz;

use Form\Type\Radio;

class QuestionChoixMultiple extends Question
{
    private array $choix;
    private int $reponseCorrecte;

    public function __construct(int $id, string $intitule, int $points, array $choix, int $reponseCorrecte)
    {
        parent::__construct($id, $intitule, $points, 'choix_multiple');
        $this->choix = $choix;
        $this->reponseCorrecte = $reponseCorrecte;
    }

    public function getChoix(): array
    {
        return $this->choix;
    }

    public function verifierReponse($reponseUtilisateur): bool
    {
        return (int)$reponseUtilisateur === $this->reponseCorrecte;
    }

    public function renderForm(): string
    {
        $html = '<div class="question">';
        $html .= '<h3>' . htmlspecialchars($this->intitule) . ' <span class="points">(' . $this->points . ' points)</span></h3>';
        
        $options = [];
        foreach ($this->choix as $index => $choix) {
            $options[$index] = $choix;
        }
        
        $radio = new Radio('question_' . $this->id, $options);
        $html .= $radio->render();
        
        $html .= '</div>';
        return $html;
    }
}
