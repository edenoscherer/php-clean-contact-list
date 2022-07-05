<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson;

use JsonSerializable;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */

final class Output implements JsonSerializable
{
    private int $id;
    private string $name;
    /**
     * @var OutputContact[]
     */
    private array $contacts;
    /**
     * @param integer $id
     * @param string $name
     * @param OutputContact[] $contacts
     */
    public function __construct(
        int $id,
        string $name,
        array $contacts
    ) {
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
     * @return OutputContact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }


    public function toArray(): array
    {
        $contacts = $this->getContacts();
        $contactsValues = [];
        foreach ($contacts as $contact) {
            $contactsValues[] = $contact->toArray();
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'contacts' => $contactsValues,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
