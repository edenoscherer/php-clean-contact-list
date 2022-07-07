<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Container;

use DI\Container;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Edeno\PhpCleanContactList\Core\Infra\Container\ContainerInterface;
use Edeno\PhpCleanContactList\Core\Infra\Database\Eloquent\Connection;
use Edeno\PhpCleanContactList\Contacts\Infra\RegisterContactsContainers;


/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class PhpDiAdapter implements ContainerInterface
{
    private static ?PsrContainerInterface $container = null;

    /**
     * @inheritDoc
     */
    public static function getContainer(): PsrContainerInterface
    {
        if (!self::$container) {
            self::build();
        }
        return self::$container;
    }

    /**
     * @inheritDoc
     */
    public static function build(): PsrContainerInterface
    {
        $container = new Container();
        $container->set(
            'settings',
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR  . 'Settings.php'
        );

        $container->set(
            Connection::class,
            Connection::getInstance()
        );

        foreach (RegisterContactsContainers::getRepositoriesClass() as $class) {
            $container->set(
                $class->getName(),
                $class->getClass()
            );
        }

        self::$container = $container;

        return $container;
    }
}
