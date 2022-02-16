<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\pull;

class PullTest extends TestCase
{
    public function testPullKey()
    {
        $elements = [1, 'a' => 2, 'b' => 3];
        $this->assertEquals(1, pull($elements, 0));
        $this->assertEquals(['a' => 2, 'b' => 3], $elements);
    }

    public function testPullRetunsDefault()
    {
        $elements = [1, 'a' => 2, 'b' => 3];
        $this->assertEquals('k', pull($elements, 1, 'k'));
        $this->assertEquals([1, 'a' => 2, 'b' => 3], $elements);
    }
}
