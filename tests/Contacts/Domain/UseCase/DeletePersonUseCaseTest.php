<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\UseCase;

use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\InputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\AddPersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\DeletePerson\DeletePersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\TestPhpCleanPersonList\Persons\Infra\Repositories\InMemoryPersonRepository;

final class DeletePersonUseCaseTest extends BaseTestCase
{
    protected PersonRepositoryInterface $repository;
    protected DeletePersonUseCase $useCase;
    protected int $idPerson;

    protected function setUp(): void
    {
        $this->repository = new InMemoryPersonRepository();

        $contactInput = new InputContact('email', 'edeno');
        $input = new Input('Edeno Luiz Scherer', [$contactInput]);
        $res = (new AddPersonUseCase($this->repository))->handle($input);
        $this->idPerson = $res->getId();

        $this->useCase = new DeletePersonUseCase($this->repository);
    }

    public function testHandle()
    {
        $res = $this->useCase->handle(21);
        $this->assertFalse($res);

        $res = $this->useCase->handle($this->idPerson);
        $this->assertTrue($res);
    }
}
