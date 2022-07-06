<?php

use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\Input;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\InputContact;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\AddPerson\AddPersonUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople\ListPeopleUseCase;
use Edeno\PhpCleanContactList\Contacts\Domain\UseCase\ListPeople\Output;
use Edeno\PhpCleanContactList\Contacts\Domain\Repositories\PersonRepositoryInterface;
use Edeno\TestPhpCleanPersonList\Persons\Infra\Repositories\InMemoryPersonRepository;

final class ListPeopleUseCaseTest extends BaseTestCase
{
    protected PersonRepositoryInterface $repository;
    protected ListPeopleUseCase $useCase;
    protected int $idPerson;

    protected function setUp(): void
    {
        $this->repository = new InMemoryPersonRepository();

        $contactInput = new InputContact('email', 'edeno');
        $input = new Input('Edeno Luiz Scherer', [$contactInput]);
        $res = (new AddPersonUseCase($this->repository))->handle($input);
        $this->idPerson = $res->getId();

        $this->useCase = new ListPeopleUseCase($this->repository);
    }

    public function testHandle()
    {
        $res = $this->useCase->handle();
        $this->assertIsArray($res);
        $this->assertArrayHasKey(0, $res);
        $out = $res[0];
        $this->assertInstanceOf(Output::class, $out);
        $this->assertEquals('Edeno Luiz Scherer', $out->getName());
        $this->assertEquals($out->getId(), $out->getId());
        $this->assertIsArray($out->getContacts());
        $this->assertCount(1, $out->getContacts());

        return $out;
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
