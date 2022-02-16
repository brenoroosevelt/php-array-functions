<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\some;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;
use const BrenoRoosevelt\CALLBACK_USE_VALUE;

class SomeTest extends TestCase
{
    public function someProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'], // collection
                fn($el) => false, // callback
                CALLBACK_USE_VALUE, // mode
                false, // expected
            ],
            'case_2' => [
                ['a', 'b', 'c'],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_3' => [
                [],
                fn($el) => false,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_3_1' => [
                [],
                fn($el) => true,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_4' => [
                [1, 2, 3, 4],
                fn($el) => $el === 2,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_5' => [
                [1, 2, 3, 4],
                fn($el) => $el === 0,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_6' => [
                [1, 2, 3, 4],
                fn($key) => is_string($key),
                CALLBACK_USE_KEY,
                false,
            ],
            'case_6_1' => [
                [1, 2, 3, 4, 'a' => 5],
                fn($key) => is_string($key),
                CALLBACK_USE_KEY,
                true,
            ],
            'case_7' => [
                ['a' => 1, 'b' => 2, 'c' => 3, 4],
                fn($v, $key) => is_integer($key) && is_integer($v),
                CALLBACK_USE_BOTH,
                true,
            ]
        ];
    }

    /**
     * @param iterable $items
     * @param callable $callback
     * @param int $mode
     * @param bool $expected
     * @return void
     * @dataProvider someProvider
     */
    public function testSome(iterable $items, callable $callback, int $mode, bool $expected): void
    {
        $actual = some($items, $callback, $mode);
        $this->assertEquals($expected, $actual);
    }
}
