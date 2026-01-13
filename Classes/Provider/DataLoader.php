<?php

namespace Provider;

abstract class DataLoader implements DataLoaderInterface
{
    protected string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    abstract public function load(string $source): array;

    protected function validateSource(): bool
    {
        return file_exists($this->source);
    }
}
