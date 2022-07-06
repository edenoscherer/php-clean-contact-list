<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\DeletePerson;

use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class DeletePersonUseCase
{
    protected PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $id): bool
    {
        $person = $this->repository->getById($id);
        if (!$person) {
            return false;
        }
        return $this->repository->deleteById($person->getId());
    }
}
