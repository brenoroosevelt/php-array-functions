<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * Pulls and returns an element by key
 *
 * @param array $set The array containing the elements/keys
 * @param string|int $key The key to be pulled
 * @param mixed $default default value that will be returned if the key does not exist
 * @return mixed|null pulled element or `default` parameter
 */
function pull(array &$set, $key, $default = null)
{
    $value = $set[$key] ?? $default;
    unset($set[$key]);

    return $value;
}
