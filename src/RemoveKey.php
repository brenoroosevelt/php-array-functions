<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Remove elements by keys
 *
 * @param array $set The collection
 * @param string|int $key The key to be removed
 * @param string|int ...$keys The keys to be removed
 * @return int The number of removed elements
 */
function remove_key(array &$set, $key, ...$keys): int
{
    $removed = 0;
    $keys[] = $key;
    foreach ($keys as $key) {
        if (array_key_exists($key, $set)) {
            unset($set[$key]);
            $removed++;
        }
    }

    return $removed;
}
