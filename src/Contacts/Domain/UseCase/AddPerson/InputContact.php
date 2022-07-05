<?php

declare(strict_types=1);


namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class InputContact
{
    private string $type;
    private string $value;
    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the value of type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the value of value
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
