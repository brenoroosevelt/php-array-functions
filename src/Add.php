<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Adds elements to a collection if they don't exist yet (set behavior).
 * The element index (key) is irrelevant for this operation.
 * This function uses strict comparison to determine if element exists
 *
 * @param  array $set         The collection
 * @param  mixed ...$elements Elements to be added
 * @return int The number of items added to the collection
 */
function add(array &$set, ...$elements): int
{
    $added = 0;
    foreach ($elements as $element) {
        if (! in_array($element, $set, true)) {
            $set[] = $element;
            $added++;
        }
    }

    return $added;
}
