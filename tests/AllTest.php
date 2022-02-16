<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\all;
use PHPUnit\Framework\TestCase;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;
use const BrenoRoosevelt\CALLBACK_USE_VALUE;

class AllTest extends TestCase
{
    public function allProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'], // collection
                fn($el) => false, // callback
                true, // empty_is_valid
                CALLBACK_USE_VALUE, // mode
                false, // expected
            ],
            'case_2' => [
                ['a', 'b', 'c'],
                fn($el) => true,
                true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_3' => [
                [],
                fn($el) => false,
                true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_4' => [
                [],
                fn($el) => true,
                true,
                CALLBACK_USE_VALUE,
                true,
            ],
            'case_5' => [
                [1, 2, 3],
                fn($el) => $el % 2 === 0,
                true,
                CALLBACK_USE_VALUE,
                false,
            ],
            'case_6' => [
                ['a' => 1, 'b' => 2, 3],
                fn($key) => is_integer($key),
                true,
                CALLBACK_USE_KEY,
                false,
            ],
            'case_7' => [
                ['a' => 'x', 'b' => 'y'],
                fn($el, $key) => is_string($key) && is_string($el),
                true,
                CALLBACK_USE_BOTH,
                true,
            ]
        ];
    }

    /**
     * @param iterable $items
     * @param callable $callback
     * @param bool $emptyIsValid
     * @param int $mode
     * @param bool $expected
     * @return void
     * @dataProvider allProvider
     */
    public function testAdd(iterable $items, callable $callback, bool $emptyIsValid, int $mode, bool $expected): void
    {
        $actual = all($items, $callback, $emptyIsValid, $mode);
        $this->assertEquals($expected, $actual);
    }
}
