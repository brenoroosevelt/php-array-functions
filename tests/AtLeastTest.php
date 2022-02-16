<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\at_least;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;
use const BrenoRoosevelt\CALLBACK_USE_VALUE;

class AtLeastTest extends TestCase
{
    public function atLeastProvider(): array
    {
        return [
            'case_1' => [
                0,
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
                false,
            ],
            'case_3' => [
                1,
                [],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                false,
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
                true,
            ],
            'case_4' => [
                2,
                [1, 2, 3, 4],
                fn($el) => $el % 2 === 0,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_5' => [
                2,
                [1, 2, 3, 4],
                fn($el) => $el % 2 === 0,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_6' => [
                4,
                [1, 2, 3, 4],
                fn($key) => is_integer($key),
                CALLBACK_USE_KEY,
                true,
            ],
            'case_7' => [
                1,
                ['a' => 1, 'b' => 2, 'c' => 3, 4],
                fn($v, $key) => is_integer($key) && is_integer($v),
                CALLBACK_USE_BOTH,
                true,
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
     * @dataProvider atLeastProvider
     */
    public function testAtLeast(int $n, iterable $items, callable $callback, int $mode, bool $expected): void
    {
        $actual = at_least($n, $items, $callback, $mode);
        $this->assertEquals($expected, $actual);
    }
}
