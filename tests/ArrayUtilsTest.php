<?php

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\at_most;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    public function test_all()
    {
        $result = at_most(['', 1], 1, fn ($v) => is_numeric($v));
        $this->assertTrue($result);
    }
}
