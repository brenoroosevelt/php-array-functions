<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

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

function contains(iterable $set, $element, bool $strict = true): bool
{
    return index_of($set, $element, $strict) !== false;
}

function contains_all(iterable $set, iterable $elements, bool $strict = true): bool
{
    foreach ($elements as $element) {
        if (! contains($set, $element, $strict)) {
            return false;
        }
    }

    return true;
}

function contains_any(iterable $set, iterable $elements, bool $strict = true): bool
{
    foreach ($elements as $element) {
        if (contains($set, $element, $strict)) {
            return true;
        }
    }

    return false;
}

function add(array &$set, ...$elements): int
{
    $added = 0;
    foreach ($elements as $element) {
        if (! in_array($element, $set, true)) {
            $set[] = $element;
            $added++;
        }
    }

    return $added;
}

function remove(array &$set, ...$elements): int
{
    $removed = 0;
    foreach ($elements as $element) {
        foreach (array_keys($set, $element, true) as $index) {
            unset($set[$index]);
        }
    }

    return $removed;
}

function all(iterable $array, callable $callback, bool $empty_is_valid = false): bool
{
    $count = 0;
    $args = __args($callback);
    foreach ($array as $key => $value) {
        $count++;
        if (true !== call_user_func_array($callback, $args($key, $value))) {
            return false;
        }
    }

    return $empty_is_valid || $count > 0;
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
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
            $count++;
            if ($count >= $n) {
                return true;
            }
        }
    }

    return $count >= $n;
}

function at_most(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count <= $n;
}

function exactly(iterable $array, int $n, callable $callback): bool
{
    $count = 0;
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
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
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
            return $value;
        }
    }

    return $default;
}

function map(iterable $array, callable $callback): array
{
    $result = [];
    $args = __args($callback);
    foreach ($array as $key => $value) {
        $mapped = call_user_func_array($callback, $args($key, $value));
        $result[$key] = $mapped;
    }

    return $result;
}

function accept(iterable $array, callable $callback): array
{
    $result = [];
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function reject(iterable $array, callable $callback): array
{
    $result = [];
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true !== call_user_func_array($callback, $args($key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function has_key(array $array, ...$keys): bool
{
    return !array_diff($keys, array_keys($array));
}

function only_keys(array $array, ...$keys): array
{
    return array_intersect_key($array, array_flip($keys));
}

function except_keys(array $array, ...$keys): array
{
    return array_diff_key($array, array_flip($keys));
}

function column(iterable $array, $column): array
{
    $result = [];
    foreach ($array as $element) {
        if (is_array($element) && array_key_exists($column, $element)) {
            $result[] = $element[$column];
        }
    }

    return $result;
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
    $args = __args($callback);
    foreach ($array as $key => $value) {
        $sum += call_user_func_array($callback, $args($key, $value));
    }

    return $sum;
}

function count_values(iterable $array, callable $callback): int
{
    $count = 0;
    $args = __args($callback);
    foreach ($array as $key => $value) {
        if (true === call_user_func_array($callback, $args($key, $value))) {
            $count++;
        }
    }

    return $count;
}

function group_by(iterable $array, callable $callback): array
{
    $group = [];
    $args = __args($callback);
    foreach ($array as $key => $value) {
        $group[call_user_func_array($callback, $args($key, $value))][] = $value;
    }

    return $group;
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

/** @internal */
function __args(callable $callback): callable
{
    $num_args = (new \ReflectionFunction(\Closure::fromCallable($callback)))->getNumberOfParameters();

    return fn ($k, $v) => $num_args > 1 ? [$v, $k] : [$v];
}
