<?php

namespace Form\Type;

class Hidden extends Input
{
    public function __construct(string $name, string $value = '', array $attributes = [])
    {
        parent::__construct('hidden', $name, $value, $attributes);
    }
}
