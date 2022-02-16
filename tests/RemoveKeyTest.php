<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\remove_key;

class RemoveKeyTest extends TestCase
{
    public function testRemoveOneKey()
    {
        $elements = [1, 'a' => 2, 'b' => 3];
        $this->assertEquals(1, remove_key($elements, 0));
        $this->assertEquals(['a' => 2, 'b' => 3], $elements);
    }

    public function testRemoveManyKeys()
    {
        $elements = [1, 'a' => 2, 'b' => 3];
        $this->assertEquals(2, remove_key($elements, 0, 'a'));
        $this->assertEquals(['b' => 3], $elements);
    }

    public function testDontRemoveKey()
    {
        $elements = [1, 'a' => 2, 'b' => 3];
        $this->assertEquals(0, remove_key($elements, 1));
        $this->assertEquals([1, 'a' => 2, 'b' => 3], $elements);
    }
}
