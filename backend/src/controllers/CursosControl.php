<?php

require_once "backend/src/models/cursos.php";
require_once "backend/src/DAO/CursosDAO.php";
require_once "backend/src/utils/HttpResponse.php";

class CursosControl
{
    public function createControl(stdClass $stdCurso): never
    {
        $cursos = new cursos();

        $cursos->setNome($stdCurso->curso->nome);

        $cursosDAO = new CursosDAO();

        $newCurso = $cursosDAO->create($cursos);
        (new Response(
            success: true,
            message: 'Curso registrado com sucesso',
            data: [
                'Curso' => $newCurso
            ],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readALLControl(): never
    {
        $cursosDAO = new CursosDAO();

        $cursos = $cursosDAO->readALL();

        (new Response(
            true,
            'Dados selecionados com sucesso',
            ['Cursos' => $cursos],
            httpCode: 200
        ))->send();

        exit();
    }
}
