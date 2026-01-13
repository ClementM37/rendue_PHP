<?php

namespace Provider;

interface DataLoaderInterface
{
    public function load(string $source): array;
}
