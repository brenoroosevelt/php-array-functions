<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
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
                ['a' => [0, 1, 'b' => ['c' => 9]]],
                'a.b.c.2',
                9,
                '.',
                ['a' => [0, 1, 'b' => ['c' => [2 => 9]]]],
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
}
