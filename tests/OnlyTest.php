<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\only;

class OnlyTest extends TestCase
{
    public function testOnly()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([1, 'b'], only($elements, 0, 1));
    }

    public function testOnlyPreserveKeys()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([2 => 'c'], only($elements, 2));
    }

    public function testOnlyKeyNotExists()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([], only($elements, 'b'));
    }

    public function testOnlyKeyPreserveValues()
    {
        $elements = [1, 'c' => [[[2]]]];
        $this->assertEquals(['c' => [[[2]]]], only($elements, 'c'));
    }
}
