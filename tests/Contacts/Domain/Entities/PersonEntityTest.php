<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\Entities;

use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;
use stdClass;

final class PersonEntityTest extends BaseTestCase
{
    public function testNewPerson()
    {
        $params = new stdClass();
        $params->name = 'Edeno Luiz Scherer';

        $res = new PersonEntity($params);
        $this->assertInstanceOf(PersonEntity::class, $res);
        $this->assertEquals($params->name, $res->getName());
        $this->assertEmpty($res->getId());
        $this->assertEmpty($res->getContacts());

        $params->id = 123;
        $res = new PersonEntity($params);
        $this->assertInstanceOf(PersonEntity::class, $res);
        $this->assertEquals($params->name, $res->getName());
        $this->assertEquals($params->id, $res->getId());
        $this->assertEmpty($res->getContacts());

        $params->contacts = [];
        $res = new PersonEntity($params);
        $this->assertEmpty($res->getContacts());
        $this->assertIsArray($res->getContacts());

        $params->contacts = [];
        $res = new PersonEntity($params);
        $this->assertEmpty($res->getContacts());
        $this->assertIsArray($res->getContacts());

        $params->contacts = ['asd'];
        $res = new PersonEntity($params);
        $this->assertEmpty($res->getContacts());
        $this->assertIsArray($res->getContacts());

        $contactsValues = new stdClass();
        $contactsValues->type = 'email';
        $contactsValues->value = 'edenoscherer@gmail.com';
        $params->contacts = [$contactsValues];

        $res = new PersonEntity($params);
        $this->assertIsArray($res->getContacts());
        $this->assertCount(1, $res->getContacts());
        $this->assertInstanceOf(ContactEntity::class, $res->getContacts()[0]);

        $params->contacts[] = new ContactEntity($contactsValues);
        $res = new PersonEntity($params);
        $this->assertCount(2, $res->getContacts());
    }

    public function testJsonSerialize()
    {
        $params = new stdClass();
        $params->name = 'Edeno Luiz Scherer';

        $res = (new PersonEntity($params))->jsonSerialize();
        $this->assertIsArray($res);
        $this->assertEquals($params->name, $res['name']);
        $this->assertEmpty($res['id']);
        $this->assertEmpty($res['contacts']);


        $contactsValues = new stdClass();
        $contactsValues->type = 'email';
        $contactsValues->value = 'edenoscherer@gmail.com';
        $params->contacts = [$contactsValues];
        $params->id = 123;

        $res = (new PersonEntity($params))->jsonSerialize();
        $this->assertIsArray($res);
        $this->assertEquals($params->name, $res['name']);
        $this->assertEquals($params->id, $res['id']);
        $this->assertIsArray($res['contacts']);
        $this->assertCount(1, $res['contacts']);
        $this->assertIsArray($res['contacts'][0]);
        $this->assertEquals($contactsValues->type, $res['contacts'][0]['type']);
        $this->assertEquals($contactsValues->value, $res['contacts'][0]['value']);
    }
}
