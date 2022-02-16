<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

use Throwable;
use Traversable;

/**
 * @param array|Traversable $haystack
 * @return bool
 */
function is_empty($haystack): bool
{
    $tmp = $haystack;
    try {
        if (is_object($haystack)) {
            $tmp = clone $haystack;
        }
    } catch (Throwable $exception) {
    }

    foreach ($tmp as $item) {
        return false;
    }

    return true;
}
