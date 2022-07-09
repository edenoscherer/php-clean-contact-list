<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Application\Controllers;

use Throwable;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Edeno\PhpCleanContactList\Core\Utils\HttpStatusCode;
use Edeno\PhpCleanContactList\Core\Application\Presentation\JsonPresentation;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\DeletePerson\DeletePersonUseCase;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class DeletePersonController
{
    protected DeletePersonUseCase $DeletePersonCase;
    protected JsonPresentation $jsonPresentation;

    public function __construct(DeletePersonUseCase $DeletePersonCase, JsonPresentation $jsonPresentation)
    {
        $this->DeletePersonCase = $DeletePersonCase;
        $this->jsonPresentation = $jsonPresentation;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $status = HttpStatusCode::HTTP_ACCEPTED;
        try {

            $output = [
                'success' => true,
                'data' => $this->DeletePersonCase->handle(intval($args['id']))
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
