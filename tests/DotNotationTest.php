<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\get_path;
use function BrenoRoosevelt\has_path;
use function BrenoRoosevelt\set_path;
use function BrenoRoosevelt\unset_path;

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

    public function hasPathProvider(): array
    {
        $abcdNull = ['a' => ['b' => ['c' => ['d' => null]]]];
        return [
            'case_1' => [
                [],
                '',
                false
            ],
            'case_2' => [
                [1, 2, 3],
                '0',
                true
            ],
            'case_3' => [
                [1, 2, 3],
                '2',
                true
            ],
            'case_4' => [
                [[[[1, 2, 3]]]],
                '0.0.0.2',
                true
            ],
            'case_5' => [
                [[[[1, 2, 3]]]],
                '0.0.0.3',
                false
            ],
            'case_6' => [
                [[[[1, 2, 3]]]],
                '0.0',
                true
            ],
            'case_7' => [
                [[[0, 1 => [1, 2], [1, 2, 3]]]],
                '0.0.1',
                true
            ],
            'case_8' => [
                $abcdNull,
                '0',
                false
            ],
            'case_9' => [
                $abcdNull,
                'a',
                true
            ],
            'case_10' => [
                $abcdNull,
                'a.b',
                true
            ],
            'case_11' => [
                $abcdNull,
                'a.b.c',
                true
            ],
            'case_12' => [
                $abcdNull,
                'a.b.c.d',
                true
            ],
            'case_13' => [
                ['a' => null],
                'a',
                true
            ],
            'case_14' => [
                ['a' => ['b' => null]],
                'a.b',
                true
            ],
            'case_15' => [
                ['a' => ['b' => false]],
                'a.b',
                true
            ],
            'case_16' => [
                ['a' => ['b' => 0]],
                'a.b',
                true
            ],
        ];
    }

    /**
     * @param array $items
     * @param string $path
     * @param $expected
     * @return void
     * @dataProvider hasPathProvider
     */
    public function testHasPath(array $items, string $path, $expected)
    {
        $actual = has_path($items, $path);
        $this->assertEquals($expected, $actual);
    }

    public function unsetPathProvider(): array
    {
        return [
            'case_1' => [
                [],
                '',
                []
            ],
            'case_2' => [
                [1, 2, 3],
                '3',
                [1, 2, 3]
            ],
            'case_3' => [
                [1, 2, 3],
                '2',
                [1, 2]
            ],
            'case_4' => [
                [1, 2, 3],
                '0',
                [1 => 2, 2 => 3]
            ],
            'case_5' => [
                [[[[1, 2, 3]]]],
                '0.0.0.1',
                [[[[1, 2 => 3]]]],
            ],
            'case_6' => [
                [['x' => [[1, 2 => 3]]], 9],
                '0.x',
                [[], 1 => 9],
            ],
        ];
    }

    /**
     * @param array $items
     * @param string $path
     * @param $expected
     * @return void
     * @dataProvider unsetPathProvider
     */
    public function testUnsetPath(array $items, string $path, $expected)
    {
        unset_path($items, $path);
        $this->assertEquals($expected, $items);
    }
}
