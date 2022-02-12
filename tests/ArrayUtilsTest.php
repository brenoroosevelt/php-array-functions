<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\all;

class ArrayUtilsTest extends TestCase
{
    public function test_all()
    {
        $r = all([1,2,], 'empty');
        $this->assertTrue($r);
    }
}
