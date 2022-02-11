<?php

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\at_least;
use function BrenoRoosevelt\at_most;
use function BrenoRoosevelt\some;

class ArrayUtilsTest extends TestCase
{
    public function test_all()
    {
        $result = at_most(['', 1], 1, fn($v) => is_numeric($v));
        $this->assertTrue($result);
    }
}
