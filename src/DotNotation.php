<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

/**
 * @param array $haystack
 * @param string $path
 * @param $value
 * @param string $separator
 * @return void
 */
function set_path(array &$haystack, string $path, $value, string $separator = '.'): void
{
    $path = explode($separator, $path);
    $temp =& $haystack;

    foreach ($path as $key) {
        if (!is_array($temp)) {
            $temp = [];
        }

        $temp =& $temp[$key];
    }

    $temp = $value;
}

/**
 * @param array $haystack
 * @param string $path
 * @param $default
 * @param string $separator
 * @return mixed
 */
function get_path(array $haystack, string $path, $default = null, string $separator = '.')
{
    return
        array_reduce(
            explode($separator, $path),
            fn ($arr, $key) =>
            $default!== $arr && is_array($arr) && array_key_exists($key, $arr) ? $arr[$key] : $default,
            $haystack
        );
}

/**
 * @param array $haystack
 * @param string $path
 * @param string $separator
 * @return void
 */
function unset_path(array &$haystack, string $path, string $separator = '.')
{
    $keys = explode($separator, $path);
    $temp =& $haystack;
    while (count($keys) > 1) {
        $key = array_shift($keys);
        if (array_key_exists($key, $temp) && is_array($temp[$key])) {
            $temp =& $temp[$key];
        }
    }

    unset($temp[array_shift($keys)]);
}

/**
 * @param array $haystack
 * @param string $path
 * @param string $separator
 * @return bool
 */
function has_path(array $haystack, string $path, string $separator = '.'): bool
{
    $keys = explode($separator, $path);
    $temp = $haystack;
    foreach ($keys as $key) {
        if (! is_array($temp) || ! array_key_exists($key, $temp)) {
            return false;
        }

        $temp = $temp[$key];
    }

    return true;
}
