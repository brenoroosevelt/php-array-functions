<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\add;
use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\set;

class SetTest extends TestCase
{
    public function addProvider(): array
    {
        return [
            'case_1' => [
                ['a' => 1, 'b' => 2, 'c'=> 3],
                1,
                'b',
                ['a' => 1, 'b' => 1, 'c'=> 3]
            ],
            'case_2' => [
                ['a' => 1, 'b' => 2, 'c'=> 3],
                1,
                null,
                ['a' => 1, 'b' => 2, 'c'=> 3, 1]
            ]
        ];
    }

    /**
     * @param array $items
     * @param $element
     * @param $key
     * @param array $expected
     * @return void
     * @dataProvider addProvider
     */
    public function testAdd(array $items, $element, $key, array $expected): void
    {
        set($items, $element, $key);
        $this->assertEquals($expected, $items);
    }
}
