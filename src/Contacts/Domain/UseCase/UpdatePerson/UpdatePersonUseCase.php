<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson;

use stdClass;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\Output;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\InputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 */
final class UpdatePersonUseCase
{
    protected PersonRepositoryInterface $repository;

    public function __construct(PersonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Input $input): Output
    {
        $person = $this->makePerson($input);
        $res = $this->repository->update($person);

        return new Output($res->getId(), $res->getName(), $this->makeOutputContactList($res->getContacts()));
    }


    protected function makePerson(Input $input): PersonEntity
    {
        $params = new stdClass();
        $params->name = $input->getName();
        $params->contacts = $this->makeContactList($input->getContacts());

        return new PersonEntity($params);
    }

    /**
     * @param InputContact[] $contacts
     * @return ContactEntity[]
     */
    protected function makeContactList(array $contacts): array
    {
        $list = [];

        foreach ($contacts as $inputContact) {
            $obj = new stdClass();
            $obj->type = $inputContact->getType();
            $obj->value = $inputContact->getValue();
            $list[] = new ContactEntity($obj);
        }
        return $list;
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
