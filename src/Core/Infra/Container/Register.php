<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Core\Infra\Container;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class Register
{
    private string $name;
    private $class;

    public function __construct(string $name, $class)
    {
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the value of name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of class
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }
}
