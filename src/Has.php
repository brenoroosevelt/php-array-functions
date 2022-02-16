<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Determine if all given keys are present in the haystack.
 *
 * @param array $haystack The collection
 * @param string|int $key keys be to checked
 * @param string|int ...$keys keys be to checked
 * @return bool
 */
function has(array $haystack, $key, ...$keys): bool
{
    $keys[] = $key;
    return ! array_diff($keys, array_keys($haystack));
}
