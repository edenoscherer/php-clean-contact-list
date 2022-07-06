<?php

declare(strict_types=1);


namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class Input
{
    private int $id;
    private string $name;
    /**
     * @var InputContact[]
     */
    private array $contacts;
    /**
     * @param string $name
     * @param InputContact[] $contacts
     */
    public function __construct(int $id, string $name, array $contacts)
    {
        $this->id = $id;
        $this->name = $name;
        $this->contacts = $contacts;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
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
