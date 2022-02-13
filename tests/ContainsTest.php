<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\contains;
use function BrenoRoosevelt\index_of;

class ContainsTest extends TestCase
{
    public function containsProvider(): array
    {
        $anObject = new \stdClass();
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                'b',
                true,
                true
            ],
            'case_2' => [
                (function(): \Generator {
                    yield 'a';
                    yield 'b';
                    yield 'c';
                })(),
                'b',
                true,
                true
            ],
            'case_2_1' => [
                (function(): \Generator {
                    yield 'x' => 'a';
                    yield 'y' => 'b';
                    yield 'z' => 'c';
                })(),
                'b',
                true,
                true
            ],
            'case_2_3' => [
                (function(): \Generator {
                    yield 'x' => 'a';
                    yield 'y' => 'b';
                    yield 'z' => 'c';
                })(),
                'x',
                true,
                false
            ],
            'case_3' => [
                new \ArrayObject(['a', 'b', 'c']),
                'b',
                true,
                true
            ],
            'case_3_1' => [
                new \ArrayObject(['a', 'b', 'c']),
                0,
                true,
                false
            ],
            'case_4' => [
                [1, 2, 3, 4],
                '2',
                false,
                true
            ],
            'case_4_1' => [
                new \ArrayObject([1, 2, 3, 4]),
                '2',
                false,
                true
            ],
            'case_5' => [
                [],
                0,
                true,
                false
            ],
            'case_5_1' => [
                [],
                0,
                false,
                false
            ],
            'case_5_2' => [
                new \ArrayObject([]),
                null,
                false,
                false
            ],
            'case_6' => [
                [],
                0,
                true,
                false
            ],
            'case_7' => [
                [1, 2, $anObject, 3],
                $anObject,
                true,
                true
            ],
            'case_8' => [
                ['a' => 0, 'b' => null, 'c' => false],
                null,
                false,
                true
            ],
            'case_8_1' => [
                ['a' => 0, 'b' => null, 'c' => false],
                null,
                true,
                true
            ],
            'case_8_2' => [
                ['b' => null, 'c' => false],
                '',
                false,
                true
            ],
        ];
    }

    /**
     * @param iterable $items
     * @param $element
     * @param bool $strict
     * @param bool $expected
     * @return void
     * @dataProvider containsProvider
     */
    public function testContains(iterable $items, $element, bool $strict, bool $expected): void
    {
        $actual = contains($items, $element, $strict);
        $this->assertEquals($expected, $actual);
    }
}
