<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Returns a subset of the collection with elements that do not match given keys.
 * The keys are preserved
 *
 * @param array $items The collection
 * @param mixed ...$keys keys to be filtered
 * @return array
 */
function except(array $items, ...$keys): array
{
    return array_diff_key($items, array_flip($keys));
}
