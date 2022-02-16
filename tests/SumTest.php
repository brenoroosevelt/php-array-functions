<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\sum;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;

class SumTest extends TestCase
{
    public function testSum()
    {
        $elements = [1, 2, 3];
        $this->assertEquals(15, sum($elements, fn($v) => 5));
    }

    public function testSumValues()
    {
        $elements = [1, 2, 3];
        $this->assertEquals(6, sum($elements, fn($v) => $v));
    }

    public function testSumKeys()
    {
        $elements = [1, 2, 3];
        $this->assertEquals(3, sum($elements, fn($k) => $k, CALLBACK_USE_KEY));
    }

    public function testSumBoth()
    {
        $elements = [1, 2, 3];
        $this->assertEquals(9, sum($elements, fn($v, $k) => $k + $v, CALLBACK_USE_BOTH));
    }
}
