<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

function all(iterable $array, callable $callback): bool
{
    foreach ($array as $key => $value) {
        if (true !== call_user_func_array($callback, [$value, $key])) {
            return false;
        }
    }

    return true;
}

function some(iterable $array, callable $callback): bool
{
    return at_least($array, 1, $callback);
}

function none(iterable $array, callable $callback): bool
{
    return ! some($array, $callback);
}

function at_least(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count >= $n) {
                return true;
            }
        }
    }

    return false;
}

function at_most(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return true;
}

function exactly(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count === $n;
}

function first(iterable $array, callable $callback, $default = null)
{
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            return $value;
        }
    }

    return $default;
}

function map(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    $result = [];
    foreach ($array as $key => $value) {
        $mapped = call_user_func_array($callback, [$value, $key]);
        if ($preserveKeys) {
            $result[$key] = $mapped;
        } else {
            $result[] = $mapped;
        }
    }

    return $result;
}

function each(iterable $array, callable $callback, bool $stoppable = true): void
{
    foreach ($array as $key => $value) {
        $result = call_user_func_array($callback, [$value, $key]);
        if ($result !== true && $stoppable) {
            break;
        }
    }
}

function accept(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    $result = [];
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            if ($preserveKeys) {
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function reject(iterable $array, callable $callback, bool $preserveKeys = true): array
{
    return accept($array, fn ($v, $k) => ! call_user_func_array($callback, [$v, $k]), $preserveKeys);
}

function index_of(iterable $array, $element, bool $strict = true)
{
    if (is_array($array)) {
        return array_search($element, $array, $strict);
    }

    foreach ($array as $index => $value) {
        if (($strict === true && $element === $value) ||
            ($strict === false && $element == $value)
        ) {
            return $index;
        }
    }

    return false;
}

function remove_first(array &$array, $element, bool $strict = true): bool
{
    $index = index_of($array, $element, $strict);
    if ($index !== false) {
        unset($array[$index]);

        return true;
    }

    return false;
}

function remove_all(array &$array, $element, bool $strict = true): int
{
    $removed = 0;
    while (false !== ($index = index_of($array, $element, $strict))) {
        unset($array[$index]);
        $removed++;
    }

    return $removed;
}

function only_keys(iterable $array, array $keys): array
{
    return accept($array, fn ($v, $k) => in_array($k, $keys));
}

function except_keys(iterable $array, array $keys): array
{
    return accept($array, fn ($v, $k) => ! in_array($k, $keys));
}

function paginate(array $array, int $page, int $per_page, bool $preserve_keys = true): array
{
    $offset = max(0, ($page - 1) * $per_page);

    return array_slice($array, $offset, $per_page, $preserve_keys);
}

/**
 * @param iterable $array
 * @param callable $callback thar returns an int|float
 * @return int|float
 */
function sum_values(iterable $array, callable $callback)
{
    $sum = 0;
    foreach ($array as $key => $value) {
        $sum += call_user_func_array($callback, [$value, $key]);
    }

    return $sum;
}

function count_values(iterable $array, callable $callback): int
{
    $count = 0;
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, [$value, $key])) {
            $count++;
        }
    }

    return $count;
}

function flatten(array $array, ?string $separator = null)
{
    $result = [];
    $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
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

function expand(array $array, string $separator = '.'): array
{
    $result = [];
    foreach ($array as $key => $value) {
        set_path($result, (string) $key, $value, $separator);
    }

    return $result;
}

function set_path(array &$array, string $path, $value, string $separator = '.'): void
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return;
    }

    $target = &$array;
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

function get_path(array $array, string $path, $default = null, string $separator = '.')
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return $default;
    }

    $target = $array;
    foreach ($keys as $innerKey) {
        if (! is_array($target) || ! array_key_exists($innerKey, $target)) {
            return $default;
        }

        $target = $target[$innerKey];
    }

    return $target;
}

function unset_path(array &$array, string $path, string $separator = '.')
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return;
    }

    $target = &$array;
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

function has_path(array $array, string $path, string $separator = '.'): bool
{
    $key = trim($path, $separator);
    $keys = explode($separator, $key);
    if (empty($keys)) {
        return false;
    }

    $target = $array;
    foreach ($keys as $innerKey) {
        if (! is_array($target) || ! array_key_exists($innerKey, $target)) {
            return false;
        }

        $target = $target[$innerKey];
    }

    return true;
}
