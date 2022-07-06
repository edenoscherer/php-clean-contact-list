<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople;

use JsonSerializable;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class OutputContact implements JsonSerializable
{
    private int $id;
    private string $type;
    private string $value;

    public function __construct(
        int $id,
        string $type,
        string $value,
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
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

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
