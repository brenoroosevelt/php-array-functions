<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\accept;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;

class AcceptTest extends TestCase
{
    public function testAccept()
    {
        $elements = [ 1, 'b', 'c', 'd'];
        $this->assertEquals([ 1 => 'b', 2 => 'c', 3 => 'd'], accept($elements, 'is_string'));
    }

    public function testAcceptKey()
    {
        $elements = [1 => 1, 'b' => 2, 'c'];
        $this->assertEquals(['b' => 2], accept($elements, 'is_string', CALLBACK_USE_KEY));
    }

    public function testAcceptBoth()
    {
        $elements = [1, 2, 3];
        $this->assertEquals([1 => 2], accept($elements, fn($v, $k) => $v + $k === 3, CALLBACK_USE_BOTH));
    }
}
