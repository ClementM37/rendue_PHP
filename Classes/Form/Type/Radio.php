<?php

namespace Form\Type;

use Form\GenericFormElement;

class Radio extends GenericFormElement
{
    private array $options;
    private string $selectedValue;

    public function __construct(string $name, array $options, string $selectedValue = '', string $label = '')
    {
        parent::__construct($name, '', [], $label);
        $this->options = $options;
        $this->selectedValue = $selectedValue;
    }

    public function render(): string
    {
        $html = '';
        
        if ($this->label) {
            $html .= '<div class="radio-group-label">' . htmlspecialchars($this->label) . '</div>';
        }
        
        $html .= '<div class="radio-group">';
        
        foreach ($this->options as $value => $label) {
            $id = $this->name . '_' . $value;
            $checked = ($this->selectedValue === (string)$value) ? 'checked' : '';
            
            $html .= '<label for="' . htmlspecialchars($id) . '">';
            $html .= '<input type="radio" ';
            $html .= 'name="' . htmlspecialchars($this->name) . '" ';
            $html .= 'id="' . htmlspecialchars($id) . '" ';
            $html .= 'value="' . htmlspecialchars((string)$value) . '" ';
            $html .= $checked . ' required>';
            $html .= htmlspecialchars($label);
            $html .= '</label>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}
