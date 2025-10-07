<?php

require_once "backend/src/models/alunos.php";
require_once "backend/src/database/database.php";

Class AlunosDAO
{
    public function create(alunos $alunos): alunos
    {
        $query = 'INSERT INTO alunos (
                            nome,
                            idade,
                            curso_id
                            ) VALUES (
                            :nome,
                            :idade,
                            :curso_id) ;' ;

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':nome',
            $alunos->getNome(),
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':idade',
            $alunos->getIdade(),
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':curso_id',
            $alunos->getCurso()->getId(),
        PDO::PARAM_INT);

        $statement->execute();

        $alunos->setId(Database::getConnection()->lastInsertId());

        return $alunos;
    }

    public function readALL(): array
    {
        $query = 'SELECT alunos.id, 
                        alunos.nome, 
                        alunos.idade, 
                        cursos.id AS id_curso, 
                        cursos.nome AS nome_curso 
                        FROM alunos LEFT JOIN cursos 
                        ON alunos.curso_id = cursos.id ;';

        $statement = Database::getConnection()->query($query);

        $results = [];

        while ($line = $statement->fetch(PDO::FETCH_OBJ)) {
            
            $alunos = (new alunos())->setId($line->id);
            $alunos->setNome($line->nome);
            $alunos->setIdade($line->idade);
            $alunos->getCurso()
                ->setId($line->id_curso);
            $alunos->getCurso()
                ->setNome($line->nome_curso);

            $results[] = $alunos;
        }
        return $results;
    }

    public function readByID(int $idAluno): array
    {
        $query = 'SELECT alunos.id, 
                        alunos.nome, 
                        alunos.idade, 
                        cursos.id AS id_curso, 
                        cursos.nome AS nome_curso 
                        FROM alunos LEFT JOIN cursos 
                        ON alunos.curso_id = cursos.id WHERE alunos.id = :idAluno ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':idAluno',
            $idAluno,
        PDO::PARAM_INT);

        $aluno = new alunos();

        $statement->execute();

        $line = $statement->fetch(PDO::FETCH_OBJ);

        if(!$line) {
            return[];
        }

        $aluno
            ->setId($line->id)
            ->setNome($line->nome)
            ->setIdade($line->idade);

        $aluno->getCurso()
            ->setId($line->id_curso);

        $aluno->getCurso()
            ->setNome($line->nome_curso);

        return [$aluno];
    }

    public function readByCurso(string $nomeCurso): array
    {
        $query = 'SELECT alunos.id, 
                        alunos.nome, 
                        alunos.idade, 
                        cursos.id AS id_curso, 
                        cursos.nome AS nome_curso 
                        FROM alunos LEFT JOIN cursos 
                        ON alunos.curso_id = cursos.id WHERE cursos.nome = :nomeCurso ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':nomeCurso',
            $nomeCurso,
            PDO::PARAM_STR
        );

        $aluno = new alunos();

        $line = $statement->fetch(PDO::FETCH_OBJ);

        if(!$line) {
            return[];
        }

        $aluno
            ->setId($line->id)
            ->setNome($line->nome)
            ->setIdade($line->idade);

        $aluno->getCurso()
            ->setId($line->id_curso);

        $aluno->getCurso()
            ->setNome($line->nome_curso);

        return [$aluno];
    }
}