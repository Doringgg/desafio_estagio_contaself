<?php

require_once "backend/src/routes/Router.php";
require_once "backend/src/utils/HttpResponse.php";

require_once "backend/src/controllers/AlunosControl.php";
require_once "backend/src/middleware/AlunosMiddleware.php";

require_once "backend/src/Controllers/CursosControl.php";
require_once "backend/src/middleware/CursosMiddleware.php";

class Roteador
{
    public function __construct(private Router $router = new Router())
    {
        $this->router = new Router();

        $this->setupHeaders();
        $this->setupAlunosRoutes();
        $this->setupCursosRoutes();

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


            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro no cadastro de um novo curso'

                );
            }
        });

        $this->router->get('/cursos', function (): never{
            try{

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

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro no cadastro de um novo curso'

                );
            }
        });

        $this->router->get('/alunos', function (): never {
            try{

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });

        $this->router->get('/alunos/(\d+)', function (): never {
            try{

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });

        $this->router->get('/alunos/([A-Za-z0-9\-]+)', function (): never {
            try{

            } catch (Throwable $throwable){

                $this->sendErrorResponse(
                    $throwable,
                    'Erro na seleção de dados'

                );
            }
        });
    }

    public function start(): void
    {
        $this->router->run();
    }
}