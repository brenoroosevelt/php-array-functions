<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

const CALLBACK_USE_VALUE = 0;
const CALLBACK_USE_KEY = 1;
const CALLBACK_USE_BOTH = 2;

/**
 * @internal
 */
function __args(int $mode, $k, $v): array
{
    $args = [];
    $args[CALLBACK_USE_KEY] = [$k];
    $args[CALLBACK_USE_BOTH] = [$v, $k];

    return $args[$mode] ?? [$v];
}
