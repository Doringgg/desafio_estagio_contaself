<?php

declare(strict_types=1);

require_once "backend/src/models/cursos.php";

class alunos implements JsonSerializable
{
    public function __construct(
        private ?int $id = null,
        private string $nome = "",
        private ?int $idade = null,
        private cursos $curso = new cursos()
    ){}

    public function jsonSerialize(): array
    {
        return[
            'id'=>$this->getId(),
            'nome'=>$this->getNome(),
            'idade'=>$this->getIdade(),
            'curso_id'=>$this->curso->getID(),
            'curso_nome'=>$this->curso->getNome()
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

    // GETs e SETs para $name
    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    // GETs e SETs para $idade
    public function getIdade(): ?int
    {
        return $this->idade;
    }

    public function setIdade(?int $idade): self
    {
        $this->idade = $idade;
        return $this;
    }

    // GETs e SETs para $curso
    public function getCurso(): cursos
    {
        return $this->curso;
    }

    public function setCurso(cursos $curso): self
    {
        $this->curso = $curso;
        return $this;
    }
}
