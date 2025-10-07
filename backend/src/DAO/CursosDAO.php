<?php

require_once "backend/src/models/cursos.php";
require_once "backend/src/database/database.php"; 

class CursosDAO
{
    public function create(Cursos $curso): Cursos
    {
        $query = 'INSERT INTO cursos (nome) VALUES (:nome)';
        
        $statement = Database::getConnection()->prepare($query);
        
        $statement->bindValue(
            ':nome',
            $curso->getNome(),
            PDO::PARAM_STR
        );
        
        $statement->execute();
        
        $curso->setId(Database::getConnection()->lastInsertId());
        
        return $curso;
    }

    public function readALL(): array
    {
        $query = 'SELECT id, nome FROM cursos';
        
        $statement = Database::getConnection()->query($query);
        
        $results = [];
        
        while ($line = $statement->fetch(PDO::FETCH_OBJ)) {
            $curso = (new Cursos())
                ->setId($line->id)
                ->setNome($line->nome);
            
            $results[] = $curso;
        }
        
        return $results;
    }

    public function haveCurso($curso_id): bool
    {
        $query = 'SELECT * FROM cursos WHERE id = :curso_id ;';

        $statement = Database::getConnection()->prepare($query);

        $statement->bindValue(
            ':curso_id',
            $curso_id,
            PDO::PARAM_INT
        );

        $statement->execute();
        $line = $statement->fetch(PDO::FETCH_OBJ);

        if(!$line){
            return false;
        } else {
            return true;
        }

    }

}