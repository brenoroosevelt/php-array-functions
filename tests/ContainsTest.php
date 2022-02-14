<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\contains;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    public function containsProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                ['b'],
                true,
            ],
            'case_2' => [
                (function (): \Generator {
                    yield 'a';
                    yield 'b';
                    yield 'c';
                })(),
                ['b'],
                true,
            ],
            'case_3' => [
                ['a', 'b', 'c'],
                [],
                true,
            ],
            'case_3_1' => [
                [],
                [],
                true,
            ],
            'case_3_2' => [
                [],
                [0],
                false,
            ],
            'case_4' => [
                ['a', 'b', 'c'],
                [0],
                false,
            ],
            'case_5' => [
                ['a', 'b', 'c'],
                ['a', 'b', 'c'],
                true,
            ],
            'case_6' => [
                ['a', 'b', 'c'],
                ['a', 'b', 'c', 'd'],
                false,
            ],
            'case_7' => [
                [0, false],
                [''],
                false,
            ],
            'case_8' => [
                [0, 1, 1, 1, 2, 2],
                [1, 1, 0],
                true,
            ],
            'case_9' => [
                ['a' => 0, 'b' => 1, 1, 1, 2, 2],
                ['a'],
                false,
            ],
        ];
    }

    /**
     * @param iterable $items
     * @param array $elements
     * @param bool $expected
     * @return void
     * @dataProvider containsProvider
     */
    public function testContainsAll(iterable $items, array $elements, bool $expected): void
    {
        $actual = contains($items, ...$elements);
        $this->assertEquals($expected, $actual);
    }
}
