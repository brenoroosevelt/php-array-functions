<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\has;

class HasTest extends TestCase
{
    public function hasKeyProvider(): array
    {
        return [
            'case_1' => [
                [0, 1, 2], // haystack
                [0], // keys
                true // expected
            ],
            'case_2' => [
                [0, 1, 2], // haystack
                [1, 2], // keys
                true // expected
            ],
            'case_3' => [
                ['a' => 0, 'b' => 1, 2], // haystack
                [0], // keys
                true // expected
            ],
            'case_4' => [
                ['a' => 0, 'b' => 1, 2], // haystack
                [1], // keys
                false // expected
            ],
            'case_5' => [
                ['a' => 0, 'b' => 1, 2], // haystack
                ['a', 'b', 8], // keys
                false // expected
            ],
            'case_6' => [
                [], // haystack
                [0], // keys
                false // expected
            ]
        ];
    }

    /**
     * @param array $haystack
     * @param array $keys
     * @param bool $expected
     * @return void
     * @dataProvider hasKeyProvider
     */
    public function testHasKey(array $haystack, array $keys, bool $expected): void
    {
        $actual = has($haystack, ...$keys);
        $this->assertEquals($expected, $actual);
    }
}
