<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Application\Presentation;

use RuntimeException;
use Slim\Psr7\Stream;
use Edeno\PhpCleanContactList\Core\Utils\HttpStatusCode;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @author Edeno Luiz Scherer <edeno.scherer@estrela10.com.br>
 * @since 2021-07-22
 */
final class JsonPresentation
{
    public function render(Response $response, $data, ?int $status = HttpStatusCode::HTTP_OK, ?int $encodingOptions = JSON_PRETTY_PRINT): Response
    {
        // $json = json_encode($data, $encodingOptions);
        // if ($json === false) {
        //     throw new RuntimeException(json_last_error_msg(), json_last_error());
        // }
        // $response->getBody()->write($json);
        // return $response->withHeader('Content-Type', 'application/json')->withStatus($status);

        $response = $response->withBody(new Stream(fopen('php://temp', 'r+')));
        $response->getBody()->write($json = json_encode($data, $encodingOptions));

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new RuntimeException(json_last_error_msg(), json_last_error());
        }

        $responseWithJson = $response->withHeader('Content-Type', 'application/json');
        if (isset($status)) {
            return $responseWithJson->withStatus($status);
        }
        return $responseWithJson;
    }
}
