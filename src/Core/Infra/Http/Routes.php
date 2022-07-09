<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Http;

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;
use Edeno\PhpCleanContactList\Contacts\Application\Controllers\AddPersonController;
use Edeno\PhpCleanContactList\Contacts\Application\Controllers\ListPeopleController;
use Edeno\PhpCleanContactList\Contacts\Application\Controllers\DeletePersonController;
use Edeno\PhpCleanContactList\Contacts\Application\Controllers\UpdatePersonController;
use Edeno\PhpCleanContactList\Contacts\Application\Controllers\PersonDetailsController;

/**
 * @author Edeno Luiz Scherer <edeno.scherer@estrela10.com.br>
 * @since 2021-07-23
 */
final class Routes
{
    public static function initRoutes(App $app)
    {
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write('Hello World');
            return $response;
        });

        $app->group('/contacts', function (RouteCollectorProxy $group) {
            $group->post('', AddPersonController::class);
            $group->get('', ListPeopleController::class);
            $group->get('/{id:[0-9]+}', PersonDetailsController::class);
            $group->put('/{id:[0-9]+}', UpdatePersonController::class);
            $group->delete('/{id:[0-9]+}', DeletePersonController::class);
        });

        /**
         * Catch-all route to serve a 404 Not Found page if none of the routes match
         * NOTE: make sure this route is defined last
         * @source http://www.slimframework.com/docs/v4/cookbook/enable-cors.html
         */
        $app->map(
            ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
            '/{routes:.+}',
            function (Request $request): Response {
                throw new HttpNotFoundException($request);
            }
        );
    }
}
