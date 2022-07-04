<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\Entities;

use stdClass;
use JsonSerializable;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class PersonEntity implements JsonSerializable
{
    private ?int $id;
    private string $name;
    /** @var ContactEntity[] */
    private array $contacts;

    public function __construct(
        stdClass $params
    ) {
        $this->setId($params->id);
        $this->setName($params->name);
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of contacts
     * @return ContactEntity[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * Set the value of name
     * 
     * @param ContactEntity[]|stdClass[] $contacts
     * @return self
     */
    public function setContacts(array $contacts): self
    {
        /** @var ContactEntity[] */
        $values = [];
        foreach ($contacts as $contact) {
            if ($contact instanceof ContactEntity) {
                $values[] = $contact;
                continue;
            }
            $values[] = new ContactEntity($contact);
        }
        $this->contacts = $contacts;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $contacts = $this->getContacts();
        $contactsValues = [];
        if ($contacts) {
            foreach ($contacts as $contact) {
                $contactsValues[] = $contact->jsonSerialize();
            }
        }
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "contacts" => $contactsValues,
        ];
    }
}
