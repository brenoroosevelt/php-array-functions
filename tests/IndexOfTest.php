<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\index_of;

class IndexOfTest extends TestCase
{
    public function indexOfProvider(): array
    {
        $anObject = new \stdClass();
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                'b',
                true,
                1
            ],
            'case_2' => [
                (function(): \Generator {
                    yield 'a';
                    yield 'b';
                    yield 'c';
                })(),
                'b',
                true,
                1
            ],
            'case_2_1' => [
                (function(): \Generator {
                    yield 'x' => 'a';
                    yield 'y' => 'b';
                    yield 'z' => 'c';
                })(),
                'b',
                true,
                'y'
            ],
            'case_3' => [
                new \ArrayObject(['a', 'b', 'c']),
                'b',
                true,
                1
            ],
            'case_4' => [
                [1, 2, 3, 4],
                '2',
                false,
                1
            ],
            'case_4_1' => [
                new \ArrayObject([1, 2, 3, 4]),
                '2',
                false,
                1
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
                2
            ],
            'case_8' => [
                ['a' => 0, 'b' => null, 'c' => false],
                null,
                false,
                'a'
            ],
            'case_8_1' => [
                ['a' => 0, 'b' => null, 'c' => false],
                null,
                true,
                'b'
            ],
            'case_8_2' => [
                ['a' => 0, 'b' => null, 'c' => false],
                false,
                false,
                'a'
            ],
        ];
    }

    /**
     * @param iterable $items
     * @param $element
     * @param bool $strict
     * @param $expected
     * @return void
     * @dataProvider indexOfProvider
     */
    public function testIndexOf(iterable $items, $element, bool $strict, $expected): void
    {
        $actual = index_of($items, $element, $strict);
        $this->assertEquals($expected, $actual);
    }
}
