<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Searches the iterable for a given element and returns the first corresponding key (index) if successful
 *
 * @param  iterable $haystack The iterable collection
 * @param  mixed    $element  The searched element
 * @param  bool     $strict   If the third parameter strict is set to true then will also check the types of the needle
 * @return false|int|string the key for needle if it is found in the array, false otherwise.
 */
function index_of(iterable $haystack, $element, bool $strict = true)
{
    if (is_array($haystack)) {
        return array_search($element, $haystack, $strict);
    }

    foreach ($haystack as $index => $value) {
        if (($strict === true && $element === $value)
            || ($strict === false && $element == $value)
        ) {
            return $index;
        }
    }

    return false;
}
