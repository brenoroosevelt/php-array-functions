<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * @param array $items
 * @param string|null $separator
 * @return array
 */
function flatten(array $items, ?string $separator = null)
{
    $result = [];
    $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($items));
    foreach ($iterator as $leafValue) {
        $keys = [];
        foreach (range(0, $iterator->getDepth()) as $depth) {
            $keys[] = $iterator->getSubIterator($depth)->key();
        }

        if (! empty($separator)) {
            $result[join($separator, $keys) ] = $leafValue;
        } else {
            $result[] = $leafValue;
        }
    }

    return $result;
}

/**
 * @param array $items
 * @param string $separator
 * @return array
 */
function expand(array $items, string $separator = '.'): array
{
    $result = [];
    foreach ($items as $key => $value) {
        set_path($result, (string) $key, $value, $separator);
    }

    return $result;
}

/**
 * @param array $haystack
 * @param string $path
 * @param $value
 * @param string $separator
 * @return void
 */
function set_path(array &$haystack, string $path, $value, string $separator = '.'): void
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return;
    }

    $target = &$haystack;
    foreach ($keys as $innerKey) {
        if (! is_array($target)) {
            break;
        }

        if (! array_key_exists($innerKey, $target)) {
            $target[$innerKey] = [];
        }

        $target = &$target[$innerKey];
    }

    $target = $value;
}

/**
 * @param array $haystack
 * @param string $path
 * @param $default
 * @param string $separator
 * @return array|mixed|null
 */
function get_path(array $haystack, string $path, $default = null, string $separator = '.')
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return $default;
    }

    $target = $haystack;
    foreach ($keys as $innerKey) {
        if (! is_array($target) || ! array_key_exists($innerKey, $target)) {
            return $default;
        }

        $target = $target[$innerKey];
    }

    return $target;
}

/**
 * @param array $haystack
 * @param string $path
 * @param string $separator
 * @return void
 */
function unset_path(array &$haystack, string $path, string $separator = '.')
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return;
    }

    $target = &$haystack;
    foreach ($keys as $innerKey) {
        if (! is_array($target)) {
            break;
        }

        if (array_key_exists($innerKey, $target)) {
            $target = &$target[$innerKey];
        }
    }

    unset($target);
}

/**
 * @param array $haystack
 * @param string $path
 * @param string $separator
 * @return bool
 */
function has_path(array $haystack, string $path, string $separator = '.'): bool
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return false;
    }

    $target = $haystack;
    foreach ($keys as $innerKey) {
        if (! is_array($target) || ! array_key_exists($innerKey, $target)) {
            return false;
        }

        $target = $target[$innerKey];
    }

    return true;
}
