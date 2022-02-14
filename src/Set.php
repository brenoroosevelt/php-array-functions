<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Adds or replace an element to a collection using an optional key/index.
 * If the given key already exists in the collection, the corresponding value will be replaced by the element
 *
 * @example $set = ['a' => 1, 2, 3, 4]
 * set($set, 2, 'a') $set will contain ['a' => 2, 2, 3, 4]
 *
 * @example $set = ['a' => 1, 2, 3, 4]
 * set($set, 1) $set will contain ['a' => 1, 2, 3, 4, 1]
 *
 * @param  array      $set     The collection
 * @param  mixed      $element The element to be added
 * @param  string|int $key     The key/index of element
 * @return void
 */
function set(array &$set, $element, $key = null): void
{
    if ($key !== null) {
        $set[$key] = $element;
    } else {
        $set[] = $element;
    }
}
