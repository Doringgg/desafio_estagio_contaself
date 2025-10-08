<?php 

require_once (__DIR__ . '/../utils/HttpResponse.php');
require_once (__DIR__ . '/../DAO/CursosDAO.php');

class AlunosMiddleware
{

    public function stringJsonToStdClass($requestBody): stdClass
    {

        $stdAluno = json_decode($requestBody);

        if(json_last_error() !== JSON_ERROR_NONE) {

            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Json Invalido'
                ],
                httpCode: 400
            ))->send();
            
            exit();

        } else if (!isset($stdAluno->alunos)) {
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não existe objeto alunos'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdAluno->alunos->nome)){
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não foi enviado nome do aluno'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdAluno->alunos->idade)){
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não foi enviado idade do aluno'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdAluno->alunos->curso_id)){
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não foi enviado o id do curso'
                ],
                httpCode: 400
            ))->send();

            exit();
        }   

        return $stdAluno;
    }

    public function isValidNomeAluno(string $nomeAluno): string
    {
        $nomeAluno = trim(string: $nomeAluno);

        if(strlen(string: $nomeAluno) < 3){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do aluno não pode ser nulo ou ter menos de 3 letras'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        if(strlen(string: $nomeAluno) > 100){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do aluno não pode ter mais de 100 caracteres'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        if(preg_match(pattern: '/\d/', subject: $nomeAluno)){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do aluno não pode conter números'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        if(preg_match(pattern: '/[^a-zA-ZÀ-ÿ\s\-\']/', subject: $nomeAluno)){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do aluno contém caracteres inválidos'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        if(preg_match(pattern: '/^[\-\'\.]|[\-\'\.]$/', subject: $nomeAluno)){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do aluno não pode começar ou terminar com caracteres especiais'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        $partesNome = explode(' ', $nomeAluno);
        
        foreach($partesNome as $parte){
            if(mb_strlen(trim($parte)) == 1 && trim($parte) != ''){
                (new Response(
                    success: false,
                    message: 'Informações Inválidas',
                    error: [
                        'ErrorCode' => 'validation_error',
                        'message' => 'Cada parte do nome deve ter pelo menos 2 letras'
                    ],
                    httpCode: 400
                ))->send();
                exit();
            }
        }
        $nomeAluno = preg_replace(pattern: '/\s+/', replacement: ' ', subject: $nomeAluno);
        $nomeAluno = mb_convert_case(string: $nomeAluno, mode: MB_CASE_TITLE, encoding: 'UTF-8');

        return $nomeAluno;
    }

    public function isValidIdadeAluno(int $idadeAluno): self
    {

        if($idadeAluno < 3){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Idade mínima do aluno é 3 anos'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Validação: idade máxima (ex: 120 anos)
        if($idadeAluno > 120){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Idade máxima do aluno é 120 anos'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        return $this;

    }

    public function isValidCurso(int $curso_id): self
    {

        $CursosDAO = new CursosDAO();

        if ($CursosDAO->haveCurso($curso_id)){
            return $this;
        } else {
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'O id de curso é inválido'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

    }
    
}