<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Database\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection as EloquentConnection;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class Connection
{
    protected static Connection $instance;

    protected Capsule $capsule;

    private function __construct()
    {
        // Database configuration
        $settings = array(
            'driver'    => $_ENV['DB_CONNECTION'],
            'host'      => $_ENV['DB_HOST'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'database'  => $_ENV['DB_DATABASE'],
            'port'      => $_ENV['DB_PORT'],
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        );

        $capsule = new Capsule();

        $capsule->addConnection($settings);

        // Make this Capsule instance available globally via static methods
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM
        $capsule->bootEloquent();

        $phpEnv = getenv('PHP_ENV');

        if ($phpEnv != 'production') {
            // Query logs
            $capsule->connection()->enableQueryLog();
        }

        Carbon::setLocale('pt_BR');
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
     * @param string|null $connectionName
     *
     * @return \Illuminate\Database\Connection
     */
    public function getEloquentConnection(?string $connectionName = null): EloquentConnection
    {
        if ($connectionName) {
            return $this->capsule->getConnection($connectionName);
        }
        return $this->capsule->getConnection();
    }

    /**
     * @return \Illuminate\Database\Capsule\Manager
     */
    public function getCapsule(): Capsule
    {
        return $this->capsule;
    }
}
