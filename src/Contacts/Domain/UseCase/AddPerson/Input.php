<?php

declare(strict_types=1);


namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class Input
{
    private string $name;
    /**
     * @var InputContact[]
     */
    private array $contacts;
    /**
     * @param string $name
     * @param InputContact[] $contacts
     */
    public function __construct(string $name, array $contacts)
    {
        $this->name = $name;
        $this->contacts = $contacts;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Get the value of contacts
     * 
     * @return InputContact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }
}
