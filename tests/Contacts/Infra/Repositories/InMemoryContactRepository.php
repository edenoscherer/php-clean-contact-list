<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Infra\Repositories;

use Exception;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\ContactRepositoryInterface;

final class InMemoryContactRepository implements ContactRepositoryInterface
{
    /**
     * @var ContactEntity[]
     */
    protected array $contacts;

    public function __construct()
    {
        $this->contacts = [];
    }


    /**
     * @return ContactEntity[]
     */
    public function all(): array
    {
        return $this->contacts;
    }

    /**
     * @param integer $id
     * @return ContactEntity|null
     */
    public function getById(int $id): ?ContactEntity
    {
        foreach ($this->contacts as $contact) {
            if ($contact->getId() == $id) {
                return $contact;
            }
        }
    }

    /**
     * @param integer $idPerson
     * @return ContactEntity[]
     */
    public function getByIdPerson(int $idPerson): array
    {
        $contacts = [];
        foreach ($this->contacts as $contact) {
            if ($contact->getIdPerson() == $idPerson) {
                $contacts[] = $contact;
            }
        }
        return $contacts;
    }

    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function add(ContactEntity &$contact): ContactEntity
    {
        $contact->setId(rand(10, 1000));
        $this->contacts[] = $contact;
        return $contact;
    }

    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function update(ContactEntity &$contact): ContactEntity
    {
        foreach ($this->contacts as $key => $row) {
            if ($row->getId() == $contact->getId()) {
                $this->contacts[$key] = $contact;
                return $contact;
            }
        }
        throw new Exception("Contact not found", 404);
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        foreach ($this->contacts as $key => $row) {
            if ($row->getId() == $id) {
                unset($this->contacts[$key]);
                return true;
            }
        }
        return false;
    }
}
