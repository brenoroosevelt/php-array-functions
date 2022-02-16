<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\map;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;

class MapTest extends TestCase
{
    public function testMapValue()
    {
        $elements = [1, 2, 3];
        $this->assertEquals([2, 4, 6], map($elements, fn($v) => $v * 2));
    }

    public function testMapKey()
    {
        $elements = [1, 2, 3];
        $this->assertEquals([0, 2, 4], map($elements, fn($k) => $k * 2, CALLBACK_USE_KEY));
    }

    public function testMapBoth()
    {
        $elements = [1, 2, 3];
        $this->assertEquals([1, 3, 5], map($elements, fn($v, $k) => $v + $k, CALLBACK_USE_BOTH));
    }
}
