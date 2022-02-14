<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\contains_any;
use PHPUnit\Framework\TestCase;

class ContainsAnyTest extends TestCase
{
    public function containsAnyProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                ['b'],
                true,
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
                true,
            ],
            'case_3' => [
                ['a', 'b', 'c'],
                [],
                true,
                true,
            ],
            'case_3_1' => [
                [],
                [],
                true,
                true,
            ],
            'case_3_2' => [
                [],
                [0],
                true,
                false,
            ],
            'case_4' => [
                ['a', 'b', 'c'],
                [0],
                true,
                false,
            ],
            'case_5' => [
                ['a', 'b', 'c'],
                ['a', 'b', 'c'],
                true,
                true,
            ],
            'case_6' => [
                ['a', 'b', 'c'],
                ['a', 'b', 'c', 'd'],
                true,
                true,
            ],
            'case_7' => [
                [0, false],
                [''],
                false,
                true,
            ],
            'case_8' => [
                [0, 1, 1, 1, 2, 2],
                [1, 1, 0, 15],
                true,
                true,
            ],
        ];
    }

    /**
     * @param iterable $items
     * @param array $elements
     * @param bool $strict
     * @param bool $expected
     * @return void
     * @dataProvider containsAnyProvider
     */
    public function testContainsAny(iterable $items, array $elements, bool $strict, bool $expected): void
    {
        $actual = contains_any($items, $elements, $strict);
        $this->assertEquals($expected, $actual);
    }
}
