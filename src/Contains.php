<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Checks if ALL elements exists in a collection
 * The element index (key) is irrelevant for this operation
 * This function uses strict comparison to determine if element exists
 *
 * @param  iterable $items       The collection
 * @param  mixed    ...$elements The searched elements
 * @return bool True if ALL elements were found in the collection, false otherwise
 */
function contains(iterable $items, ...$elements): bool
{
    foreach ($elements as $element) {
        if (index_of($items, $element) === false) {
            return false;
        }
    }

    return true;
}
