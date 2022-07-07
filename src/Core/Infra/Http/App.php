<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Http;

use Slim\App as SlimApp;
use Slim\Factory\AppFactory;
use Edeno\PhpCleanContactList\Core\Infra\Http\Routes;
use Edeno\PhpCleanContactList\Core\Infra\Container\PhpDiAdapter;

/**
 * @author Edeno Luiz Scherer <edeno.scherer@estrela10.com.br>
 * @since 2021-07-23
 */
final class App
{
    /**
     * @var mixed[]
     */
    protected static $settings = [];
    /**
     * @var \E10Clean\Core\Infra\Http\App
     */
    protected static App $instance;
    /**
     * @var \Slim\App
     */
    protected $app;

    private function __construct()
    {
        self::initSettings();
        // Create Container using PHP-DI
        $container = PhpDiAdapter::build();

        $this->app = AppFactory::createFromContainer($container);
        $this->initRoutes();
        if (IS_DEVELOPMENT) {
            $this->app->addErrorMiddleware(true, true, true);
        }
        $this->app->addBodyParsingMiddleware();
        $this->app->addRoutingMiddleware();
    }

    /**
     * Retorna uma instância única de uma classe.
     *
     * @return self A Instância única.
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @return \Slim\App
     */
    public function getSlimApp(): SlimApp
    {
        return $this->app;
    }

    protected function initRoutes(): void
    {
        Routes::initRoutes($this->getSlimApp());
    }

    /**
     * Busca as configurações
     *
     * @return void
     */
    protected static function initSettings(): void
    {
        self::$settings = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR  . 'Settings.php';
    }

    /**
     * Retorna a lista de configurações
     *
     * @return array
     */
    public static function getSettings(): array
    {
        if (empty(self::$settings)) {
            self::initSettings();
        }
        return self::$settings;
    }
}
