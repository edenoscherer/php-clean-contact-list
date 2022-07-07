<?php

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\PersonDetails;

use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\PersonDetails\Output;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\PersonDetails\OutputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;

final class PersonDetailsUseCase
{
    protected PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Output
     */
    public function handle(int $id): Output
    {
        $res = $this->repository->getById($id);
        return new Output($res->getId(), $res->getName(), $this->makeOutputContactList($res->getContacts()));
    }

    /**
     * @param ContactEntity[] $contacts
     * @return OutputContact[]
     */
    protected function makeOutputContactList(array $contacts): array
    {
        $list = [];
        foreach ($contacts as $entity) {
            $list[] = new OutputContact($entity->getId(), $entity->getType(), $entity->getValue());
        }
        return $list;
    }
}
