<?php

namespace Quiz;

use Form\Type\Text;

class QuestionOuverture extends Question
{
    private string $reponseCorrecte;

    public function __construct(int $id, string $intitule, int $points, string $reponseCorrecte)
    {
        parent::__construct($id, $intitule, $points, 'ouverture');
        $this->reponseCorrecte = $reponseCorrecte;
    }

    public function verifierReponse($reponseUtilisateur): bool
    {
        return strtolower(trim($reponseUtilisateur)) === strtolower(trim($this->reponseCorrecte));
    }

    public function renderForm(): string
    {
        $html = '<div class="question">';
        $html .= '<h3>' . htmlspecialchars($this->intitule) . ' <span class="points">(' . $this->points . ' points)</span></h3>';
        
        $input = new Text('question_' . $this->id, '', ['required' => 'required', 'class' => 'text-input']);
        $html .= $input->render();
        
        $html .= '</div>';
        return $html;
    }
}
