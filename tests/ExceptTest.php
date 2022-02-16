<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\except;

class ExceptTest extends TestCase
{
    public function testExcept()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([1, 1 => 'b', 3 => 'd'], except($elements, 2));
    }

    public function testExceptKeyNotExists()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([1, 'b', 'c', 'd'], except($elements, 'b'));
    }

    public function testExceptMany()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([2 => 'c', 3 => 'd'], except($elements, 0, 1));
    }

    public function testExceptManyCase2()
    {
        $elements = [1, 'b', 'c', 'd'];
        $this->assertEquals([1, 'b'], except($elements, 2, 3));
    }
}
