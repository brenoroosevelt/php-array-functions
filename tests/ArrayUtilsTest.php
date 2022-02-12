<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use function BrenoRoosevelt\all;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    public function test_all()
    {
        $r = all([1,2,], 'empty');
        $this->assertTrue($r);
    }
}
