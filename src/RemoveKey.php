<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Remove elements by keys
 *
 * @param array $set The collection
 * @param string|int ...$keys The keys to be removed
 * @return int The number of removed elements
 */
function remove_key(array &$set, ...$keys): int
{
    $removed = 0;
    foreach ($keys as $key) {
        if (array_key_exists($key, $set)) {
            unset($set[$key]);
            $removed++;
        }
    }

    return $removed;
}
