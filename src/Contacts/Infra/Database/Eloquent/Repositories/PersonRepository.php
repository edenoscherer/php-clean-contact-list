<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Repositories;

use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;
use Edeno\PhpCleanContactList\Core\Infra\Database\Eloquent\Connection;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models\PeopleModel;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Repositories\ContactRepository;

final class PersonRepository implements PersonRepositoryInterface
{
    protected ContactRepository $contactRepository;

    public function __construct(ContactRepository $repository)
    {
        $this->contactRepository = $repository;
    }
    /**
     * @return PersonEntity[]
     */
    public function all(): array
    {
        /** @var PeopleModel[] */
        $res = PeopleModel::query()->with('contacts')->orderBy('name')->get();
        $people = [];
        foreach ($res as $person) {
            $people[] = $person->createPersonEntity();
        }
        return $people;
    }

    /**
     * @param integer $id
     * @return PersonEntity|null
     */
    public function getById(int $id): ?PersonEntity
    {
        /** @var PeopleModel|null */
        $res = PeopleModel::query()->with('contacts')->where('id', $id)->first();
        return $res ? $res->createPersonEntity() : null;
    }

    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function add(PersonEntity &$person): PersonEntity
    {
        $conn = Connection::getInstance()->getEloquentConnection();
        $conn->beginTransaction();
        try {
            $model = new PeopleModel();
            $model->name = $person->getName();
            $model->save();

            $person->setId($model->id);

            foreach ($person->getContacts() as &$contact) {
                $contact->setIdPerson($person->getId());
                $this->contactRepository->add($contact);
            }

            $conn->commit();
            return $person;
        } catch (\Throwable $th) {
            $conn->rollBack();
            throw $th;
        }
    }
    /**
     * @param PersonEntity $person
     * @return PersonEntity
     */
    public function update(PersonEntity &$person): PersonEntity
    {
        $conn = Connection::getInstance()->getEloquentConnection();
        $conn->beginTransaction();

        try {
            /** @var PeopleModel */
            $model = PeopleModel::query()->find($person->getId());
            $model->name = $person->getName();
            $model->save();


            $oldContacts = $this->contactRepository->getByIdPerson($person->getId());
            foreach ($oldContacts as $contact) {
                $this->contactRepository->deleteById($contact->getId());
            }

            foreach ($person->getContacts() as &$contact) {
                $contact->setIdPerson($person->getId());
                $this->contactRepository->add($contact);
            }


            $conn->commit();
            return $person;
        } catch (\Throwable $th) {
            $conn->rollBack();
            throw $th;
        }
    }
    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        $conn = Connection::getInstance()->getEloquentConnection();
        $conn->beginTransaction();
        try {
            /** @var PeopleModel */
            $model = PeopleModel::query()->find($id);
            if (!$model) {
                return false;
            }

            $oldContacts = $this->contactRepository->getByIdPerson($id);
            foreach ($oldContacts as $contact) {
                $this->contactRepository->deleteById($contact->getId());
            }

            $res = $model->delete();
            $conn->commit();
            return $res == true;
        } catch (\Throwable $th) {
            $conn->rollBack();
            throw $th;
        }
    }
}
