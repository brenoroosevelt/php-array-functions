<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\first;
use function BrenoRoosevelt\pull;

class FirstTest extends TestCase
{
    public function testGetFirst()
    {
        $result = first([1, 'a' => 2, 'b' => 3], fn($e) => $e % 2 === 0);
        $this->assertEquals(2, $result);
    }

    public function testFirstRetunsDefault()
    {
        $result = first([1, 'a' => 2, 'b' => 3], fn($e) => $e === 0, 'default');
        $this->assertEquals('default', $result);
    }
}
