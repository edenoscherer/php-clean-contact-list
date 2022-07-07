<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Infra;

use Edeno\PhpCleanContactList\Core\Infra\Container\Register;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\ContactRepositoryInterface;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Repositories\PersonRepository;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Repositories\ContactRepository;

final class RegisterContactsContainers
{
    /**
     * @return \Edeno\PhpCleanContactList\Core\Infra\Container\Register[]
     */
    public static function getRepositoriesClass(): array
    {
        $contactRepository = new ContactRepository();
        return [
            new Register(ContactRepositoryInterface::class, $contactRepository),
            new Register(PersonRepositoryInterface::class, new PersonRepository($contactRepository)),
        ];
    }
}
