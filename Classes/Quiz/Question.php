<?php

namespace Quiz;

abstract class Question
{
    protected int $id;
    protected string $intitule;
    protected int $points;
    protected string $type;

    public function __construct(int $id, string $intitule, int $points, string $type)
    {
        $this->id = $id;
        $this->intitule = $intitule;
        $this->points = $points;
        $this->type = $type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIntitule(): string
    {
        return $this->intitule;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getType(): string
    {
        return $this->type;
    }

    abstract public function verifierReponse($reponseUtilisateur): bool;
    abstract public function renderForm(): string;
}
