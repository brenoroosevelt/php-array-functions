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

/**
 * @param $value
 * @param callable ...$jobs
 * @return mixed returns the value
 */
function with(&$value, callable ...$jobs)
{
    foreach ($jobs as $job) {
        $job($value);
    }

    return $value;
}
