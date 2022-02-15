<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * @param array $items
 * @param string $separator
 * @return array
 */
function expand(array $items, string $separator = '.'): array
{
    $result = [];
    foreach ($items as $key => $value) {
        set_path($result, (string) $key, $value, $separator);
    }

    return $result;
}
