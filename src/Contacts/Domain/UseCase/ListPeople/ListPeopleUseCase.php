<?php

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople;

use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople\Output;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople\OutputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;

final class ListPeopleUseCase
{
    protected PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return Output[]
     */
    public function handle(): array
    {
        $res = $this->repository->all();
        $peope = [];
        foreach ($res as $person) {
            $peope[] = new Output($person->getId(), $person->getName(), $this->makeOutputContactList($person->getContacts()));
        }
        return $peope;
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
