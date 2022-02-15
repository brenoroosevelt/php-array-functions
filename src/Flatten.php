<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

/**
 * @param array $items
 * @param string|null $pathSeparator
 * @return array
 */
function flatten(array $items, ?string $pathSeparator = null): array
{
    $result = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($items));
    foreach ($iterator as $leafValue) {
        $keys = [];
        foreach (range(0, $iterator->getDepth()) as $depth) {
            $keys[] = $iterator->getSubIterator($depth)->key();
        }

        if (! empty($pathSeparator)) {
            $result[join($pathSeparator, $keys) ] = $leafValue;
        } else {
            $result[] = $leafValue;
        }
    }

    return $result;
}
