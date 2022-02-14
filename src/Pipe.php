<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * @param mixed $payload
 * @param callable ...$stages
 * @return mixed
 */
function pipe($payload, callable ...$stages)
{
    foreach ($stages as $stage) {
        $payload = $stage($payload);
    }

    return $payload;
}
