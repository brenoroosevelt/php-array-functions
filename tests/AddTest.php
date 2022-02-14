<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\add;
use PHPUnit\Framework\TestCase;

class AddTest extends TestCase
{
    public function addProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                ['d'],
                ['a', 'b', 'c', 'd'],
            ],
            'case_2' => [
                ['a', 'b', 'c'],
                ['d', 'd'],
                ['a', 'b', 'c', 'd'],
            ],
            'case_3' => [
                ['a', 'b', 'c'],
                ['d', 'd', 'a', 'c'],
                ['a', 'b', 'c', 'd'],
            ],
            'case_4' => [
                ['a', 'b', 'c'],
                [],
                ['a', 'b', 'c'],
            ],
            'case_5' => [
                ['x' => 'a', 'y' => 'b', 'c'],
                ['x', 'y', 'a', 'b', 'b'],
                ['x' => 'a', 'y' => 'b', 'c', 'x', 'y'],
            ],
        ];
    }

    /**
     * @param array $items
     * @param array $elements
     * @param array $expected
     * @return void
     * @dataProvider addProvider
     */
    public function testAdd(array $items, array $elements, array $expected): void
    {
        add($items, ...$elements);
        $this->assertEquals($expected, $items);
    }
}
