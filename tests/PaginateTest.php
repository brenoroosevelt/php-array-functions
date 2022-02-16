<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\paginate;

class PaginateTest extends TestCase
{
    public function testPaginate()
    {
        $elements = range(0, 100);
        $result = paginate($elements, 1, 5);
        $this->assertEquals([0, 1, 2, 3, 4], $result);
    }

    public function testPaginateCase2()
    {
        $elements = range(0, 2);
        $result = paginate($elements, 1, 5);
        $this->assertEquals([0, 1, 2], $result);
    }

    public function testPaginateCase3()
    {
        $elements = range(0, 8);
        $result = paginate($elements, 2, 5);
        $this->assertEquals([5 => 5, 6 => 6, 7 => 7, 8 => 8], $result);
    }

    public function testPaginateCasePreserveKey()
    {
        $elements = range(0, 8);
        $result = paginate($elements, 2, 5, false);
        $this->assertEquals([5, 6, 7, 8], $result);
    }

    public function testPaginateCaseInvalidPage()
    {
        $elements = range(0, 8);
        $result = paginate($elements, 3, 5);
        $this->assertEquals([], $result);
    }

    public function testPaginateCaseEmpty()
    {
        $elements = [];
        $result = paginate($elements, 3, 5);
        $this->assertEquals([], $result);
    }

    public function testPaginateNegativeOffset()
    {
        $elements = range(0, 100);
        $result = paginate($elements, 3, -2);
        $this->assertEquals([], $result);
    }

    public function testPaginateNegativePage()
    {
        $elements = range(0, 100);
        $result = paginate($elements, -1, 5);
        $this->assertEquals([], $result);
    }

    public function testPaginatePageZero()
    {
        $elements = range(0, 100);
        $result = paginate($elements, 0, 5);
        $this->assertEquals([], $result);
    }
}
