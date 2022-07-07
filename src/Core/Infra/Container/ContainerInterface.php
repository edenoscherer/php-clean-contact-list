<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
interface ContainerInterface
{
    /**
     * @return \Psr\Container\ContainerInterface
     */
    public static function build(): PsrContainerInterface;

    /**
     * @return \Psr\Container\ContainerInterface
     */
    public static function getContainer(): PsrContainerInterface;
}
