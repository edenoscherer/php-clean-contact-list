<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\Repositories;

use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
interface PersonRepositoryInterface
{

    /**
     * @return PersonEntity[]
     */
    public function all(): array;

    /**
     * @param integer $id
     * @return PersonEntity|null
     */
    public function getById(int $id): ?PersonEntity;
    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function add(PersonEntity &$person): PersonEntity;
    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function update(PersonEntity &$person): PersonEntity;
    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool;
}
