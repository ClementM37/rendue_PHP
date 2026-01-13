<?php

namespace Form\Type;

use Form\GenericFormElement;

class Input extends GenericFormElement
{
    private string $type;

    public function __construct(string $type, string $name, string $value = '', array $attributes = [], string $label = '')
    {
        parent::__construct($name, $value, $attributes, $label);
        $this->type = $type;
    }

    public function render(): string
    {
        $html = '';
        
        if ($this->label) {
            $html .= '<label for="' . htmlspecialchars($this->name) . '">' . htmlspecialchars($this->label) . '</label>';
        }
        
        $html .= '<input type="' . htmlspecialchars($this->type) . '" ';
        $html .= 'name="' . htmlspecialchars($this->name) . '" ';
        $html .= 'id="' . htmlspecialchars($this->name) . '" ';
        
        if ($this->value) {
            $html .= 'value="' . htmlspecialchars($this->value) . '" ';
        }
        
        if (!empty($this->attributes)) {
            $html .= $this->buildAttributes() . ' ';
        }
        
        $html .= '>';
        
        return $html;
    }
}
