<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanPersonList\Persons\Infra\Repositories;

use Exception;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;

final class InMemoryPersonRepository implements PersonRepositoryInterface
{
    /**
     * @var PersonEntity[]
     */
    protected array $people;

    public function __construct()
    {
        $this->people = [];
    }


    /**
     * @return PersonEntity[]
     */
    public function all(): array
    {
        return $this->people;
    }

    /**
     * @param integer $id
     * @return PersonEntity|null
     */
    public function getById(int $id): ?PersonEntity
    {
        foreach ($this->people as $person) {
            if ($person->getId() == $id) {
                return $person;
            }
        }
    }

    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function add(PersonEntity &$person): PersonEntity
    {
        $person->setId(rand(10, 1000));
        foreach ($person->getContacts() as &$contact) {
            $contact->setId(rand(10, 1000));
            $contact->setIdPerson($person->getId());
        }
        $this->people[] = $person;
        return $person;
    }

    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function update(PersonEntity &$person): PersonEntity
    {
        foreach ($this->people as $key => $row) {
            if ($row->getId() == $person->getId()) {
                foreach ($person->getContacts() as &$contact) {
                    $contact->setId(rand(10, 1000));
                    $contact->setIdPerson($person->getId());
                }
                $this->people[$key] = $person;
                return $person;
            }
        }
        throw new Exception("Person not found", 404);
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        foreach ($this->people as $key => $row) {
            if ($row->getId() == $id) {
                unset($this->people[$key]);
                return true;
            }
        }
        return false;
    }
}
