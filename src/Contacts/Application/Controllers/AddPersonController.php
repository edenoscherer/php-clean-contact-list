<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Application\Controllers;

use Throwable;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Edeno\PhpCleanContactList\Core\Utils\HttpStatusCode;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\InputContact;
use Edeno\PhpCleanContactList\Core\Application\Presentation\JsonPresentation;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\AddPersonUseCase;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class AddPersonController
{
    protected AddPersonUseCase $addPersonCase;
    protected JsonPresentation $jsonPresentation;

    public function __construct(AddPersonUseCase $addPersonCase, JsonPresentation $jsonPresentation)
    {
        $this->addPersonCase = $addPersonCase;
        $this->jsonPresentation = $jsonPresentation;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = (array)$request->getParsedBody();

        $status = HttpStatusCode::HTTP_CREATED;
        try {
            $contacts = [];
            if (!empty($data['contacts'])) {
                foreach ($data['contacts'] as $row) {
                    $contacts[] = new InputContact(
                        isset($row['type']) ? $row['type'] : '',
                        isset($row['value']) ? $row['value'] : ''
                    );
                }
            }
            $output = [
                'success' => true,
                'data' => $this->addPersonCase->handle(
                    new Input(
                        isset($data['name']) ? $data['name'] : '',
                        $contacts
                    )
                )
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
