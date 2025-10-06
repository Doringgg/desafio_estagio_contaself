<?php

declare(strict_types=1);

class cursos implements JsonSerializable
{
    public function __construct(
        private ?int $id = null,
        private string $nome = "",
    ){}

    public function jsonSerialize(): array
    {
        return[
            'id'=>$this->getId(),
            'nome'=>$this->getNome()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // GETs e SETs para $nome
    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
}