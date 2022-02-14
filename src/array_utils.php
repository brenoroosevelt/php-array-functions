<?php
declare(strict_types=1);

namespace BrenoRoosevelt;

const CALLBACK_USE_VALUE = 0;
const CALLBACK_USE_KEY = 1;
const CALLBACK_USE_BOTH = 2;

function index_of(iterable $items, $element, bool $strict = true)
{
    if (is_array($items)) {
        return array_search($element, $items, $strict);
    }

    foreach ($items as $index => $value) {
        if (($strict === true && $element === $value) ||
            ($strict === false && $element == $value)
        ) {
            return $index;
        }
    }

    return false;
}

function contains(iterable $items, $element, bool $strict = true): bool
{
    return index_of($items, $element, $strict) !== false;
}

function contains_all(iterable $items, iterable $elements, bool $strict = true): bool
{
    foreach ($elements as $element) {
        if (! contains($items, $element, $strict)) {
            return false;
        }
    }

    return true;
}

function contains_any(iterable $items, iterable $elements, bool $strict = true): bool
{
    foreach ($elements as $element) {
        if (contains($items, $element, $strict)) {
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

function set(array &$set, $element, $key = null): void
{
    if ($key !== null) {
        $set[$key] = $element;
    } else {
        $set[] = $element;
    }
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

function remove_key(array &$set, ...$keys): int
{
    $removed = 0;
    foreach ($keys as $key) {
        if (array_key_exists($key, $set)) {
            unset($set[$key]);
            $removed++;
        }
    }

    return $removed;
}

function pull(array &$set, $key, $default = null)
{
    $value = $set[$key] ?? $default;
    unset($set[$key]);

    return $value;
}

function reindex(array &$items): void
{
    $items = array_values($items);
}

function all(iterable $items, callable $callback, bool $empty_is_valid = true, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        $count++;
        if (true !== call_user_func_array($callback, __args($mode, $key, $value))) {
            return false;
        }
    }

    return $empty_is_valid || $count > 0;
}

function some(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    return at_least(1, $items, $callback, $mode);
}

function none(iterable $items, callable $callback, int $mode = 0): bool
{
    return ! some($items, $callback, $mode);
}

function at_least(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count >= $n) {
                return true;
            }
        }
    }

    return $count >= $n;
}

function at_most(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count <= $n;
}

function exactly(int $n, iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): bool
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
            if ($count > $n) {
                return false;
            }
        }
    }

    return $count === $n;
}

function first(iterable $items, callable $callback, $default = null, int $mode = CALLBACK_USE_VALUE)
{
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            return $value;
        }
    }

    return $default;
}

function head(iterable $items, $default = null)
{
    foreach ($items as $value) {
        return $value;
    }

    return $default;
}

function map(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        $result[$key] = call_user_func_array($callback, __args($mode, $key, $value));
    }

    return $result;
}

function accept(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function reject(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $result = [];
    foreach ($items as $key => $value) {
        if (true !== call_user_func_array($callback, __args($mode, $key, $value))) {
            $result[$key] = $value;
        }
    }

    return $result;
}

function has(array $items, ...$keys): bool
{
    return ! array_diff($keys, array_keys($items));
}

function only(array $items, ...$keys): array
{
    return array_intersect_key($items, array_flip($keys));
}

function except(array $items, ...$keys): array
{
    return array_diff_key($items, array_flip($keys));
}

function column(iterable $items, $column): array
{
    $result = [];
    foreach ($items as $element) {
        if (is_array($element) && array_key_exists($column, $element)) {
            $result[] = $element[$column];
        }
    }

    return $result;
}

function paginate(array $items, int $page, int $per_page, bool $preserve_keys = true): array
{
    $offset = max(0, ($page - 1) * $per_page);

    return array_slice($items, $offset, $per_page, $preserve_keys);
}

function sum_values(iterable $items, callable $callback, int $mode = 0)
{
    $sum = 0;
    foreach ($items as $key => $value) {
        $sum += call_user_func_array($callback, __args($mode, $key, $value));
    }

    return $sum;
}

function count_values(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): int
{
    $count = 0;
    foreach ($items as $key => $value) {
        if (true === call_user_func_array($callback, __args($mode, $key, $value))) {
            $count++;
        }
    }

    return $count;
}

function max_value(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE)
{
    $max = null;
    foreach ($items as $item) {
        $max = $item;

        break;
    }

    foreach ($items as $key => $value) {
        $value = call_user_func_array($callback, __args($mode, $key, $value));
        if ($value > $max) {
            $max = $value;
        }
    }

    return $max;
}

function min_value(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE)
{
    $min = null;
    foreach ($items as $item) {
        $min = $item;

        break;
    }

    foreach ($items as $key => $value) {
        $value = call_user_func_array($callback, __args($mode, $key, $value));
        if ($value < $min) {
            $min = $value;
        }
    }

    return $min;
}

function group_by(iterable $items, callable $callback, int $mode = CALLBACK_USE_VALUE): array
{
    $group = [];
    foreach ($items as $key => $value) {
        $group[call_user_func_array($callback, __args($mode, $key, $value))][] = $value;
    }

    return $group;
}

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

function expand(array $items, string $separator = '.'): array
{
    $result = [];
    foreach ($items as $key => $value) {
        set_path($result, (string) $key, $value, $separator);
    }

    return $result;
}

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

function pipe($payload, callable ...$stages)
{
    foreach ($stages as $stage) {
        $payload = $stage($payload);
    }

    return $payload;
}

/** @internal */
function __args(int $mode, $k, $v): array
{
    $args[CALLBACK_USE_KEY] = [$k];
    $args[CALLBACK_USE_BOTH] = [$v, $k];

    return $args[$mode] ?? [$v];
}
