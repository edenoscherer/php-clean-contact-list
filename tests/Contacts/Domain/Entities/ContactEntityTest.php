<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList\Contacts\Domain\Entities;

use Edeno\TestPhpCleanContactList\BaseTestCase;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use stdClass;

final class ContactEntityTest extends BaseTestCase
{
    public function testNewContact()
    {
        $params = new stdClass();
        $params->type = 'email';
        $params->value = 'edenoscherer@gmail.com';
        $res = new ContactEntity($params);

        $this->assertInstanceOf(ContactEntity::class, $res);
        $this->assertEquals($params->type, $res->getType());
        $this->assertEquals($params->value, $res->getValue());
        $this->assertEmpty($res->getId());
        $this->assertEmpty($res->getIdPerson());

        $params->id = 155;
        $params->idPerson = 155;
        $res = new ContactEntity($params);

        $this->assertInstanceOf(ContactEntity::class, $res);
        $this->assertEquals($params->type, $res->getType());
        $this->assertEquals($params->value, $res->getValue());
        $this->assertEquals($params->id, $res->getId());
        $this->assertEquals($params->idPerson, $res->getIdPerson());
    }

    public function testJsonSerialize()
    {
        $params = new stdClass();
        $params->type = 'email';
        $params->value = 'edenoscherer@gmail.com';
        $res = (new ContactEntity($params))->jsonSerialize();
        $this->assertIsArray($res);
        $this->assertEquals($params->type, $res['type']);
        $this->assertEquals($params->value, $res['value']);
        $this->assertEmpty($res['id']);
        $this->assertEmpty($res['idPerson']);


        $params->id = 155;
        $params->idPerson = 155;
        $res = (new ContactEntity($params))->jsonSerialize();
        $this->assertEquals($params->type, $res['type']);
        $this->assertEquals($params->value, $res['value']);
        $this->assertEquals($params->id, $res['id']);
        $this->assertEquals($params->idPerson, $res['idPerson']);
    }
}
