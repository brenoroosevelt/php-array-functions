<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Tests;

use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\pipe;
use function BrenoRoosevelt\with;

class PipeTest extends TestCase
{
    public function testPipe()
    {
        $payload = new \stdClass();
        $payload->value = 1;
        $result = pipe(
            $payload,
            function ($p) {
                $p->value += 1;
                return $p;
            },
            function ($p) {
                $p->value *= 4;
                return $p;
            },
            function ($p) {
                $p->value -= 3;
                return $p;
            }
        );

        $this->assertSame($payload, $result);
        $this->assertEquals(5, $result->value);
    }

    public function testWith()
    {
        $payload = new \stdClass();
        $payload->value = 1;
        $result = with(
            $payload,
            fn($p) => $p->value += 1,
            fn($p) => $p->value *= 4,
            fn($p) => $p->value -= 3
        );

        $this->assertSame($payload, $result);
        $this->assertEquals(5, $result->value);
    }
}
