<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\accept;
use function BrenoRoosevelt\reject;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;

class RejectTest extends TestCase
{
    public function testReject()
    {
        $elements = [ 1, 'b', 'c', 'd'];
        $this->assertEquals([1], reject($elements, 'is_string'));
    }

    public function testRejectKey()
    {
        $elements = [1 => 1, 'b' => 2, 'c'];
        $this->assertEquals(['b' => 2], reject($elements, 'is_integer', CALLBACK_USE_KEY));
    }

    public function testRejectBoth()
    {
        $elements = [1, 2, 3];
        $this->assertEquals([1, 2 => 3], reject($elements, fn($v, $k) => $v + $k === 3, CALLBACK_USE_BOTH));
    }
}
