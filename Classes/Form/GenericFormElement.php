<?php

namespace Form;

abstract class GenericFormElement implements InputRenderInterface
{
    protected string $name;
    protected string $value;
    protected array $attributes;
    protected string $label;

    public function __construct(string $name, string $value = '', array $attributes = [], string $label = '')
    {
        $this->name = $name;
        $this->value = $value;
        $this->attributes = $attributes;
        $this->label = $label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    protected function buildAttributes(): string
    {
        $attrs = [];
        foreach ($this->attributes as $key => $val) {
            $attrs[] = $key . '="' . htmlspecialchars($val) . '"';
        }
        return implode(' ', $attrs);
    }

    abstract public function render(): string;
}
