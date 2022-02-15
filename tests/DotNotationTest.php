<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\get_path;
use function BrenoRoosevelt\set_path;

class DotNotationTest extends TestCase
{
    public function setPathProvider(): array
    {
        return [
            'case_1' => [
                [],
                'a',
                1,
                '.',
                ['a' => 1]
            ],
            'case_2' => [
                ['a' => [0, 1]],
                'a.b',
                9,
                '.',
                ['a' => [0, 1, 'b' => 9]]
            ],
            'case_3' => [
                ['a' => [0, 1]],
                'a.b.c',
                9,
                '.',
                ['a' => [0, 1, 'b' => ['c' => 9]]]
            ],
            'case_4' => [
                ['a' => [0, 1]],
                'a.0',
                9,
                '.',
                ['a' => [9, 1]]
            ],
            'case_5' => [
                ['a' => [0, 1, 'b' => ['c' => 1]]],
                'a.b.c.d',
                9,
                '.',
                ['a' => [0, 1, 'b' => ['c' => ['d' => 9]]]],
            ]
        ];
    }

    /**
     * @param array $haystack
     * @param string $path
     * @param $value
     * @param string $separator
     * @param array $expected
     * @return void
     * @dataProvider setPathProvider
     */
    public function testSetPath(array $haystack, string $path, $value, string $separator, array $expected): void
    {
        set_path($haystack, $path, $value, $separator);
        $this->assertEquals($expected, $haystack);
    }

    public function getPathProvider(): array
    {
        return [
            'case_1' => [
                [],
                '',
                1,
                1
            ],
            'case_2' => [
                [4],
                '0',
                null,
                4
            ],
            'case_3' => [
                [[[[4, 5]]]],
                '0.0.0.1',
                null,
                5
            ],
            'case_4' => [
                [['a' => ['b' => ['c']]]],
                '0.a.b',
                null,
                ['c']
            ],
            'case_5' => [
                [['a' => ['b' => ['c']]]],
                '0.a.b.c',
                null,
                null
            ],
            'case_6' => [
                [['a' => ['b' => ['c', 'd' => 9, 3]]], 9, 8, 7],
                '0.a.b.d',
                null,
                9
            ],
            'case_7' => [
                ['a' => ['b' => []]],
                'a.b.c.d',
                ['c' => ['d' => 7]],
                ['c' => ['d' => 7]]
            ]
        ];
    }

    /**
     * @param array $items
     * @param string $path
     * @param $default
     * @param $expected
     * @return void
     * @dataProvider getPathProvider
     */
    public function testGetPath(array $items, string $path, $default, $expected): void
    {
        $actual = get_path($items, $path, $default);
        $this->assertEquals($expected, $actual);
    }
}
