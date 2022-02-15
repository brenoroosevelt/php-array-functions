<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\__args;
use const BrenoRoosevelt\CALLBACK_USE_BOTH;
use const BrenoRoosevelt\CALLBACK_USE_KEY;
use const BrenoRoosevelt\CALLBACK_USE_VALUE;

class CallbackArgsTest extends TestCase
{
    public function testCallbackArgsUseValue()
    {
        $args = __args(CALLBACK_USE_VALUE, 1, 2);
        $this->assertEquals([2], $args);
    }

    public function testCallbackArgsUseKey()
    {
        $args = __args(CALLBACK_USE_KEY, 1, 2);
        $this->assertEquals([1], $args);
    }

    public function testCallbackArgsUseBoth()
    {
        $args = __args(CALLBACK_USE_BOTH, 1, 2);
        $this->assertEquals([2, 1], $args);
    }
}
