<?php

namespace Form\Type;

use Form\GenericFormElement;

class Checkbox extends GenericFormElement
{
    private bool $checked;

    public function __construct(string $name, string $value = '1', bool $checked = false, array $attributes = [], string $label = '')
    {
        parent::__construct($name, $value, $attributes, $label);
        $this->checked = $checked;
    }

    public function render(): string
    {
        $html = '<label>';
        $html .= '<input type="checkbox" ';
        $html .= 'name="' . htmlspecialchars($this->name) . '" ';
        $html .= 'value="' . htmlspecialchars($this->value) . '" ';
        
        if ($this->checked) {
            $html .= 'checked ';
        }
        
        if (!empty($this->attributes)) {
            $html .= $this->buildAttributes() . ' ';
        }
        
        $html .= '>';
        
        if ($this->label) {
            $html .= ' ' . htmlspecialchars($this->label);
        }
        
        $html .= '</label>';
        
        return $html;
    }
}
