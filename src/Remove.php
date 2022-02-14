<?php
declare(strict_types=1);

namespace BrenoRoosevelt;


/**
 * Remove all provided elements from the collection
 * This function uses strict comparison to find and remove elements
 *
 * @example $set = [1, 1, 2, 3, 4]
 * remove($set, 1, 3) will return 3 (int) and $set will contain [2, 4]
 *
 * @param  array $set         The collection
 * @param  mixed ...$elements Elements to be removed
 * @return int The number of removed elements
 */
function remove(array &$set, ...$elements): int
{
    $removed = 0;
    foreach ($elements as $element) {
        foreach (array_keys($set, $element, true) as $index) {
            unset($set[$index]);
        }
    }

    return $removed;
}
