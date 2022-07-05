<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\Repositories;

use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
interface ContactRepositoryInterface
{

    /**
     * @return ContactEntity[]
     */
    public function all(): array;

    /**
     * @param integer $id
     * @return ContactEntity|null
     */
    public function getById(int $id): ?ContactEntity;

    /**
     * @param integer $idPerson
     * @return ContactEntity[]
     */
    public function getByIdPerson(int $idPerson): array;

    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function add(ContactEntity &$contact): ContactEntity;
    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function update(ContactEntity &$contact): ContactEntity;
    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool;
}
