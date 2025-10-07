<?php 

require_once "backend/src/utils/HttpResponse.php";

class CursosMiddleware
{

    public function stringJsonToStdClass($requestBody): stdClass
    {

        $stdCurso = json_decode($requestBody);

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

        } else if (!isset($stdCurso->cursos)) {
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não existe objeto curso'
                ],
                httpCode: 400
            ))->send();

            exit();

        } else if (!isset($stdCurso->cursos->nome)){
            
            (new Response(
                false,
                'Informação Inválida',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Não enviado o nome do curso'
                ],
                httpCode: 400
            ))->send();

            exit();
        }

        return $stdCurso;
    }

    public function isValidNomeCurso(string $nomeCurso): string
    {
        $nomeCurso = trim(string: $nomeCurso);

        if(strlen(string: $nomeCurso) < 3){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do curso não pode ser nulo ou ter menos de 3 caracteres'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        if(preg_match(pattern: '/[^\w\sÀ-ÿ\-\.\#\&\/]/', subject: $nomeCurso)){
            (new Response(
                success: false,
                message: 'Informações Inválidas',
                error: [
                    'ErrorCode' => 'validation_error',
                    'message' => 'Nome do curso contém caracteres inválidos'
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        $nomeCurso = preg_replace(pattern: '/\s+/', replacement: ' ', subject: $nomeCurso);
        $nomeCurso = mb_convert_case(string: $nomeCurso, mode: MB_CASE_TITLE, encoding: 'UTF-8');

        return $nomeCurso;
    }
}