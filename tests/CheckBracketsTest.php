<?php

declare(strict_types=1);

namespace Edeno\TestPhpCleanContactList;

use Edeno\PhpCleanContactList\CheckBrackets;
use Edeno\TestPhpCleanContactList\BaseTestCase;

final class CheckBracketsTest extends BaseTestCase
{

    /**
     * @dataProvider checkBracketsProvider
     */
    function testCheckBrackets(string $value, bool $expected)
    {
        $res = CheckBrackets::test($value);
        $this->assertEquals($expected, $res);
    }

    public function checkBracketsProvider()
    {
        return [
            ['(){}[]', true],
            ['[{()}](){}', true],
            ['[]{()', false],
            ['[{)]', false],
            ['[({)}]', false],
            ['([)]', false],
            ['(()[]', false],
            [')(()[]', false],
        ];
    }
}
