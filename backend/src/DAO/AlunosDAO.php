<?php

require_once (__DIR__ . '/../models/alunos.php');
require_once (__DIR__ . '/../DAO/cursosDAO.php');
require_once (__DIR__ . '/../database/database.php');

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
        
        $cursosDAO = new CursosDAO();
        $alunos->getCurso()->setNome($cursosDAO->getCursoByID($alunos->getCurso()->getId(),"name"));

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

    public function readByID(int $idCurso): array
    {
        $query = 'SELECT alunos.id, 
                        alunos.nome, 
                        alunos.idade, 
                        cursos.id AS id_curso, 
                        cursos.nome AS nome_curso 
                        FROM alunos LEFT JOIN cursos 
                        ON alunos.curso_id = cursos.id WHERE cursos.id = :idCurso ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':idCurso',
            $idCurso,
        PDO::PARAM_INT);

        $statement->execute();

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

        $statement->execute();

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

    public function relatorio(): array 
    {
        $query = 'SELECT 
        cursos.nome AS nome_curso,
        COUNT(alunos.id) AS total_alunos,
        AVG(alunos.idade) AS media_idade
        FROM cursos
        LEFT JOIN alunos ON cursos.id = alunos.curso_id
        GROUP BY cursos.id, cursos.nome
        ORDER BY total_alunos DESC;' ;

        $statement = Database::getConnection()->query($query);

        $relatorio = $statement->fetchAll(PDO::FETCH_OBJ);

        return $relatorio;
    }
}