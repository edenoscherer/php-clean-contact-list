<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\UseCase;

use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Input as AddPersonInput;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\AddPersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\UpdatePersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\InputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\UpdatePerson\Output;
use Edeno\TestPhpCleanPersonList\Persons\Infra\Repositories\InMemoryPersonRepository;

final class UpdatePersonUseCaseTest extends BaseTestCase
{
    protected PersonRepositoryInterface $repository;
    protected UpdatePersonUseCase $useCase;
    protected int $idPerson;
    protected function setUp(): void
    {
        $this->repository = new InMemoryPersonRepository();
        $this->useCase = new UpdatePersonUseCase($this->repository);

        $contactInput = new InputContact('email', 'edeno');
        $input = new AddPersonInput('Edeno Luiz Scherer', [$contactInput]);
        $res = (new AddPersonUseCase($this->repository))->handle($input);
        $this->idPerson = $res->getId();
        var_dump($res->getId());
    }

    public function testHandle()
    {

        $input = new Input($this->idPerson, 'Edeno Luiz Scherer', []);
        $res = $this->useCase->handle($input);
        $this->assertInstanceOf(Output::class, $res);
        $this->assertEquals('Edeno Luiz Scherer', $res->getName());
        $this->assertEquals($input->getId(), $res->getId());
        $this->assertIsArray($res->getContacts());
        $this->assertEmpty($res->getContacts());

        $contactInput = new InputContact('email', 'edeno');
        $input = new Input($this->idPerson, 'Edeno Luiz Scherer', [$contactInput]);
        $res = $this->useCase->handle($input);

        $this->assertInstanceOf(Output::class, $res);
        $this->assertEquals('Edeno Luiz Scherer', $res->getName());
        $this->assertEquals($input->getId(), $res->getId());
        $this->assertIsArray($res->getContacts());
        $this->assertCount(1, $res->getContacts());

        return $res;
    }

    /**
     * @depends testHandle
     */
    public function testJsonSerialize(Output $output)
    {
        $res = $output->jsonSerialize();
        $this->assertIsArray($res);
        $this->assertEquals($output->getId(), $res['id']);
        $this->assertEquals($output->getName(), $res['name']);
        $this->assertCount(1, $res['contacts']);
        $this->assertEquals($output->getContacts()[0]->jsonSerialize(), $res['contacts'][0]);
    }
}
