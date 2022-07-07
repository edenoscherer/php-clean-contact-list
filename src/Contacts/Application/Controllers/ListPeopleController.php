<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Application\Controllers;

use Throwable;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Edeno\PhpCleanContactList\Core\Utils\HttpStatusCode;
use Edeno\PhpCleanContactList\Core\Application\Presentation\JsonPresentation;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople\ListPeopleUseCase;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class ListPeopleController
{
    protected ListPeopleUseCase $listPeopleCase;
    protected JsonPresentation $jsonPresentation;

    public function __construct(ListPeopleUseCase $listPeopleCase, JsonPresentation $jsonPresentation)
    {
        $this->listPeopleCase = $listPeopleCase;
        $this->jsonPresentation = $jsonPresentation;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $status = HttpStatusCode::HTTP_OK;
        try {
            $output = [
                'success' => true,
                'data' => $this->listPeopleCase->handle()
            ];
        } catch (Throwable $th) {
            $output = [
                'success' => false,
                'errors' => [[
                    'error' => $th->getMessage(),
                    // 'file' => $th->getFile(),
                    // 'line' => $th->getLine(),
                    // 'type' => 'ERROR',
                    // 'previous' => $th->getPrevious(),
                    // 'trace' => $th->getTrace()
                ]],
            ];
            $status = HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR;
        }
        return $this->jsonPresentation->render($response, $output, $status);
    }
}
