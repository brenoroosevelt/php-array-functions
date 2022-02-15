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
//
//    $key = trim($path, $separator);
//    $keys = explode($separator, $key);
//    if (empty($keys)) {
//        return;
//    }
//
//    $target = &$haystack;
//    foreach ($keys as $innerKey) {
//        if (! is_array($target)) {
//            break;
//        }
//
//        if (! array_key_exists($innerKey, $target)) {
//            $target[$innerKey] = [];
//        }
//
//        $target = &$target[$innerKey];
//    }
//
//    $target = $value;
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
            fn ($arr, $p) => is_array($arr) && array_key_exists($p, $arr) ? $arr[$p] : $default,
            $haystack
        );

//    $path = explode($separator, $path); //if needed
//    $temp =& $haystack;
//
//    foreach($path as $key) {
//        $temp =& $temp[$key];
//    }
//
//    return $temp;
//
//    $key = trim($path, $separator);
//    $keys = explode($separator, $key);
//    if (empty($keys)) {
//        return $default;
//    }
//
//    $target = $haystack;
//    foreach ($keys as $innerKey) {
//        if (! is_array($target) || ! array_key_exists($innerKey, $target)) {
//            return $default;
//        }
//
//        $target = $target[$innerKey];
//    }
//
//    return $target;
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
