<?php

require_once "backend/src/models/alunos.php";
require_once "backend/src/DAO/AlunosDAO.php";
require_once "backend/src/utils/HttpResponse.php";

class AlunosControl
{
    public function createControl(stdClass $stdAluno): never
    {
        $alunos = new alunos();

        $alunos->setNome($stdAluno->aluno->nome);
        $alunos->setIdade($stdAluno->aluno->idade);
        $alunos->getCurso()->setId($stdAluno->aluno->curso_id);

        $alunosDAO = new AlunosDAO();

        $newAluno = $alunosDAO->create($alunos);
        (new Response(
            success: true,
            message: 'Aluno registrado com sucesso',
            data: [
                'Aluno' => $newAluno
            ],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readALLControl(): never
    {
        $alunosDAO = new AlunosDAO();

        $alunos = $alunosDAO->readALL();

        (new Response(
            true,
            'Dados selecionados com sucesso',
            ['Alunos' => $alunos],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readByIDControl(int $AlunosID): never
    {
        $alunosDAO = new AlunosDAO();

        $alunos = $alunosDAO->readByID($AlunosID);
        (new Response(
            true,
            'Dados selecionados com sucesso',
            ['Alunos' => $alunos],
            httpCode: 200
        ))->send();

        exit();
    }

    public function readByCurso(string $nomeCurso): never
    {
        $alunosDAO = new AlunosDAO();

        $alunos = $alunosDAO->readByCurso($nomeCurso);
        (new Response(
            true,
            'Dados selecionados com sucesso',
            ['Alunos' => $alunos],
            httpCode: 200
        ))->send();
    }
}