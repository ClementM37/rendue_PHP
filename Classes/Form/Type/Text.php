<?php

namespace Form\Type;

class Text extends Input
{
    public function __construct(string $name, string $value = '', array $attributes = [], string $label = '')
    {
        parent::__construct('text', $name, $value, $attributes, $label);
    }
}
