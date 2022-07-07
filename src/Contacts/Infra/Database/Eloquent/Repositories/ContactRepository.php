<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Repositories;

use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models\ContactsModel;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\ContactRepositoryInterface;

final class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @return ContactEntity[]
     */
    public function all(): array
    {
        /** @var ContactsModel[] */
        $res = ContactsModel::query()->orderBy('id_person')->get();
        $contacts = [];
        foreach ($res as $contact) {
            $contacts[] = $contact->createContactEntity();
        }
        return $contacts;
    }

    /**
     * @param integer $id
     * @return ContactEntity|null
     */
    public function getById(int $id): ?ContactEntity
    {
        /** @var ContactsModel|null */
        $res = ContactsModel::query()->find($id);
        return $res ? $res->createContactEntity() : null;
    }

    /**
     * @param integer $idPerson
     * @return ContactEntity[]
     */
    public function getByIdPerson(int $idPerson): array
    {
        /** @var ContactsModel[] */
        $res = ContactsModel::query()->where('id_person', $idPerson)->orderBy('id_person')->get();
        $contacts = [];
        foreach ($res as $contact) {
            $contacts[] = $contact->createContactEntity();
        }
        return $contacts;
    }


    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function add(ContactEntity &$contact): ContactEntity
    {
        $model = new ContactsModel();
        $model->id_person = $contact->getIdPerson();
        $model->value = $contact->getValue();
        $model->type = $contact->getType();
        $model->save();

        $contact->setId($model->id);
        return $contact;
    }
    /**
     * @param ContactEntity $contact
     * @return ContactEntity
     */
    public function update(ContactEntity &$contact): ContactEntity
    {
        /** @var ContactsModel */
        $model = ContactsModel::query()->find($contact->getId());
        $model->id_person = $contact->getIdPerson();
        $model->value = $contact->getValue();
        $model->type = $contact->getType();
        $model->save();

        return $contact;
    }
    /**
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        /** @var ContactsModel */
        $model = ContactsModel::query()->find($id);
        if (!$model) {
            return false;
        }
        $res = $model->delete();
        return $res == true;
    }
}
