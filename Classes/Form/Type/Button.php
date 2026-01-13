<?php

namespace Form\Type;

use Form\GenericFormElement;

class Button extends GenericFormElement
{
    private string $type;

    public function __construct(string $type = 'submit', string $name = '', string $value = 'Valider', array $attributes = [])
    {
        parent::__construct($name, $value, $attributes);
        $this->type = $type;
    }

    public function render(): string
    {
        $html = '<button type="' . htmlspecialchars($this->type) . '" ';
        
        if ($this->name) {
            $html .= 'name="' . htmlspecialchars($this->name) . '" ';
        }
        
        if (!empty($this->attributes)) {
            $html .= $this->buildAttributes() . ' ';
        }
        
        $html .= '>';
        $html .= htmlspecialchars($this->value);
        $html .= '</button>';
        
        return $html;
    }
}
