<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\flatten;

class FlattenTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'case_1' => [
                ['a', 'b', 'c'],
                null,
                ['a', 'b', 'c'],
            ],
            'case_2' => [
                ['a', ['b', ['c'], 'd']],
                null,
                ['a', 'b', 'c', 'd'],
            ],
            'case_3' => [
                ['x' => 'a', 'y' => 'b', 'z' => 'c'],
                null,
                ['a', 'b', 'c']
            ],
            'case_4' => [
                ['x' => 'a', 'y' => ['b', ['z' => 'c'], 'd']],
                '.',
                ['x' => 'a', 'y.0' => 'b', 'y.1.z' => 'c', 'y.2' => 'd']
            ],
            'case_5' => [
                ['x' => 'a', 'y' => ['b', ['z' => 'c'], 'd']],
                '\\',
                ['x' => 'a', 'y\\0' => 'b', 'y\\1\\z' => 'c', 'y\\2' => 'd']
            ],
            'case_6' => [
                [
                    [
                        'Post' => ['id' => '1', 'author_id' => '1', 'title' => '1st post'],
                        'Author' => ['id' => '1', 'user' => 'spencer', 'password' => 'pwd'],
                    ],
                    [
                        'Post' => ['id' => '2', 'author_id' => '3', 'title' => '2nd Post', 'body' => '2nd post body'],
                        'Author' => ['id' => '3', 'user' => 'mary', 'password' => null],
                    ],
                ],
                '.',
                [
                    '0.Post.id' => '1',
                    '0.Post.author_id' => '1',
                    '0.Post.title' => '1st post',
                    '0.Author.id' => '1',
                    '0.Author.user' => 'spencer',
                    '0.Author.password' => 'pwd',
                    '1.Post.id' => '2',
                    '1.Post.author_id' => '3',
                    '1.Post.title' => '2nd Post',
                    '1.Post.body' => '2nd post body',
                    '1.Author.id' => '3',
                    '1.Author.user' => 'mary',
                    '1.Author.password' => null,
                ]
            ],
            'case_7' => [
                [],
                null,
                []
            ],
            'case_8' => [
                [],
                '.',
                []
            ],
        ];
    }

    /**
     * @param array $items
     * @param string|null $separator
     * @param array $expected
     * @return void
     * @dataProvider dataProvider
     */
    public function testFlatten(array $items, ?string $separator, array $expected): void
    {
        $result = flatten($items, $separator);
        $this->assertEquals($expected, $result);
    }
}
