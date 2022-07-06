<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\UseCase\AddPerson;

use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\AddPersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\InputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Output;
use Edeno\TestPhpCleanPersonList\Persons\Infra\Repositories\InMemoryPersonRepository;

final class AddPersonUseCaseTest extends BaseTestCase
{
    protected PersonRepositoryInterface $repository;
    protected AddPersonUseCase $useCase;
    protected function setUp(): void
    {
        $this->repository = new InMemoryPersonRepository();
        $this->useCase = new AddPersonUseCase($this->repository);
    }
    public function testHandle()
    {
        $input = new Input('Edeno Luiz Scherer', []);
        $res = $this->useCase->handle($input);
        $this->assertInstanceOf(Output::class, $res);
        $this->assertEquals('Edeno Luiz Scherer', $res->getName());
        $this->assertGreaterThan(1, $res->getId());
        $this->assertIsArray($res->getContacts());
        $this->assertEmpty($res->getContacts());

        $contactInput = new InputContact('email', 'edeno');
        $input = new Input('Edeno Luiz Scherer', [$contactInput]);
        $res = $this->useCase->handle($input);

        $this->assertInstanceOf(Output::class, $res);
        $this->assertEquals('Edeno Luiz Scherer', $res->getName());
        $this->assertGreaterThan(1, $res->getId());
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
        $this->assertGreaterThan(1, $res['id']);
        $this->assertEquals($output->getId(), $res['id']);
        $this->assertEquals($output->getName(), $res['name']);
        $this->assertCount(1, $res['contacts']);
        $this->assertEquals($output->getContacts()[0]->jsonSerialize(), $res['contacts'][0]);
    }
}
