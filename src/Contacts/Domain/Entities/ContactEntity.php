<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\Entities;

use JsonSerializable;
use stdClass;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class ContactEntity implements JsonSerializable
{
    private ?int $id = null;
    private ?int $idPerson = null;
    private string $type;
    private string $value;

    public function __construct(
        stdClass $params
    ) {
        if ($params) {
            if (isset($params->id)) {
                $this->setId($params->id);
            }
            if (isset($params->idPerson)) {
                $this->setIdPerson($params->idPerson);
            }
            $this->setType($params->type);
            $this->setValue($params->value);
        }
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
     * Get the value of idPerson
     */
    public function getIdPerson(): ?int
    {
        return $this->idPerson;
    }

    /**
     * Set the value of idPerson
     *
     * @return  self
     */
    public function setIdPerson(int $idPerson): self
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    /**
     * Get the value of value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "idPerson" => $this->getIdPerson(),
            "type" => $this->getType(),
            "value" => $this->getValue(),
        ];
    }
}
