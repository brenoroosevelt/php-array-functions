<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\contains;
use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\remove;

class RemoveTest extends TestCase
{
    public function removeProvider(): array
    {
        return [
            'case_1' => [
                [1, 2, 3],
                [1],
                1,
                [1 => 2, 2 => 3]
            ],
            'case_2' => [
                [1, 2, 3],
                [1, 2, 2],
                2,
                [2 => 3]
            ],
            'case_3' => [
                [1, 2, 3],
                ['1'],
                0,
                [1, 2, 3]
            ],
            'case_4' => [
                [null, false, 0],
                [0],
                1,
                [null, false],
            ],
            'case_5' => [
                [],
                [0],
                0,
                [],
            ],
            'case_6' => [
                [[1, 2, 3]],
                [1],
                0,
                [[1, 2, 3]],
            ]
        ];
    }

    /**
     * @param array $items
     * @param array $elements
     * @param int $count
     * @param array $expected
     * @return void
     * @dataProvider removeProvider
     */
    public function testContainsAll(array $items, array $elements, int $count, array $expected): void
    {
        $removed = remove($items, ...$elements);
        $this->assertEquals($count, $removed);
        $this->assertEquals($expected, $items);
    }
}
