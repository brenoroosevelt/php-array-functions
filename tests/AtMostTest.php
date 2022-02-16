<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\at_most;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;
use const BrenoRoosevelt\CALLBACK_USE_VALUE;

class AtMostTest extends TestCase
{
    public function atMostProvider(): array
    {
        return [
            'case_1' => [
                0, // n
                ['a', 'b', 'c'], // collection
                fn($el) => false, // callback
                CALLBACK_USE_VALUE, // mode
                true, // expected
            ],
            'case_2' => [
                4,
                ['a', 'b', 'c'],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_3' => [
                1,
                [],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_3_1' => [
                0,
                [],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_3_2' => [
                -1,
                [],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_4' => [
                1,
                [1, 2, 3, 4],
                fn($el) => $el % 2 === 0,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_5' => [
                4,
                [1, 2, 3, 4],
                fn($el) => $el % 2 === 0,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_6' => [
                3,
                [1, 2, 3, 4],
                fn($key) => is_integer($key),
                CALLBACK_USE_KEY,
                false,
            ],
            'case_7' => [
                0,
                ['a' => 1, 'b' => 2, 'c' => 3, 4],
                fn($v, $key) => is_integer($key) && is_integer($v),
                CALLBACK_USE_BOTH,
                false,
            ]
        ];
    }

    /**
     * @param int $n
     * @param iterable $items
     * @param callable $callback
     * @param int $mode
     * @param bool $expected
     * @return void
     * @dataProvider atMostProvider
     */
    public function testAtMost(int $n, iterable $items, callable $callback, int $mode, bool $expected): void
    {
        $actual = at_most($n, $items, $callback, $mode);
        $this->assertEquals($expected, $actual);
    }
}
