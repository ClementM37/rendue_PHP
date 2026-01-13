<?php

namespace Quiz;

use Form\Type\Checkbox;

class QuestionChoixMultipleCheckbox extends Question
{
    private array $choix;
    private array $reponsesCorrectes;

    public function __construct(int $id, string $intitule, int $points, array $choix, array $reponsesCorrectes)
    {
        parent::__construct($id, $intitule, $points, 'choix_multiple_checkbox');
        $this->choix = $choix;
        $this->reponsesCorrectes = array_map('intval', $reponsesCorrectes);
        sort($this->reponsesCorrectes);
    }

    public function getChoix(): array
    {
        return $this->choix;
    }

    public function verifierReponse($reponseUtilisateur): bool
    {
        if (!is_array($reponseUtilisateur)) {
            return false;
        }

        $reponseInt = array_map('intval', $reponseUtilisateur);
        sort($reponseInt);

        return $reponseInt === $this->reponsesCorrectes;
    }

    public function renderForm(): string
    {
        $html = '<div class="question">';
        $html .= '<h3>' . htmlspecialchars($this->intitule) . ' <span class="points">(' . $this->points . ' points)</span></h3>';

        foreach ($this->choix as $index => $choix) {
            // name with [] to submit as array
            $checkbox = new Checkbox('question_' . $this->id . '[]', (string)$index, false, [], $choix);
            $html .= $checkbox->render();
        }

        $html .= '</div>';
        return $html;
    }
}
