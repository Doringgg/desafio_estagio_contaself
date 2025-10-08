<?php

require_once (__DIR__ . '/../routes/Router.php');
require_once(__DIR__ . '/../utils/HttpResponse.php');

require_once (__DIR__ . '/../controllers/AlunosControl.php');
require_once (__DIR__ . '/../controllers/CursosControl.php');

require_once (__DIR__ . '/../middleware/AlunosMiddleware.php');
require_once (__DIR__ . '/../middleware/CursosMiddleware.php');

class Roteador
{
    public function __construct(private Router $router = new Router())
    {

        $this->router->setBasePath('');

        $this->setupHeaders();
        $this->setupAlunosRoutes();
        $this->setupCursosRoutes();
        $this->setup404route();

    }

    private function setupHeaders(): void
    {
        header(header: 'Access-Control-Allow-Method: GET, POST, PUT, DELETE');
        header(header: 'Access-Control-Allow-Origin: *');
        header(header: 'Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    private function sendErrorResponse(Throwable $throwable, string $message): never
    {
        (new Response(
            false,
            $message,
            error: [
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage()
            ],
            httpCode: 500
        ))->send();
    }

    private function setupCursosRoutes(): void
    {
        $this->router->post('/cursos', function (): never{
            try{
                $requestBody = file_get_contents('php://input');
                $cursosMiddleware = new CursosMiddleware();
                $stdCurso = $cursosMiddleware->stringJsonToStdClass($requestBody);
                $stdCurso->cursos->nome = $cursosMiddleware->
                                            isValidNomeCurso($stdCurso->cursos->nome);
                $cursosControl = new CursosControl();
                $cursosControl->createControl($stdCurso);

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro no cadastro de um novo curso'

                );
            }
        });

        $this->router->get('/cursos', function (): never {
            try{

                $cursosControl = new CursosControl();
                $cursosControl->readALLControl();

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });

    }

    private function setupAlunosRoutes(): void
    {
        $this->router->post('/alunos', function (): never {
            try{
                $requestBody = file_get_contents('php://input');

                $alunosMiddleware = new AlunosMiddleware();
                $stdAlunos = $alunosMiddleware->stringJsonToStdClass($requestBody);

                $stdAlunos->alunos->nome = $alunosMiddleware->
                                            isValidNomeAluno($stdAlunos->alunos->nome);
                $alunosMiddleware->
                            isValidIdadeAluno($stdAlunos->alunos->idade)
                            ->isValidCurso($stdAlunos->alunos->curso_id);
                
                $alunosControl = new AlunosControl();
                $alunosControl->createControl($stdAlunos);

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro no cadastro de um novo curso'

                );
            }
        });

        $this->router->get('/alunos', function (): never {
            try{

                $alunosControl = new AlunosControl();
                $alunosControl->readALLControl();

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });

        $this->router->get('/alunos/(\d+)', function ($curso_id): void {
            try{

                echo $curso_id;

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });

        $this->router->get('/alunos/([A-Za-z\-]+)', function ($nomeCurso): never {
            try{

                $cursosMiddleware = new CursosMiddleware();
                $nomeCurso = $cursosMiddleware->isValidNomeCurso($nomeCurso);
                
                $alunosControl = new AlunosControl();
                $alunosControl->readByCurso($nomeCurso);

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });
    }

    private function setup404route(): void{
    $this->router->set404(function () {
        (new Response(
            success: false,
            message: 'Rota não encontrada',
            data: [],
            error: [],
            httpCode: 404
        ))->send();
    });
}

    public function start(): void
    {
        $this->router->run();
    }
}