<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Returns a subset of the collection with elements that match given keys.
 * The keys are preserved
 *
 * @param array $items The collection
 * @param mixed ...$keys keys to be filtered
 * @return array
 */
function only(array $items, ...$keys): array
{
    return array_intersect_key($items, array_flip($keys));
}
